<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

/**
 * Rally Defect Plugin for TestRail
 *
 * Copyright Gurock Software GmbH. All rights reserved.
 *
 * This is the TestRail defect plugin for Rally. Please see
 * http://docs.gurock.com/testrail-integration/defects-plugins for
 * more information about TestRail's defect plugins.
 *
 * http://www.gurock.com/testrail/
 */

class Rally_defect_plugin extends Defect_plugin
{
	const DASH = '&ndash;';
	const DEFAULT_KEY_PLACE_HOLDER = 'api_key';
	private $_api;
	private $_address;
	private $_user;
	private $_password;
	private $_key;
	private $_config;
	private $_defaultFields = [
		'summary' => 'on',
		'project' => 'on',
		'state' => 'on',
		'schedulestate' => 'on',
		'priority' => 'on',
		'severity' => 'on',
		'owner' => 'on',
		'release' => 'on',
		'environment' => 'on',
		'foundinbuild' => 'on',
		'description' => 'on',
		'attachments' => 'on'
	];
	private $_fieldDefaults = [
		'summary' => [
			'type' => 'string',
			'label' => 'Summary',
			'size' => 'full',
			'required' => true
		],
		'project' => [
			'type' => 'dropdown',
			'label' => 'Project',
			'required' => true,
			'remember' => true,
			'cascading' => true,
			'size' => 'compact',
		],
		'state' => [
			'type' => 'dropdown',
			'label' => 'State',
			'required' => true,
			'remember' => true,
			'size' => 'compact',
		],
		'schedulestate' => [
			'type' => 'dropdown',
			'label' => 'Schedule State',
			'required' => true,
			'remember' => true,
			'size' => 'compact',
		],
		'priority' => [
			'type' => 'dropdown',
			'label' => 'Priority',
			'required' => false,
			'remember' => true,
			'size' => 'compact',
		],
		'severity' => [
			'type' => 'dropdown',
			'label' => 'Severity',
			'required' => false,
			'remember' => true,
			'size' => 'compact',
		],
		'owner' => [
			'type' => 'dropdown',
			'label' => 'Owner',
			'required' => false,
			'remember' => true,
			'depends_on' => 'project',
			'size' => 'compact'
		],
		'release' => [
			'type' => 'dropdown',
			'label' => 'Release',
			'required' => false,
			'remember' => true,
			'depends_on' => 'project',
			'size' => 'compact'
		],
		'environment' => [
			'type' => 'dropdown',
			'label' => 'Environment',
			'required' => false,
			'remember' => true,
			'size' => 'compact'
		],
		'foundinbuild' => [
			'type' => 'string',
			'label' => 'Found In Build',
			'required' => false,
			'remember' => false,
			'size' => 'compact'
		],
		'description' => [
			'type' => 'text',
			'label' => 'Description',
			'required' => false,
			'rows' => 10
		],
		'attachments' => [
			'type' => 'dropbox',
			'label'=>'attachments',
			'required' => false,
			'size' => 'none'
		],
	];
	private $_hoverDefaultFields = [
		'summary'	=> 'on',
		'project' => 'on',
		'state' => 'on',
		'schedulestate' => 'on',
		'priority' => 'on',
		'severity' => 'on',
		'owner' => 'on',
		'release' => 'on',
		'environment' => 'on',
		'foundinbuild' => 'on',
		'description' => 'on'
	];
	private static $_meta = [
		'author' => 'Gurock Software',
		'version' => '1.0',
		'description' => 'Rally defect plugin for TestRail',
		'can_push' => true,
		'can_lookup' => true,
		'default_config' =>
			'; Please configure your Rally connection below.
; Either an API key, or user/password are required, but not both.
; Note: requires Rally API v1.40 or later.
[connection]
address=https://<your-server>/
key=api_key
user=testrail
password=secret
workspace=Acme

[push.fields]
project=on
state=on
schedulestate=on
priority=on
severity=on
owner=on
release=on
environment=on
foundinbuild=on
description=on
attachments=on

[hover.fields]
project=on
state=on
schedulestate=on
priority=on
severity=on
owner=on
release=on
environment=on
foundinbuild=on
description=on'
];

	public function get_meta()
	{
		return self::$_meta;
	}

	// *********************************************************
	// CONSTRUCT / DESTRUCT
	// *********************************************************

	public function __destruct()
	{
		if ($this->_api) {
			$api = $this->_api;
			$this->_api = null;
		}
	}

	// *********************************************************
	// CONFIGURATION
	// *********************************************************

	public function validate_config($config)
	{
		$ini = ini::parse($config);

		if (empty($ini['connection'])) {
			throw new ValidationException('Missing [connection] group');
		}

		// Check required values for existance
		foreach (['address', 'workspace'] as $key) {
			if (empty($ini['connection'][$key]) ||
				!$ini['connection'][$key]) {
				throw new ValidationException(
					"Missing configuration for key '$key'"
				);
			}
		}

		$iniConnection = $ini['connection'];

		if (
			(
				empty($iniConnection['key'])
				|| $iniConnection['key'] === static::DEFAULT_KEY_PLACE_HOLDER
			)
			&&
			(
				empty($iniConnection['user'])
				|| empty($iniConnection['password'])
			)
		) {
			throw new ValidationException(
				'Either an API key, or user/password are required'
			);
		}

		$address = $ini['connection']['address'];

		// Check whether the address is a valid url (syntax only)
		if (!check::url($address)) {
			throw new ValidationException('Address is not a valid url');
		}

		$this->_ensure_valid_fields('push.fields', $ini);
		$this->_ensure_valid_fields('hover.fields', $ini);
	}

    /**
     * Ensure Valid fields
     *
     * Validate all push and hover fields which are set '=on'
     *
     * @param string $fieldList Field name.
     * @param array  $ini       API configration.
     *
     * @return void
     */
    private function _ensure_valid_fields(string $fieldList, array $ini)
    {
        $fields = $ini[$fieldList] ?? [];
        foreach ($fields as $field => $option) {
            if ($option === 'on') {
                $this->_validate_field($ini, $field);
            }
        }
        if ($fieldList === 'push.fields' && !empty($fields)) {
            foreach (['project', 'state', 'schedulestate'] as $requiredField) {
                if (!$this->_isConfigFieldOn($fields, $requiredField)) {
                    throw new ValidationException(
                        'In [push.fields], ' . $requiredField . '=on is required.'
                    );
                }
            }
        }
    }

    /**
     * Is Config Field On
     *
     * Checks if given field is on.
     *
     * @param array  $fieldList Configured field list.
     * @param string $target    Target field to check.
     *
     * @return bool
     */
    private function _isConfigFieldOn(array $fieldList, string $target): bool
    {
        return isset($fieldList[$target]) && $fieldList[$target] === 'on';
    }

	/**
	 * Validate field
	 * Validate custom and default fields and if
	 * invalid field found then thows error.
	 *
	 * @param array  $ini   API configration.
	 * @param string $field Field name.
	 *
	 * @return void
	 *
	 * @throws ValidationException
	 */
	private function _validate_field(array $ini, string $field)
	{
		$valid_types = [
			'dropdown' => true,
			'multiselect' => true,
			'text' => true,
			'string' => true,
			'date' => true
		];
		$category = arr::get($ini, "field.settings.$field");
		// Custom fields must always have a separate category.
		if (str::starts_with($field, 'c_')) {
			if (!$category) {
				throw new ValidationException(
					str::format(
						'Field "{0}" is enabled but configuration ' .
						'section [field.settings.{0}] is missing',
						$field
						)
				);
			}
        }
        if ($category) {
            foreach (['label', 'type'] as $key) {
                if (!isset($category[$key])) {
                    throw new ValidationException(
                        str::format(
                            'Missing configuration for key "{0}" in ' .
                            'section [field.settings.{1}]',
                            $key,
                            $field
                        )
                    );
                } elseif (str::starts_with($field, 'c_')
                    && !isset($category['list_type'])
                    && in_array($category['type'], ['dropdown', 'multiselect', 'date'])
                ) {
                    throw new ValidationException(
                        str::format(
                            'Missing "{0}" key configuration for '
                                . 'section [field.settings.{1}]',
                            'list_type',
                            $field
                        )
                    );
                } else {
                    // NOP
                }
            }
        }
		// The specified type must be well-known.
		$type = arr::get($category, 'type');
		if ($type && !isset($valid_types[str::to_lower($type)])) {
			throw new ValidationException(
				str::format(
					'Invalid field type specified in section ' .
					'[filed.settings.{0}]',
					$field
				)
			);
		}
	}

	public function configure($config)
	{
		$ini = ini::parse($config);
		$this->_address = str::slash($ini['connection']['address']);
		$this->_user = $ini['connection']['user'];
		$this->_password = $ini['connection']['password'];
		$this->_workspace = $ini['connection']['workspace'];
		$this->_key = !empty($ini['connection']['key']) ?? $ini['connection']['key'];
		$this->_config = $ini;
	}

	// *********************************************************
	// API / CONNECTION
	// *********************************************************

	private function _get_api()
	{
		if ($this->_api) {
			return $this->_api;
		}

		$this->_api = new Rally_api(
			$this->_address,
			$this->_user,
			$this->_password,
			$this->_config,
			$this->_key
		);

		return $this->_api;
	}

	// *********************************************************
	// PUSH
	// *********************************************************
	/**
	 * Prepare Push
	 * Creates an array of objects of default field
	 * with default and user defined configuration.
	 *
	 * @param array|object $context default configuration.
	 *
	 * @return array
	 */
	public function prepare_push($context): array
	{
		$fields = [];
		$fieldsConfig = isset($this->_config['push.fields'])
			?
				[
					'summary' => 'on',
					'project' => 'on',
					'state' => 'on',
					'schedulestate' => 'on'
				] + $this->_config['push.fields']
			: $this->_defaultFields;
		// based on the configuration of the defect plugin.
		foreach ($fieldsConfig as $fieldName => $option) {
			if ($option !== 'on') {
				continue;
			}
			$field = $this->_fieldDefaults[$fieldName] ?? [];
			$category = arr::get(
				$this->_config,
				"field.settings.$fieldName"
			);
			foreach ($category ?? [] as $prop => $val) {
				$property = str::to_lower($prop);
				$value = str::to_lower($val);
				if ($property === 'label') {
					$field[$property] = $val;
					continue;
				}
				if (in_array($property, ['required', 'remember', 'cascading'])) {
					$finalValue = $value === 'true';
				} elseif ($property === 'rows') {
					$finalValue = (int) $value;
				} else {
					$finalValue = $value;
				}
				// This may override the default value from above.
				$field[$property] = $finalValue;
					}
					if ($field['type'] === 'date') {
						$field['type'] = 'string';
						$field['description'] = 'Example: 2020-05-07';
					}
					$fields[$fieldName] = $field;
		}
		$result = ['fields' => $fields];
		// Save the form for later use in prepare_field().
		$this->_form = $result;

		return $result;
	}

	private function _get_summary_default($context)
	{
		return 'Failed test: '
			. current($context['tests'])->case->title
			. 	(
					$context['test_count'] > 1
						? ' (+others)'
						: ''
				);
	}

	private function _get_description_default($context)
	{
		return $context['test_change']->description;
	}

	private function _to_id_name_lookup($items)
	{
		$result = [];
		foreach ($items as $item) {
			$result[$item->id] = $item->name;
		}

		return $result;
	}

	public function prepare_field($context, $input, $field)
	{
		$data = [];

		// Process those fields that do not need a connection to the
		// Rally installation.
		if (in_array($field, ['summary', 'description'])) {
			$data['default'] = $field === 'summary'
				? $this->_get_summary_default($context)
				: $this->_get_description_default($context);

			return $data;
		}

		// Take into account the preferences of the user, but only
		// for the initial form rendering (not for dynamic loads).

		$prefs = $context['event'] === 'prepare'
			? arr::get($context, 'preferences')
			: null;

		// And then try to connect/login (in case we haven't set up a
		// working connection previously in this request) and process
		// the remaining fields.
		$api = $this->_get_api();

		switch ($field) {
			case 'release':
				$data['default'] = arr::get($prefs, 'release');
				$data['options'] = $this->_to_id_name_lookup(
					$api->get_releases(
						$this->_get_workspace_or_fail($api),
						$input['project']
					)
				);
				break;

			case 'environment':
				$data['default'] = arr::get($prefs, 'environment');
				$data['options'] = $this->_to_id_name_lookup(
					$api->get_environments(
						$this->_get_workspace_or_fail($api)
					)
				);
				break;

			case 'owner':
				$data['default'] = arr::get($prefs, 'owner');
				$data['options'] = $this->_to_id_name_lookup(
					$api->get_owners(
						$this->_get_workspace_or_fail($api)
					)
				);
				break;

			case 'priority':
				$data['default'] = arr::get($prefs, 'priority');
				$data['options'] = $this->_to_id_name_lookup(
					$api->get_priorities(
						$this->_get_workspace_or_fail($api)
					)
				);
				break;

			case 'project':
				$data['default'] = arr::get($prefs, 'project');
				$data['options'] =  $this->_to_id_name_lookup(
					$api->get_projects(
						$this->_get_workspace_or_fail($api)
					)
				);
				break;

			case 'schedulestate':
				$data['default'] = arr::get($prefs, 'schedulestate');
				$data['options'] = $this->_to_id_name_lookup(
					$api->get_schedulestates(
						$this->_get_workspace_or_fail($api)
					)
				);
				break;

			case 'severity':
				$data['default'] = arr::get($prefs, 'severity');
				$data['options'] =  $this->_to_id_name_lookup(
					$api->get_severities(
						$this->_get_workspace_or_fail($api)
					)
				);
				break;

			case 'state':
				$data['default'] = arr::get($prefs, 'state');
				$data['options'] = $this->_to_id_name_lookup(
					$api->get_states(
						$this->_get_workspace_or_fail($api)
					)
				);
				break;
		}
		if (str::starts_with($field, 'c_')) {
			$data['default'] = arr::get($prefs, $field);
			$category = arr::get($this->_config, "field.settings.$field");
			if (isset($category['list_type'])
				&& in_array($category['type'], ['dropdown', 'multiselect'])
			) {
				if ($category['list_type'] === 'checkbox') {
					$optionValue = [
						'False' => 'False',
						'True' => 'True'
					];
				} elseif ($category['list_type'] === 'user') {
					$optionValue = $this->_to_id_name_lookup(
						$api->get_owners(
							$this->_get_workspace_or_fail($api)
						)
					);
				} else {
					$optionValue = $this->_to_id_name_lookup(
						$api->getCustomFields(
							$this->_get_workspace_or_fail($api),
							$category
						)
					);
				}
				$data['options'] = $optionValue;
			}
		}
		if (arr::get($this->_form, 'fields')[$field]['type'] === 'dropdown'
			&& is_array(arr::get($data, 'default'))
		) {
			$data['default'] = '';
		}

		return $data;
	}

	private function _get_workspace_or_fail($api)
	{
		$workspace = $api->get_workspace($this->_workspace);
		if (empty($workspace)) {
			ex::raisef(
				'RallyException',
				'Workspace "{0}" not found. ' .
				'Please enter a valid Rally workspace.',
				$this->_workspace
			);
		}

		return $workspace;
	}

	public function push($context, $input, array $paths = [])
	{
		return ($this->_get_api())->add_issue($input, $paths);
	}


	// *********************************************************
	// LOOKUP
	// *********************************************************
	/**
	 * Creates an array of objects of default field with default and
	 * user defined configuration to display on hover popup.
	 *
	 * @param int $defectId Defect id of an issue.
	 *
	 * @return array
	 */
	public function lookup($defectId)
	{
		$api = $this->_get_api();
		$issue = $api->get_issue($defectId);
		$status_id = GI_DEFECTS_STATUS_OPEN;
		$status = $description = null;
		if (isset($issue->State)) {
			$status = $issue->State;
			$status_id = $status === 'Fixed'
					? GI_DEFECTS_STATUS_RESOLVED
					: GI_DEFECTS_STATUS_CLOSED;
		}

		if (!empty($issue->Description)) {
			$description = str::format(
				'<div class="monospace">{0}</div>',
				$issue->Description
			);
		}

        $attributes = [];
        $fullAttributes = [];
        $attributes['Workspace'] = isset($issue->Workspace) ? h($issue->Workspace->_refObjectName) : static::DASH;
        $attributes['Status'] = isset($status) ? h($status) : static::DASH;
        $hoverFields = $this->_config['hover.fields'] ?? $this->_hoverDefaultFields;
        foreach ($hoverFields as $fieldName => $value) {
            if ($value !== 'on'|| in_array($fieldName, ['summary', 'description', 'attachments'])) {
                continue;
            }
            $category = arr::get($this->_config, "field.settings.$fieldName") ?? $this->_fieldDefaults[$fieldName];
            if (str::starts_with($fieldName, 'c_')) {
                $fieldName = $category['field_name'];
                if ($category['type'] === 'multiselect'
                    && isset($issue->$fieldName->_tagsNameArray)) {
                    $multiselectValues = [];
                    foreach ($issue->$fieldName->_tagsNameArray ?? [] as $tagName) {
                        $multiselectValues[] = $tagName->Name;
                    }
                    $value = implode(',', $multiselectValues);
                } elseif (isset($category['list_type']) && isset($issue->$fieldName)) {
                    if ($category['list_type'] === 'date') {
                        $value = date::format_short_date(
                            strtotime($issue->$fieldName)
                        );
                    } elseif ($category['list_type'] === 'checkbox') {
                        $value = $issue->$fieldName ? 'True' : 'False';
                    } elseif ($category['list_type'] === 'user') {
                        $value = $issue->$fieldName->_refObjectName;
                    } else {
                        $value = $issue->$fieldName;
                    }
                } else {
                    $value = isset($issue->$fieldName) ? $issue->$fieldName : static::DASH;
                }
            } else {
                $defaultLabel = $this->_fieldDefaults[$fieldName]['label'];
                if (in_array($fieldName, ['owner', 'project', 'release'])) {
                    $value = isset($issue->$defaultLabel->_refObjectName) ? h($issue->$defaultLabel->_refObjectName) : static::DASH;
                } else {
                    $fieldValueForAPI = str_replace(' ', '', $this->_fieldDefaults[$fieldName]['label']);
                    $value = isset($issue->$fieldValueForAPI)? h($issue->$fieldValueForAPI) : static::DASH;
                }
            }
            if (in_array($category['type'], ['text', 'string'])
                && (!isset($category['size']) || $category['size'] === 'full')
                && isset($value)
            ) {
                $fullAttributes[$category['label']] = str::format(
                    '<div class="monospace">{0}</div>',
                    strip_tags(html_entity_decode($value))
                );
            } else {
                $attributes[$category['label']] = $value;
            }
        }

        return [
            'id' => $defectId,
            'url' => str::format(
                '{0}#/detail/defect/{1}',
                $this->_address,
                $issue->ObjectID
            ),
            'title' => $issue->_refObjectName,
            'status_id' => $status_id,
            'status' => $status,
            'description' => $description,
            'attributes' => $attributes,
            'fullAttributes' => $fullAttributes
        ];
    }
}

/**
 * Rally REST API
 *
 * Wrapper class for the Rally API with functions for retrieving
 * projects, getting and adding issues etc.
 */
class Rally_api
{
	private $_address;
	private $_curl;
	private $_user;
	private $_password;
	private $_key;
	private $_workspace;
	private $_environment = [];
	private $_owners = [];
	private $_priorities = [];
	private $_project_object = [];
	private $_schedulestates = [];
	private $_severities = [];
	private $_states = [];
	private $_config;

	/**
	 * Construct
	 *
	 * Initializes a new Rally API object. Expects the web address of
	 * the Rally installation including http or https prefix.
	 */
	public function __construct($address, $user, $password, $config, $key)
	{
		$this->_address = str::slash($address);
		$this->_user = $user;
		$this->_password = $password;
		$this->_config = $config;
		$this->_key = $key;
	}

	/**
	 * Helper function to sort any array by name that contains objects
	 * with ID and name.
	 */
	private function _sort_names($id, $sname)
	{
		return strcmp($id->name, $sname->name);
	}

	/**
	 * Get Projects
	 *
	 * Returns a list of projects for the Rally installation. The
	 * projects are returned as array of objects, each with its ID
	 * and name.
	 */
	public function get_projects($workspace)
	{
		$response = $this->_send_command(
			'GET',
			'project',
			"?workspace=$workspace"
		);

		if (!$response) {
			return [];
		}

		$result = [];
		foreach ($response as $project) {
			$result[] = (object) [
				'id' => (string) $project->_ref,
				'name' => (string) $project->_refObjectName
			];
		}

		return $result;
	}

	/**
	 * Get Workspace
	 *
	 * Returns the workspace reference (ID) for the requested workspace
	 * name or null if no workspace can be found with the given name.
	 */
	public function get_workspace($workspace)
	{
		if ($this->_workspace) {
			return $this->_workspace;
		}

		$response = $this->_send_command(
			'GET',
			'workspace/'. $workspace
		);

		if (!$response) {
			return null;
		}
		$this->_workspace = $response->Workspace->_ref;
		return $this->_workspace;
	}

	/**
	 * Load Type Definitions
	 *
	 * Loads and caches the type definitions for the workspace. The
	 * type definitions are used to read the environments, priorities,
	 * states, etc.
	 */
	private function _load_typedefs($workspace)
	{
		$workspace = "workspace=$workspace&query=&fetch=true";

		$type_definitions = $this->_send_command(
			'GET',
			'typedefinition',
			$workspace
		);

		if (!$type_definitions) {
			return;
		}

		//Find the Defect Type
		foreach ($type_definitions as $type_definition) {
			if ($type_definition->_refObjectName === "Defect") {
				$defect_attributes = $this->_get_attributes(
					$workspace,
					$type_definition->ObjectID
				);

				foreach ($defect_attributes as $attribute) {
					if ($attribute->_refObjectName != 'Environment' &&
						$attribute->_refObjectName != 'Owner' &&
						$attribute->_refObjectName != 'Priority' &&
						$attribute->_refObjectName != 'Schedule State' &&
						$attribute->_refObjectName != 'Severity' &&
						$attribute->_refObjectName != 'State'
						) {
						continue;
					}

					$allowed_values = $this->_get_allowed_values(
						$workspace,
						$attribute->ObjectID
					);

					$results = [];
					foreach ($allowed_values as $value) {
						if (!$value->StringValue) {
							continue;
						}

						$value = (string) $value->StringValue;
						$results[] = (object) [
							'id' => $value,
							'name' => $value
						];
					}

					switch ($attribute->_refObjectName) {
						case 'Environment':
							$this->_environment = $results;
							break;

						case 'Owner':
							$this->_owners = $results;
							break;

						case 'Owner':
							$this->_owners = $results;
							break;

						case 'Priority':
							$this->_priorities = $results;
							break;

						case 'Schedule State':
							$this->_schedulestates = $results;
							break;

						case 'Severity':
							$this->_severities = $results;
							break;

						case 'State':
							$this->_states = $results;
							break;
					}
				}
			}
		}
	}

	/**
	 * Get Priorities
	 *
	 * Returns a list of priorities. Priorities are returned as array
	 * of objects, each with its ID and name.
	 */
	public function get_priorities($workspace)
	{
		return $this->_priorities ?? $this->_load_typedefs($workspace);
	}

	/**
	 * Get Severities
	 *
	 * Returns a list of severities. Severities are returned as array
	 * of objects, each with its ID and name.
	 */
	public function get_severities($workspace)
	{
		return $this->_severities ?? $this->_load_typedefs($workspace);
	}

	/**
	 * Get States
	 *
	 * Returns a list of states. States are returned as array of
	 * objects, each with its ID and name.
	 */
	public function get_states($workspace)
	{
		return $this->_load_typedefs($workspace) ?? $this->_states;
	}

	/**
	 * Get Schedule States
	 *
	 * Returns a list of schedule states. Schedule States are returned
	 * as array of objects, each with its ID and name.
	 */
	public function get_schedulestates($workspace)
	{
		return $this->_schedulestates ?? $this->_load_typedefs($workspace);
	}

	/**
	 * Get Environments
	 *
	 * Returns a list of environments. Environments are returned as
	 * array of objects, each with its ID and name.
	 */
	public function get_environments($workspace)
	{
		return $this->_environment ?? $this->_load_typedefs($workspace);
	}

	/**
	 * Get Custom Fields
	 *
	 * Returns a list of custom fields options.
	 *
	 * @param string       $workspace   Workspace.
	 * @param array|object $fieldConfig Field configurations.
	 *
	 * @return array
	 */
	public function getCustomFields(string $workspace, $fieldConfig): array
	{
		$customFields = [];
		$results = [];
		if (isset($workspace)) {
			$data = file_get_contents(
				$this->_address . 'slm/schema/v2.0/workspace/' . basename($workspace),
				false,
				stream_context_create([
					'http' => [
						'header'  => empty($this->_key)
							? 'Authorization: Basic ' . base64_encode($this->_user . ':' . $this->_password)
							: 'Authorization: Bearer ' . $this->_key
					]
				])
			);
			$data = json_decode($data);
			foreach ($data->QueryResult->Results ?? [] as $res) {
				foreach ($res->Attributes ?? [] as $attribute) {
					if ($attribute->Custom === true) {
						$customFields[] = (object) [
							'AttributeType' => (string) $attribute->AttributeType,
							'ElementName' => (string) $attribute->ElementName,
							'AllowedValues' => (object) $attribute->AllowedValues
						];
					}
				}
			}
		}
		foreach ($customFields ?? [] as $customField) {
			if ($fieldConfig['field_name'] === $customField->ElementName
				&& $fieldConfig['type'] === 'dropdown') {
				foreach ($customField->AllowedValues as $value) {
					$results[] = (object) [
						'id' => (string) $value->StringValue,
						'name' => (string) $value->StringValue
					];
				}
			} elseif ($fieldConfig['type'] === 'multiselect'
				&& $fieldConfig['field_name'] === $customField->ElementName
				&& isset($customField->AllowedValues->_ref)) {
				$multiValues = $this->_send_command(
					'GET',
					(string) $customField->AllowedValues->_ref
				);
				foreach ($multiValues ?? [] as $multiValue) {
					$results[] = (object) [
						'id' => (string) $multiValue->_ref,
						'name' => (string) $multiValue->StringValue
					];
				}
			} else {
				//NOP
			}
		}

		return $results;
	}

	/**
	 * Get Releases
	 *
	 * Returns a list of releases. Releases are returned as array
	 * of objects, each with its ID and name.
	 */
	public function get_releases($workspace, $project)
	{
		$response = $this->_send_command(
			'GET',
			'release.js',
			"&workspace=$workspace&project=$project" .
				'&projectScopeDown=false&projectScopeUp=false'
		);

		if (!$response) {
			return [];
		}

		$releases = [];
		foreach ($response as $release) {
			$releases[] = (object) [
				'id' => (string) $release->_ref,
				'name' => (string) $release->_refObjectName
			];
		}

		return $releases;
	}

	/**
	 * Get Project Object
	 *
	 * Loads and caches the object for the given project key.
	 */
	private function _get_project_object($project_key)
	{
		return $this->_project_object ?? $this->_send_command(
			'GET',
			$project_key
		);
	}

	/**
	 * Get Owners
	 *
	 * Return a list of owners for the given project. Owners are
	 * returned as array of objects, each with its ID and name.
	 */
	public function get_owners($workspace)
	{
		$response = $this->_send_command(
			'GET',
			'User',
			"?workspace=$workspace"
		);

		if (!$response) {
			return [];
		}

		$result = [];
		foreach ($response as $owner) {
			$result[] = (object) [
				'id' => (string) $owner->_ref,
				'name' => (string) $owner->_refObjectName
			];
		}

		return $result;
	}

	/**
	 * Get Issue
	 *
	 * Gets an existing case from the Rally installation and returns
	 * it. The resulting issue object has various properties such
	 * as the summary, description, project etc.
	 */
	public function get_issue($issue_id)
	{
		$response = $this->_send_command(
			'GET',
			'defect/' . $issue_id
		);

		if (!isset($response->Defect)) {
			$this->_throw_error(
				'Issue "{0}" not found.',
				$issue_id
			);
		}

		return $response->Defect;
	}

	/**
	 * Get User
	 *
	 * Querys the workspace for a user by email address and returns
	 * its reference.
	 */
	private function _get_user($workspace, $email)
	{
		$response = $this->_send_command(
			'GET',
			'user.js',
			"&workspace=$workspace&query=(EmailAddress%20%3D%20$email)"
		);

		if (!$response) {
			return [];
		}

		return $response[0]->_ref;
	}

	private function _get_attributes($workspace, $ObjectID)
	{
		$response = $this->_send_command(
			'GET',
			'TypeDefinition/' . $ObjectID . '/Attributes'
		);

		if (!$response) {
			return [];
		}

		return $response;
	}

	private function _get_allowed_values($workspace, $ObjectID)
	{
		$response = $this->_send_command(
			'GET',
			'AttributeDefinition/' . $ObjectID . '/AllowedValues'
		);

		if (!$response) {
			return [];
		}

		return $response;
	}

	private function _send_command($method, $uri, $options = '',
		$data = null)
	{
		if (!str::starts_with($options, '?')) {
			$options = '?' . $options;
		}

		$batchResponse = $this->_send_command_batch(
			$method,
			$uri,
			$options,
			1,
			$data
		);

		// If QueryResult->Result is set we need to check if we need
		// to fetch more elements.
		if (isset($batchResponse->QueryResult->Results)) {
			$result = $batchResponse->QueryResult->Results;
			$count = $batchResponse->QueryResult->TotalResultCount;
			$index = $batchResponse->QueryResult->StartIndex;
			$pagesize = $batchResponse->QueryResult->PageSize;

			while ($index + $pagesize < $count) {
				$batchResponse = $this->_send_command_batch(
					$method,
					$uri,
					$options,
					$index + $pagesize,
					$data
				);

				$count = $batchResponse->QueryResult->TotalResultCount;
				$index = $batchResponse->QueryResult->StartIndex;
				$pagesize = $batchResponse->QueryResult->PageSize;

				$result = array_merge(
					$result,
					$batchResponse->QueryResult->Results
				);
			}
		} else {
			$result = $batchResponse;
		}

		return $result;
	}

	private function _send_command_batch($method, $uri, $options,
		$start, $data)
	{
		if (preg_match('/https?:\/\//', $uri)) {
			$url = $uri;
		} else {
			$url = $this->_address . 'slm/webservice/v2.0/' . $uri . $options;

			if ($method === 'GET') {
				$url = $url . "&start=$start&pagesize=100";
			}
		}

		return $this->_send_request($method, $url, $data);
	}

	private function _send_request($method, $url, $data = null)
	{
		$headers = array(
			'Content-Type' => 'text/javascript;charset=utf-8',
			'X-RallyIntegrationName' => 'TestRail',
			'X-RallyIntegrationVendor' => 'Gurock',
			'X-RallyIntegrationVersion' => '2',
			'X-RallyIntegrationOS' =>
				php_uname('s'),
			'X-RallyIntegrationPlatform' =>
				str::format(
					'PHP {0}',
					phpversion()
				)
		);

		if (!$this->_curl) {
			// Initialize the cURL handle. We re-use this handle to
			// make use of Keep-Alive, if possible.
            $this->_curl = curl_init();
            if (preg_match('(Windows)',php_uname('s')) === 1) {
                curl_setopt($this->_curl, CURLOPT_SSL_VERIFYPEER,false);
            }
			curl_setopt($this->_curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($this->_curl, CURLOPT_HEADER, 0);
			curl_setopt($this->_curl, CURLOPT_COOKIEFILE, '/tmp/php_rally_cookie_file');
			curl_setopt(
				$this->_curl,
				CURLOPT_USERPWD,
				empty($this->_key)
					? $this->_user . ':' . $this->_password
					: $this->_key
			);
			curl_setopt($this->_curl, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
		}

		if (logger::is_on(GI_LOG_LEVEL_DEBUG)) {
			logger::debug('Issuing Rally HTTP request');
			logger::debugr(
				'$request',
				array(
					'method' => $method,
					'url' => $url,
					'data' => $data,
				)
			);
		}

		if ($method === 'POST') {
			curl_setopt($this->_curl, CURLOPT_CUSTOMREQUEST, 'POST');
			$payload = json::encode($data);
			curl_setopt($this->_curl, CURLOPT_POSTFIELDS, $payload);
			curl_setopt($this->_curl, CURLOPT_URL, $url);
			//Set headers AFTER setting method to POST
			curl_setopt($this->_curl, CURLOPT_HTTPHEADER, array(
					'Content-Type: text/javascript;charset=utf-8',
					'X-RallyIntegrationName: TestRail',
					'X-RallyIntegrationVendor: Gurock',
					'X-RallyIntegrationVersion: 2',
					'X-RallyIntegrationOS' . php_uname('s'),
					'X-RallyIntegrationPlatform: ' . str::format('PHP {0}', phpversion())
				)
			);
			$response = curl_exec($this->_curl);
		} else {
			curl_setopt($this->_curl, CURLOPT_CUSTOMREQUEST, 'GET');
			curl_setopt($this->_curl, CURLOPT_POSTFIELDS, '');
			curl_setopt($this->_curl, CURLOPT_URL, $url);
			$response = curl_exec($this->_curl);
		}

		// In case debug logging is enabled, we append the data
		// we've sent and the entire request/response to the log.
		if (logger::is_on(GI_LOG_LEVEL_DEBUG)) {
			logger::debug('Got the following response');
			logger::debugr('$response', $response);
		}

		$obj = json::decode($response);

		//Handle possible errors from GET requests
        if (isset($obj)) {
            if (property_exists($obj, 'QueryResult') && $obj->QueryResult->Errors) {
                $this->_throw_error($obj->QueryResult->Errors[0]);
            } elseif (property_exists($obj, 'OperationResult') && $obj->OperationResult->Errors) {
                $this->_throw_error($obj->OperationResult->Errors[0]);
            } elseif (property_exists($obj, 'CreateResult') && $obj->CreateResult->Errors) {
                $this->_throw_error($obj->CreateResult->Errors[0]);
            }
        }

		return $obj;
	}

	/**
	 * Add Issue
	 *
	 * Adds a new issue to the Rally installation with the given
	 * parameters (title, project etc.) and returns its ID. The
	 * parameters must be named according to the Rally API format,
	 * e.g.:
	 *
	 * summary:     The summary of the new issue
	 * project:     The ID of the project the issue should be added
	 *              to
	 * priority:    The ID of the priority the issue should be added
	 *              to
	 * description: The description of the new issue
	 */
	public function add_issue(array $options, array $paths)
	{
		$fields = [];
		$contents = [];
		$optionValues = [];
		foreach ($options as $fieldName => $fieldValue) {
			if (!$fieldValue) {
				continue;
			} else {
				$field = $this->_format_field($fieldName, $fieldValue);
				if (isset($field['name']) && isset($field['value'])) {
					$fields[$field['name']] = $field['value'];
				}
			}
			if (str::starts_with($fieldName, 'c_')) {
				$category = arr::get(
					$this->_config,
					"field.settings.$fieldName"
				);
				if ($category['type'] === 'multiselect') {
					foreach ($fieldValue ?? [] as $value) {
						$optionValues[] = ['_ref' => $value];
					}
					$fields[$fieldName] = $optionValues;
				}
			}
		}

		$url = $this->_address . 'slm/webservice/v2.0/';

		$token_response = $this->_send_request('GET', $url . 'security/authorize');
		$token = $token_response->OperationResult->SecurityToken;

		$response = $this->_send_request(
			'POST',
			$url . 'defect/create' . "?key=$token",
			['Defect' => $fields]
		);

		foreach ($paths ?? [] as $path) {
			$contents[] = $this->_add_attachment_content($path, $token);
		}
		foreach ($contents ?? [] as $content) {
			$this->_add_attachment_issue($response->CreateResult->Object->ObjectID,
				$content->_ref, $token);
		}

		// Check if the issue/defect was created successfully. The API
		// appears to return 200 in all cases and doesn't use proper
		// HTTP status codes.
		if (isset($response->CreateResult->Errors)) {
			$errors = $response->CreateResult->Errors;
			if (is_array($errors) && $errors) {
				$this->_throw_error($errors[0]);
			}
		}

		if (isset($response->CreateResult->Object)) {
			return $response->CreateResult->Object->ObjectID;
		} else {
			return null;
		}
	}

	/**
	 * Add Attachment Content
	 * Store attachment and return attachment files.
	 *
	 * @param string $path  User uploaded file path.
	 * @param string $token Security token.
	 *
	 * @return object
	 */
	private function _add_attachment_content(string $path, string $token)
	{
		$file = file_get_contents($path);
		if (!$this->_curl) {
			$this->_curl = http::open();
		}

		$url = $this->_address .
			'slm/webservice/v2.0/attachmentcontent/create?key=' .
			$token;
		$response = http::request_ex(
			$this->_curl,
			'POST',
			$url,
			[
				'headers' => [
					'Content-Type'=> 'application/json;charset=UTF-8'
				],
				'user' => $this->_user,
				'password' => $this->_password,
				'data' => json_encode(
					[
						'AttachmentContent'=> [
						'content'=> base64_encode($file)
					]
				]),
				'skip_url_encode' => true
			]
		);
		$responseContent = json_decode($response->content);

		return $responseContent->CreateResult->Object;
	}

	/**
	 * Add Attachment Issue
	 * Store attachment in issue attachment.
	 *
	 * @param int 	 $issueId  Issue ID.
	 * @param string $refPath  Pass attachments file path to add attachment to issue.
	 * @param string $token    Security token to issue.
	 *
	 */
	private function _add_attachment_issue(int $issueId, string $refPath, string $token)
	{
		$url = $this->_address .
			'slm/webservice/v2.0/attachment/create?key=' .
			 $token;

		$data = json_encode([
					'Attachment'=> [
						'Content'=> $refPath,
						'Artifact'=> $this->_address .
							'slm/webservice/v2.0/defect/' .
							$issueId,
						'ContentType'=> 'application/octet-stream',
						'Name'=>'Attachment',
						'Size'=>'20'
					]
				]);
		if (!$this->_curl) {
			$this->_curl = http::open();
		}

		$response = http::request_ex(
			$this->_curl,
			'POST',
			$url,
			[
				'headers' => [
					'Content-Type'=> 'application/json;charset=UTF-8'
				],
				'user' => $this->_user,
				'password' => $this->_password,
				'data' => $data,
				'skip_url_encode' => true
			]
		);

		return json_decode($response->content);
	}

	/**
	 * Format system field as per GitHub API.
	 * e.g summary field convert to title
	 *
	 * @param string       $fieldName  default field name
	 * @param string|array $fieldValue user select value in push popup
	 *
	 * @return array.
	 */
	private function _format_field(string $fieldName, $fieldValue): array
	{
		$data = [];
		$data['name'] = $fieldName;
		switch ($fieldName) {
			case 'project':
				$data['value'] = '/project/' . $fieldValue;
				break;
			case 'summary':
				$data['name'] = 'name';
				$data['value'] = $fieldValue;
				break;
			case 'description':
				$data['name'] = 'description';
				$data['value'] =
					nl2br(
						html::link_urls(
							$fieldValue
						)
					);
				break;
			default:
				$data['value'] = $fieldValue;
				break;
		}

		return $data;
	}

	private function _throw_error($format, $params = null)
	{
		$args = func_get_args();
		$format = array_shift($args);

		throw new RallyException(
			count($args) > 0
				? str::formatv($format, $args)
				: $format
		);
	}
}

class RallyException extends Exception
{
}
