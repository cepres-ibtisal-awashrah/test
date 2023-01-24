<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

/**
 * Axosoft (v17+) Defect Plugin for TestRail 
 *
 * Copyright Gurock Software GmbH. All rights reserved.
 *
 * This is the TestRail defect plugin for Axosoft's REST API. Please
 * see http://docs.gurock.com/testrail-integration/defects-plugins
 * for more information about TestRail's defect plugins.
 *
 * http://www.gurock.com/testrail/
 */

class Axosoft_v17_REST_defect_plugin extends Defect_plugin
{
	private $_api;
	private $_address;
	private $_user;
	private $_password;
	private $_client_id;
	private $_client_secret;
	private $_customFields = [];
	private $_defaultFields = [
		'name' => 'on',
		'project' => 'on',
		'workflow_step' => 'on',
		'release' => 'on',
		'priority' => 'on',
		'assigned_to' => 'on',
		'description'=> 'on',
		'attachments' => 'on',
	];
	private $_fieldDefaults = [
		'name' =>  [
			'type' => 'string',
			'label' => 'Name',
			'required' => true,
			'size' => 'full'
		],
		'project' => [
			'type' => 'dropdown',
			'label' => 'Project',
			'required' => true,
			'remember' => true,
			'cascading' => true,
			'size' => 'compact'
		],
		'workflow_step' => [
			'type' => 'dropdown',
			'label' => 'Workflow Step',
			'required' => true,
			'remember' => true,
			'depends_on' => 'project',
			'size' => 'compact'
		],
		'release' => [
			'type' => 'dropdown',
			'label' => 'Release',
			'remember' => true,
			'size' => 'compact'
		],
		'priority' => [
			'type' => 'dropdown',
			'label' => 'Priority',
			'remember' => true,
			'size' => 'compact'
		],
		'severity' => [
			'type' => 'dropdown',
			'label' => 'Severity',
			'remember' => true,
			'size' => 'compact'
		],
		'assigned_to' =>  [
			'type' => 'dropdown',
			'label' => 'Assigned To',
			'remember' => true,
			'size' => 'compact'
		],
		'description' => [
			'type' => 'text',
			'label' => 'Description',
			'required' => false,
			'rows' => 10,
			'dropzone_enabled' => true
		],
		'attachments' => [
		    'type' => 'dropbox',
		    'label'=>'attachments',
		    'required' => false,
		    'size' => 'none'
		]
	];

	private static $_meta = [
		'author' => 'Gurock Software',
		'version' => '1.0',
		'description' => 'Axosoft defect plugin for TestRail v17 (API 6)',
		'can_push' => true,
		'can_lookup' => true,
		'default_config' => 
			'; Please configure your Axosoft connection below.
; The client_id and client_secret can be generated
; in Axosoft\'s administration area under Tools |
; System Options | Axosoft API Settings.
;
; Note: requires Axosoft  17.0.1 or later. 
[connection]
address=https://<your-server>/
user=testrail
password=secret
client_id=01010101-0101-0101-0101-010101010101
client_secret=02020202-0202-0202-0202-020202020202

[push.fields]
name=on
project=on
workflow_step=on
release=on
priority=on
assigned_to=on
description=on
attachments=on

[hover.fields]
project=on
workflow_step=on
release=on
priority=on
assigned_to=on
description=on'
];
	
	public function get_meta()
	{
		return self::$_meta;
	}

	// *********************************************************
	// CONSTRUCT / DESTRUCT
	// *********************************************************

	public function __construct()
	{
	}

	public function __destruct()
	{
		if ($this->_api)
		{
			try
			{
				$api = $this->_api;
				$this->_api = null;
			}
			catch (Exception $e)
			{
				// Possible exceptions are ignored here.
			}
		}
	}

    /**
     * Validate Config
     *
     * Validates the plugin configuration that is entered in the site
     * or project settings.
     *
     * @param string $config Configuration for the plugin as specified
     *                       in the site/project settings.
     *
     * @return void
     *
     * @throws ValidationException
     */
    public function validate_config($config)
    {
        $ini = ini::parse($config);
        if (!isset($ini['connection'])) {
            throw new ValidationException('Missing [connection] group');
        }
        $connection = $ini['connection'];
        foreach (['address', 'user', 'password', 'client_id', 'client_secret'] as $key) {
            if (!isset($connection[$key]) || !$connection[$key]) {
                throw new ValidationException(
                    "Missing configuration for key '$key'"
                );
            }
        }
        if (!check::url($connection['address'])) {
            throw new ValidationException('Address is not a valid url');
        }
        foreach (['push.fields', 'hover.fields'] as $fieldSection) {
            $fieldList = $ini[$fieldSection] ?? [];
            foreach ($fieldList as $field => $option) {
                if ($option === 'on') {
                    $this->_validateField($ini, $field);
                }
            }
            if ($fieldSection === 'push.fields' && !empty($fieldList)) {
                foreach (['project', 'workflow_step'] as $requiredField) {
                    if (!$this->_isConfigFieldOn($fieldList, $requiredField)) {
                        throw new ValidationException(
                            'In [push.fields], ' . $requiredField . '=on is required.'
                        );
                    }
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
     * Validate default fields and if invalid 
     * field found then throws error.
     *
     * @param array  $ini   API configuration.
     * @param string $field Field name.
     *
     * @return void
     *
     * @throws ValidationException
     */
    private function _validateField(array $ini, string $field)
    {
        $validTypes = [
            'dropdown' => true,
            'multiselect' => true,
            'text' => true,
            'string' => true,
            'bool' => true,
            'date' => true
        ];
        $category = arr::get($ini, "field.settings.$field");
        if (str::starts_with($field, 'custom_')) { 
            if (!$category) {
                throw new ValidationException(
                    str::format(
                        'Field "{0}" is enabled but configuration ' .
                        'section [field.settings.{0}] is missing',
                        $field
                    )
                );
            }
            foreach (['label', 'type'] as $key) {
                if (!isset($category[$key])) {
                    throw new ValidationException(
                        str::format(
                            'Missing configuration for key "{0}" in ' 
                                . 'section [field.settings.{1}]',
                            $key,
                            $field
                        )
                    );
                }
            }
        }
        $type = arr::get($category, 'type');        
        if ($type && !isset($validTypes[str::to_lower($type)])) {
            throw new ValidationException(
                str::format(
                    'Invalid field type specified in section ' 
                        . '[filed.settings.{0}]',
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
		$this->_client_id = $ini['connection']['client_id'];
		$this->_client_secret = $ini['connection']['client_secret'];
		$this->_config = $ini;
	}

	// *********************************************************
	// API / CONNECTION
	// *********************************************************

	private function _get_api()
	{
		if ($this->_api)
		{
			return $this->_api;
		}
		
		$this->_api = new OnTime_REST_api($this->_address);
		$this->_api->login(
			$this->_user,
			$this->_password,
			$this->_client_id,
			$this->_client_secret);

		return $this->_api;
	}

	// *********************************************************
	// PUSH
	// *********************************************************
	/**
	* Prepare Push
	* Creates an array of objects of default and custom field
	* with default and user defined configuration.
	*
	* @param array|object $context Default configuration.
	*
	* @return array
	*/
	public function prepare_push($context): array
	{
		$fields = [];
		$fieldsConfig = isset($this->_config['push.fields'])
			? ['name' => 'on'] + $this->_config['push.fields']
			: $fieldsConfig = $this->_defaultFields;
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
			if ($category) {
				foreach ($category as $prop => $val) {
					//except label value remaning all values should be downcase.
					$property = str::to_lower($prop);
					if ($property === 'label') {
						$field[$property] = $val;
						continue;
					}
					$property = str::to_lower($prop);
					$value = str::to_lower($val);
					if (in_array($property, ['required', 'remember', 'cascading'])) {
						$value = $value === 'true';
					} elseif ($property === 'rows') {
						$value = (int) $value;
					} else {
						// NOP
					}
					// This may override the default value from above.
					$field[$property] = $value;
				}
			}
			if ($field['type'] === 'date') {
				$field['type'] = 'string';
				$field['description'] = 'Example: 2020-05-02T07:00:00Z';
			}
			$fields[$fieldName] = $field;
		}
		$result = ['fields' => $fields];
		// Save the form for later use in prepare_field().
		$this->_form = $result;

		return $result;
	}

	private function _get_name_default($context)
	{
		$test = current($context['tests']);
		$title = 'Failed test: ' . $test->case->title;

		if ($context['test_count'] > 1)
		{
			$title .= ' (+others)';
		}

		return $title;
	}

	private function _get_description_default($context)
	{
		return $context['test_change']->description;
	}

	private function _to_id_name_lookup($items)
	{
		$result = array();
		foreach ($items as $item)
		{
			$result[$item->id] = $item->name;
		}
		return $result;
	}

	/**
	 * Get Default Customfield Values.
	 *
	 * @param object $api       Axosoft API object.
	 * @param string $fieldName Defect field name.
	 *
	 * @return array|string
	 */
	private function _get_default_customfield_values(object $api, string $fieldName) {
		$customField = $this->_get_customfield_values(
			$api,
			str::replace(
				$fieldName,
				'custom_',
				''
			)
		);
		$returnedValue = [];
		if (isset($customField)) {
			$category = arr::get(
				$this->_config,
				"field.settings.$fieldName"
			);
			if ($customField->type === 'pick_list' && isset($category['type'])) {
				$returnedValue = $this->_to_id_name_lookup(
					$api->get_custom_picklist((int) $customField->picklist_id, (string) $category['type'])
				);
			}
			if ($customField->type === 'boolean') {
				$returnedValue = [
					'True' => 'True',
					'False' => 'False'
				];
			}
			$fieldFormat = $customField->type;
			if (in_array($fieldFormat, ['list', 'dropdown', 'bool'])) {
				$returnedValue = obj::get_lookup_scalar(
					$customField->possible_values,
					'value',
					$fieldFormat === 'bool' ? 'label' : 'value'
				);
			}
		}

		return $returnedValue;
	}

	/**
	 * Get customfield values
	 * Find custom field details using ID.
	 *
	 * @param object $api Axosoft API.
	 * @param int    $id  Custom field id.
	 *
	 * @return object|null.
	 */
	private function _get_customfield_values(object $api, int $id)
	{
		$customField = $this->_find_custom_field_by_id($id, $this->_customFields);
		if (!isset($customField)) {
			$this->_customFields = $api->get_customfields();
			$customField = $this->_find_custom_field_by_id($id, $this->_customFields);
		}

		return $customField;
	}

	/**
	 * Find custom field object in array of objects using ID.
	 *
	 * @param int 	$id           Custom field ID
	 * @param array $customFields Array of custom fields
	 *
	 * @return object|null
	 */
	private function _find_custom_field_by_id(int $id, array $customFields)
	{
		$returnedValue = null;
		foreach ($customFields as $element) {
			if ($id === $element->id) {
				$returnedValue = $element;
				break;
			}
		}

		return $returnedValue;
	}

	public function prepare_field($context, $input, $field)
	{
		$data = array();

		// Process those fields that do not need a connection to the
		// OnTime installation.
		if ($field == 'name' || $field == 'description')
		{
			switch ($field)
			{
				case 'name':
					$data['default'] = $this->_get_name_default(
						$context);
					break;

				case 'description':
					$data['default'] = $this->_get_description_default(
						$context);
					break;
			}

			return $data;
		}

		// Take into account the preferences of the user, but only
		// for the initial form rendering (not for dynamic loads).
		if ($context['event'] == 'prepare')
		{
			$prefs = arr::get($context, 'preferences');
		}
		else
		{
			$prefs = null;
		}

		// And then try to connect/login (in case we haven't set up a
		// working connection previously in this request) and process
		// the remaining fields.
		$api = $this->_get_api();

		switch ($field)
		{
			case 'workflow_step':
				$data['options'] = $this->_to_id_name_lookup(
					$api->get_workflow_steps($input['project'])
				);

				// Select the stored preference or the first item in
				// the list otherwise.
				$default = arr::get($prefs, 'workflow_step');
				if ($default)
				{
					$data['default'] = $default;
				}
				else
				{
					if ($data['options'])
					{
						$data['default'] = key($data['options']);
					}
				}
				break;

			case 'project':
				$data['default'] = arr::get($prefs, 'project');
				$data['options'] = $this->_to_id_name_lookup(
					$api->get_projects()
				);
				break;

			case 'severity':
				$data['default'] = arr::get($prefs, 'severity');
				$data['options'] = $this->_to_id_name_lookup(
					$api->get_severities()
				);

				// Select the stored preference or the first item in
				// the list otherwise.
				$default = arr::get($prefs, 'severity');
				if ($default)
				{
					$data['default'] = $default;
				}
				else
				{
					if ($data['options'])
					{
						$data['default'] = key($data['options']);
					}
				}
				break;

			case 'priority':
				$data['default'] = arr::get($prefs, 'priority');
				$data['options'] = $this->_to_id_name_lookup(
					$api->get_priorities()
				);

				// Select the stored preference or the first item in
				// the list otherwise.
				$default = arr::get($prefs, 'priority');
				if ($default)
				{
					$data['default'] = $default;
				}
				else
				{
					if ($data['options'])
					{
						$data['default'] = key($data['options']);
					}
				}
				break;

			case 'assigned_to':
				$data['default'] = arr::get($prefs, 'assigned_to');
				$data['options'] = $this->_to_id_name_lookup(
					$api->get_users()
				);
				break;

			case 'release':
				$data['default'] = arr::get($prefs, 'release');
				$data['options'] = $this->_to_id_name_lookup(
					$api->get_releases()
				);
				break;
		}
		if (str::starts_with($field, 'custom_')) {
			$data['default'] = arr::get($prefs, $field);
			$data['options'] = $this->_get_default_customfield_values(
				$api,
				$field
			);
		}
		if (
			arr::get($this->_form, 'fields')[$field]['type'] === 'dropdown' &&
			is_array(arr::get($data, 'default'))
		) {
			$data['default'] = '';
		}

		return $data;
	}
	
	public function validate_push($context, $input)
	{
	}

	/**
	* Push
	* Push an array of objects of default field
	* with default and user defined configuration.
	*
	* @param array|object $context Default configuration.
	* @param array|object $input   Default plugin configuration.
	* @param array        $paths   Attachments.
	*
	* @return int
	*/
	public function push($context, $input, array $paths = []): int
	{
		$api = $this->_get_api();

		return $api->add_defect($input, $paths);
	}

    /**
     * Lookup
     *
     * Creates an array of objects of default and user
     * defined configuration to display on hover popup.
     *
     * @param int $defectId  Defect id of an issue.
     *
     * @return array
     */
    public function lookup($defectId): array
    {
        $description = null;
        $api = $this->_get_api();
        $defect = $api->get_defect($defectId);
        $attributes = [];
        $fullAttributes = [];
        $fieldsConfig = $this->_config['hover.fields'] ?? $this->_defaultFields;
        foreach ($fieldsConfig as $fieldName => $option) {
            $value = null;
            if ($option !== 'on' || in_array($fieldName, ['name', 'attachments'])) {
                continue;
            }
            $category = arr::get($this->_config,"field.settings.$fieldName");
            if (isset($category)) {
                $field = $category;
            } elseif (isset($this->_fieldDefaults[$fieldName])) {
                $field = $this->_fieldDefaults[$fieldName];
            } else {
                //NOP
            }
            if (!empty($defect->$fieldName->id)) {
                switch($fieldName) {
                    case 'project':
                        $project = $this->_api->get_project($defect->$fieldName->id);
                        if ($project) {
                            $value = h($project->name);
                        }
                        break;
                    case 'workflow_step':
                        $workflowStep = $this->_api->get_workflow_step($defect->project->id,
                        $defect->$fieldName->id);
                        $value = $workflowStep ? h($workflowStep->name) : null;
                        break;
                    case 'release':
                        $release = $this->_api->get_release($defect->$fieldName->id);
                        if ($release) {
                            $value = h($release->name);
                        }
                        break;
                    case 'priority':
                        $priority = $this->_api->get_priority($defect->$fieldName->id);
                        if ($priority) {
                            $value = h($priority->name);
                        }
                        break;
                    case 'assigned_to':
                        $attributeValue = (isset($defect->$fieldName->type) && $defect->$fieldName->type === 'team')
                            ? $this->_api->get_team($defect->$fieldName->id)
                            : $this->_api->get_user($defect->$fieldName->id);
                        if ($attributeValue) {
                            $value = h($attributeValue->name);
                        }
                        break;
                }
            }
            if (str::starts_with($fieldName, 'custom_')) {
                $customField = $this->_get_customfield_values(
                    $api,
                    str::replace($fieldName, 'custom_','')
	            );
                if (isset($defect->custom_fields) && is_array($defect->custom_fields->$fieldName)) {
                    $value = join(', ', $defect->custom_fields->$fieldName);
                } elseif (in_array($customField->type, ['date_time', 'date', 'time', 'boolean']) && isset($defect->custom_fields->$fieldName)) {
                    switch($customField->type) {
                        case 'date_time':
                            $value = date::format_short_datetime(strtotime($defect->custom_fields->$fieldName));
                            break;
                        case 'date':
                            $value = date::format_short_date(strtotime($defect->custom_fields->$fieldName));
                            break;
                        case 'time':
                            $value = date::format_short_time(strtotime($defect->custom_fields->$fieldName));
                            break;
                        case 'boolean':
                            $value = ($defect->custom_fields->$fieldName === 1) ? 'True' : 'False';
                            break;
                    }
                } else {
                    $value = $defect->custom_fields->$fieldName;
                }
            }
            $finalValue = empty($value) ? '&ndash;' : $value;
            if ($fieldName === 'description' && !empty($defect->$fieldName)) {
                $description = str::format(
                    '<div class="monospace">{0}</div>',
                    $defect->$fieldName
                );
            } elseif (!isset($field['size']) || ($field['size'] === 'full'
                && in_array($field['type'], ['text', 'string']))
				&& isset($finalValue)
                ) {
                $fullAttributes[$field['label']] = str::format(
                    '<div class="monospace">{0}</div>',
                    strip_tags(html_entity_decode($finalValue))
                );
            } else {
                $attributes[$field['label']] = $finalValue;
            }
        }
        $statusId = GI_DEFECTS_STATUS_OPEN;
        $status = ' ';
        if (isset($workflowStep)) {
            $status = $workflowStep->name;
            if (in_array(str::to_lower($workflowStep->name), ['fixed', 'rejected'])) {
                $statusId = GI_DEFECTS_STATUS_CLOSED;
            }
        }

        return [
            'id' => $defectId,
                'url' => str::format(
                '{0}viewitem.aspx?id={1}&type=features',
                $this->_address,
                $defectId
            ),
            'title' => $defect->name,
            'status_id' => $statusId,
            'status' => $status,
            'description' => $description,
            'attributes' => $attributes,
            'fullAttributes' => $fullAttributes
        ];
    }
}

/**
 * OnTime_REST API
 *
 * Wrapper class for the OnTime REST API with login and functions for
 * retrieving projects etc. from a OnTime installation.
 */
class OnTime_REST_api
{
	private $_version;
	private $_token;
	private $_address;
	private $_curl;

	/**
	 * Construct
	 *
	 * Initializes a new OnTime_REST API object. Expects the web
	 * address of the OnTime installation including http or https
	 * prefix.
	 */
	public function __construct($address)
	{
		$this->_address = str::slash($address);
	}

	private function _throw_error($format, $params = null)
	{
		$args = func_get_args();
		$format = array_shift($args);
		
		if (count($args) > 0)
		{
			$message = str::formatv($format, $args);
		}
		else
		{
			$message = $format;
		}

		throw new OnTime_RESTException($message);
	}

	private function _format_url($prefix, $vars)
	{
		$url = $prefix . '?';

		foreach($vars as $key => $value)
		{
			$url .= "$key=" . urlencode($value) . '&';
		}

		return $url;
	}

	private function _send_command($method, $uri, $data = array())
	{
		$url = $this->_address . 'api/v6/' . $uri;

		if ($method == 'POST' && isset($data))
		{
			$data = json::encode(array('item' => $data));
		}

		if (!$this->_curl)
		{
			// Initialize the cURL handle. We re-use this handle to
			// make use of Keep-Alive, if possible.
			$this->_curl = http::open();
		}

		$response = http::request_ex(
			$this->_curl,
			$method, 
			$url, 
			array(
				'data' => $data,
				'headers' => array(
					'Content-Type' => 'application/json',
					'X-Authorization' => "Bearer $this->_token"
				)
			)
		);

		// In case debug logging is enabled, we append the data we've
		// sent and the entire request/response to the log.
		if (logger::is_on(GI_LOG_LEVEL_DEBUG))
		{
			logger::debugr('$data', $data);
			logger::debugr('$response', $response);
		}
        if ($response->code != 200) {
            if ($response->code === 401) {
                $errorMessage = 'Invalid HTTP code ({0}). Please check your user/'
                    . 'password for Axosoft.';
            } else {
                $errorMessage =  'Invalid HTTP code ({0}) : '
                    . json::decode($response->content)->message ?? '' ;
            }
            $this->_throw_error($errorMessage, $response->code);
        }
		
		return $this->_parse_response($response->content);
	}

	private function _parse_response($response)
	{
		$json = json::decode($response);

		// OnTime REST API:
		// If there is no data object/property, something went wrong.
		if (!isset($json->data))
		{
			$this->_throw_error('No valid response received');
		}

		return $json;
	}

	/**
	 * Login
	 *
	 * Logs in to the OnTime installation using the provided user/
	 * email address and password.
	 */
	public function login($user, $password, $client_id, $client_secret)
	{
		$response = $this->_send_command(
			'GET', 
			$this->_format_url(
				'oauth2/token',
				array(
					'username' => $user,
					'grant_type' => 'password',
					'password' => $password,
					'client_id' => $client_id,
					'client_secret' => $client_secret,
					'scope' => 'read write'
				)
			)
		);

		$this->_token = $response->access_token;
	}

	/**
	 * Get Project
	 *
	 * Returns the project item specified by the given project ID.
	 */
	public function get_project($project_id)
	{
		$response = $this->_send_command(
			'GET',					
			"projects/$project_id"
		);

		$project = $response->data;

		$result = obj::create();
		$result->id = $project->id;
		$result->name = $project->name;

		return $result;
	}

	/**
	 * Get Projects
	 *
	 * Returns a list of projects for the OnTime installation. The
	 * projects are returned as array of objects, each with its ID
	 * and name.
	 */
	public function get_projects()
	{
		$response = $this->_send_command('GET', 'projects');
		$projects = $response->data; // <projects>
		
		$result = array();
		$this->_build_project_tree($result, $projects, 0);		
		return $result;
	}

	private function _build_project_tree(&$result, $projects, $level)
	{
		foreach ($projects as $project)
		{
			$p = obj::create();
			$p->id = $project->id;
			$p->name = str::repeat("\xC2\xA0", $level*3) . $project->name;
			$result[] = $p;

			// OnTime supports a project hierarchy (project tree). We
			// recursively add the children to the tree, if there are
			// any.
			if (isset($project->children))
			{
				if (count($project->children) > 0)
				{
					$this->_build_project_tree(
						$result, 
						$project->children,
						$level + 1
					);
				}
			}
		}
	}

	/**
	 * Get Release
	 *
	 * Returns the release item specified by the given release ID.
	 */
	public function get_release($release_id)
	{
		$response = $this->_send_command(
			'GET',					
			"releases/$release_id"
		);

		$release = $response->data;

		$result = obj::create();
		$result->id = $release->id;
		$result->name = $release->name;

		return $result;
	}

	/**
	 * Get Releases
	 *
	 * Returns a list of releases for the OnTime installation.
	 * Releases are returned as array of objects, each with its
	 * ID, and name.
	 */
	public function get_releases()
	{
		$response = $this->_send_command('GET', 'releases');
		$releases = $response->data; // <releases>

		$result = array();
		$this->_build_release_tree($result, $releases, 0);		
		return $result;
	}

	private function _build_release_tree(&$result, $releases, $level)
	{
		foreach ($releases as $release)
		{
			$r = obj::create();
			$r->id = $release->id;
			$r->name = str::repeat("\xC2\xA0", $level*3) . $release->name;
			$result[] = $r;

			// OnTime supports a release hierarchy (release tree). We
			// recursively add the children to the tree, if there are
			// any.
			if (isset($release->children))
			{
				if (count($release->children) > 0)
				{
					$this->_build_release_tree(
						$result,
						$release->children,
						$level + 1
					);
				}
			}
		}
	}

		/**
	 * Get Team
	 *
	 * Returns the team item specified by the given team ID.
	 */
	public function get_team($team_id)
	{
		$response = $this->_send_command(
			'GET',					
			"teams/$team_id"
		);

		$result = $response->data;

		return $result;
	}
	
	/**
	 * Get User
	 *
	 * Returns the user item specified by the given user ID.
	 */
	public function get_user($user_id)
	{
		$response = $this->_send_command(
			'GET',					
			"users/$user_id"
		);

		$user = $response->data;

		$result = obj::create();
		$result->id = $user->id;
		$result->name = $user->first_name . ' ' . $user->last_name;

		return $result;
	}

	/**
	 * Get Users
	 *
	 * Returns a list of users for the OnTime installation.
	 * Users are returned as array of objects, each with its
	 * ID, and name.
	 */
	public function get_users()
	{
		$response = $this->_send_command('GET', 'users');
		$users = $response->data; // <users>

		$result = array();
		foreach ($users as $user)
		{
			if ($user->is_active === true)
			{
				$u = obj::create();
				$u->id = $user->id;
				$u->name = $user->first_name . ' ' . $user->last_name;
				$result[] = $u;
			}
		}

		return $result;
	}

	/**
	 * Get Severitiy
	 *
	 * Returns the severity item specified by the given severity ID.
	 * Use get_severities to get a list of all severities.
	 */
	public function get_severity($severity_id)
	{
		$severities = $this->get_severities();

		foreach ($severities as $severity)
		{
			if ($severity->id == $severity_id)
			{
				return $severity;
			}
		}

		return null;
	}

	/**
	 * Get Severities
	 *
	 * Returns a list of severities for the OnTime installation.
	 * Severities are returned as array of objects, each with its
	 * ID, and name.
	 */
	public function get_severities()
	{
		$response = $this->_send_command('GET', 'picklists/severity');
		$severities = $response->data; // <severities>

		$result = array();
		foreach ($severities as $severity)
		{
			$s = obj::create();
			$s->id = (int) $severity->id;
			$s->name = (string) $severity->name;
			$result[] = $s;
		}

		return $result;
	}

	/**
	 * Get Priority
	 *
	 * Returns the priority item specified by the given priority ID.
	 * Use get_priorities to get a list of all priorities.
	 */
	public function get_priority($priority_id)
	{
		$priorities = $this->get_priorities();

		foreach ($priorities as $priority)
		{
			if ($priority->id == $priority_id)
			{
				return $priority;
			}
		}

		return null;
	}

	/**
	 * Get Priorities
	 *
	 * Returns a list of priorities for the OnTime installation.
	 * Priorities are returned as array of objects, each with its ID,
	 * and name.
	 */
	public function get_priorities()
	{
		$response = $this->_send_command('GET', 'picklists/priority');
		$priorities = $response->data; // <priorities>

		$result = array();
		foreach ($priorities as $priority)
		{
			$p = obj::create();
			$p->id = (int) $priority->id;
			$p->name = (string) $priority->name;
			$result[] = $p;
		}

		return $result;
	}

	/**
	 * Get Workflow Step
	 *
	 * Returns the workflow_step item specified by the given Project
	 * ID and Workflow Step ID.
	 * Use get_workflow_steps to get a list of all workflow steps.
	 */
	public function get_workflow_step($project_id, $workflow_step_id)
	{
		$workflow_steps = $this->get_workflow_steps($project_id);

		foreach ($workflow_steps as $step)
		{
			if ($step->id == $workflow_step_id)
			{
				return $step;
			}
		}

		return null;
	}

	/**
	 * Get Workflow Steps
	 *
	 * Returns a list of workflow steps for the given Project ID for
	 * the OnTime installation.
	 */
	public function get_workflow_steps($project_id)
	{
		$workflow_id = $this->_get_workflow($project_id);
		if (!$workflow_id)
		{
			return array(); // No defect workflow for this project.
		}

		$response = $this->_send_command(
			'GET',
			"workflows/$workflow_id"
		);

		$workflow = $response->data; // <workflow>

		$result = array();
		if ($workflow->id == $workflow_id)
		{
			foreach ($workflow->workflow_steps as $steps)
			{
				$s = obj::create();
				$s->id = (int) $steps->id;
				$s->name = (string) $steps->name;
				$result[] = $s;
			}
		}

		return $result;
	}

	/**
	 * Get Workflows 
	 *
	 * Returns the valid defect workflow for the given Project ID.
	 */
	private function _get_workflow($project_id)
	{
		$response = $this->_send_command(
			'GET',
			$this->_format_url(
				"projects/$project_id",
				array(
					'item_type' => 'features',
					'extend' => 'workflows'
				)
			)
		);

		$data = $response->data;

		$result = '';
		if (isset($data->workflows))
		{
			foreach ($data->workflows as $workflow)
			{
				if ($workflow->item_type == 'features')
				{
					$result = $workflow->id;
				}
			}
		}

		return $result;
	}

	/**
	 * Get Defect
	 *
	 * Gets an existing defect from the OnTime installation with the
	 * given ID.
	 */	 
	public function get_defect($defect_id)
	{
		try
		{
			$response = $this->_send_command(
				'GET',
				'features/' . urlencode($defect_id)
			);
		}
		catch (Exception $e)
		{
			$this->_throw_error('The requested defect does not exist');
		}

		$defect = $response->data; // <defects>
		
		if (!isset($defect->id))
		{
			$this->_throw_error('The requested defect does not exist');
		}
		
		//var_dump($response);

		return $defect;
	}

	/**
	 * Get Customfield Values
	 *
	 * @return array
	 */
	public function get_customfields(): array
	{
		return $this->_send_command('GET', 'fields/custom')->data;
	}

	/**
	 * Get Customfield Values
	 *
	 * @param int    $picklistId Pick List ID.
	 * @param string $catType    Category Type.
	 *
	 * @return array
	 */
	public function get_custom_picklist(int $picklistId, string $catType): array
	{
		$result = [];
		$response = $this->_send_command('GET', 'picklists/custom/' . urlencode($picklistId));
		$picklists = $response->data->values;
		foreach ($picklists as $picklist) {
			$result[] = (object) [
				'id' => ($catType === 'multiselect') ? (string) $picklist->value : (int) $picklist->id,
				'name' => $picklist->value
			  ];
		}

		return $result;
	}

	/**
	* Add Defect
	*
	* Adds a new defect to the OnTime installation with the given
	* parameters and returns its ID.
	*
	* @param array|object $options Default configuration.
	* @param array        $paths   Attachments.
	*
	* @return int
	*/
	public function add_defect($options, array $paths): int
	{
		$data = $options;
		$custFields = [];
		foreach ($options as $fieldName => $fieldValue) {
			if (empty($fieldValue)) {
				continue;
			}
			if (isset($fieldName)) {
				if ($fieldName === 'name') {
					$data[$fieldName] = $fieldValue;
				} elseif ($fieldName === 'description'){
					$data[$fieldName] = nl2br(
						html::link_urls(
							h($fieldValue)
						)
					);
				} elseif (str::starts_with($fieldName, 'custom_')) {
					$custFields[$fieldName] = $fieldValue;
				} else {
					$data[$fieldName] = ['id' => $fieldValue];
				}
			}
		}
		if (!empty($custFields)) {
			$data['custom_fields'] = $custFields;
		}
		$response = $this->_send_command(
			'POST',
			'features',
			$data
		);
		$defect = $response->data;
		$defectId = (int) $defect->id;
		if (!isset($defectId)) {
			$this->_throw_error('No issue ID received');
		}
		foreach ($paths ?? [] as $path) {
			$this->_add_attachment($path, $defectId);
		}

		return $defectId;
	}

    /**
     * Add attachment to the ticket.
     *
     * @param string $path     User uploaded file path.
     * @param int    $defectId Defect ID.
     *
     * @return void
     */
    private function _add_attachment(string $path, int $defectId)
    {
		if (!$this->_curl) {
			$this->_curl = http::open();
		}
		$response = http::request_ex(
			$this->_curl,
			'POST',
			$this->_address . 'api/v6/features/' . $defectId . '/attachments?' .
			http_build_query([
				'file_name' => basename($path)
			]),
			[
				'data' => file_get_contents($path),
				'headers' => [
					'Content-Type' => 'application/octet-stream',
					'X-Authorization' => "Bearer $this->_token"
				]
			]
		);

		if (logger::is_on(GI_LOG_LEVEL_DEBUG)) {
			logger::debugr('Got the following response');
			logger::debugr('response', $response);
		}

		if ($response->code !== 200) {
			$this->_throw_error(
				'Invalid HTTP code ({0})', $response->code
			);
		}
	}
}

class OnTime_RESTException extends Exception
{
}
