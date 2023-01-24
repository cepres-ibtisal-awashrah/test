<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

/**
 * Jira Defect Plugin for TestRail
 *
 * Copyright Gurock Software GmbH. All rights reserved.
 *
 * This is the TestRail defect plugin for Atlassian Jira. Please see
 * http://docs.gurock.com/testrail-integration/defects-plugins for
 * more information about TestRail's defect plugins.
 *
 * http://www.gurock.com/testrail/
 *
 * FIXME: Why this file does have two old copies?
 *
 * FIXME: /tools/defect-jira-rest/Jira_REST.php
 * FIXME: /tools/defect-jira-rest-steps/Jira_REST.php
 */

include_once APPPATH . 'enums/' . HttpMethodCodesEnum::class . '.php';

class Jira_REST_defect_plugin extends Defect_plugin
{
	public $userKey = 'user';
	public $secretKey = 'password';

	private $_api;

	private $_address;
	private $_user;
	private $_secret;
	private $_subtasks_enabled = false;
	private $_subtasks_autofill = false;
	private $_links_autofill = false;

	private $_default_fields = array(
		'summary' => 'on',
		'project' => 'on',
		'issuetype' => 'on',
		'status' => 'on',
		'components' => 'on',
		'assignee' => 'on',
		'priority' => 'on',
		'affects_version' => 'on',
        	'epic' => 'on',
        	'sprint' => 'on',
		'fix_version' => 'off',
		'estimate' => 'off',
		'labels' => 'off',
		'environment' => 'off',
		'parent' => 'off',
		'linktype' => 'off',
		'links' => 'off',
		'description' => 'on',
        'attachments'=> 'on',

	);

	private $_field_defaults = array(
		'summary' => array(
			'type' => 'string',
			'label' => 'Summary',
			'size' => 'full',
			'required' => true
		),
		'project' => array(
			'type' => 'dropdown',
			'label' => 'Project',
			'required' => true,
			'remember' => true,
			'cascading' => true,
			'size' => 'compact'
		),
		'issuetype' => array(
			'type' => 'dropdown',
			'label' => 'Issue Type',
			'required' => true,
			'remember' => true,
			'cascading' => true,
			'depends_on' => 'project',
			'size' => 'compact'
		),
		'status' => [
		    'type' => 'dropdown',
		    'label' => 'Status',
		    'required' => false,
		    'remember' => false,
		    'size' => 'compact'
		],
		'components' => [
		    'type' => 'dropdown',
		    'label' => 'Components',
		    'required' => false,
		    'remember' => true,
		    'depends_on' => 'project',
		    'size' => 'compact',
		    'api_field' => 'components'
		],
		'assignee' => [
		        'type' => 'dropdown',
		        'label' => 'Assignee',
		        'required' => false,
		        'remember' => true,
		        'depends_on' => 'project',
		        'size' => 'compact'
		],
		'priority' => array(
			'type' => 'dropdown',
			'label' => 'Priority',
			'required' => false,
			'remember' => true,
			'depends_on' => 'project',
			'size' => 'compact'
		),
		'affects_version' => array(
			'type' => 'dropdown',
			'label' => 'Affects Version',
			'required' => false,
			'remember' => true,
			'depends_on' => 'project',
			'size' => 'compact',
			'api_field' => 'versions'
		),
		'epic' => array(
		        'type' => 'dropdown',
		        'label' => 'Epic',
		        'required' => false,
		        'remember' => true,
		        'depends_on' => 'project',
		        'size' => 'compact'
		),
		'sprint' => array(
		        'type' => 'dropdown',
		        'label' => 'Sprint',
		        'required' => false,
		        'remember' => true,
		        'depends_on' => 'project',
		        'size' => 'compact',
		        'api_field' => 'customfield_10020'
		),
		'fix_version' => array(
			'type' => 'dropdown',
			'label' => 'Fix Version',
			'required' => false,
			'remember' => true,
			'depends_on' => 'project',
			'size' => 'compact',
			'api_field' => 'fixVersions'
		),
		'environment' => array(
			'type' => 'text',
			'label' => 'Environment',
			'rows' => 4,
			'required' => false
		),
		'estimate' => array(
			'type' => 'string',
			'label' => 'Estimate',
			'required' => false,
			'size' => 'compact'
		),
		'labels' => array(
			'type' => 'string',
			'label' => 'Labels',
			'description' => 'A comma separated list of labels.',
			'required' => false,
			'size' => 'full'
		),
		'description' => array(
			'type' => 'text',
			'label' => 'Description',
			'required' => false,
			'rows' => 10,
			'dropzone_enabled' => true
		),
		'parent' => array(
			'type' => 'string',
			'label' => 'Parent Task',
			'required' => false,
			'size' => 'compact'
		),
		'linktype' => array(
			'type' => 'dropdown',
			'label' => 'Link Type',
			'required' => false,
			'size' => 'compact'
		),
		'links' => array(
			'type' => 'string',
			'label' => 'Issue Links',
			'required' => false,
			'size' => 'compact'
		),
		'attachments' => array(
		    'type' => 'dropbox',
		    'label'=>'attachments',
		    'required' => false,
		    'size' => 'none'
		)
	);

	protected static $_meta_defects = array(
		'author' => 'Gurock Software',
		'version' => '1.0',
		'description' => 'JIRA defect plugin for TestRail',
		'can_push' => true,
		'can_lookup' => true,
		'default_config' => 
			'; Please configure your JIRA connection below.
;
; Note: requires JIRA Server 5 or later. For Cloud version use
; JIRA Cloud. You can use the \'JIRA SOAP\' defect plugin
; for older versions.
[connection]
address=https://<your-server>/
user=testrail
password=secret

[push.fields]
project=on
issuetype=on
status=on
components=on
assignee=on
priority=on
affects_version=on
sprint=on
epic=on
fix_version=off
estimate=off
labels=off
environment=off
parent=off
linktype=off
links=off
description=on
attachments=on

[hover.fields]
summary=on
project=on
issuetype=on
status=on
components=on
assignee=on
priority=on
affects_version=on
sprint=on
epic=on
fix_version=off
estimate=off
labels=off
environment=off
parent=off
linktype=off
links=off
description=on
');

	protected static $_meta_references = array(
		'author' => 'Gurock Software',
		'version' => '1.0',
		'description' => 'JIRA reference plugin for TestRail',
		'can_push' => false, // Lookup only
		'can_lookup' => true,
		'default_config' => 
			'; Please configure your JIRA connection below.
;
; Note: requires JIRA Server 5 or later. For Cloud version use
; JIRA Cloud. You can use the \'JIRA SOAP\' defect plugin
; for older versions.
[connection]
address=https://<your-server>/
user=testrail
password=secret

[hover.fields]
summary=on
project=on
issuetype=on
status=on
components=on
assignee=on
priority=on
affects_version=on
sprint=on
epic=on
fix_version=off
estimate=off
labels=off
environment=off
parent=off
linktype=off
links=off
description=on
');

	public function get_meta()
	{
		if ($this->get_type() == GI_INTEGRATION_TYPE_REFERENCES)
		{
			return static::$_meta_references;
		}
		else 
		{
			return static::$_meta_defects;
		}
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
        foreach (['address', $this->userKey, $this->secretKey] as $key) {
            if (!isset($connection[$key]) || !$connection[$key]) {
                throw new ValidationException(
                    "Missing configuration for key '$key'"
                );
            }
        }
        $address = $connection['address'];
        if (!check::url($address)) {
            throw new ValidationException('Address is not a valid url');
        }
        foreach (['push.fields', 'hover.fields'] as $fieldSection) {
            $fieldList = $ini[$fieldSection] ?? [];
            foreach ($fieldList as $field => $option) {
                if ($option === 'on') { 
                    $this->_validate_field($ini, $field);
                }
            }
            if ($fieldSection === 'push.fields' && !empty($fieldList)) {
                foreach (['project', 'issuetype'] as $requiredField) {
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

	private function _validate_field($ini, $field)
	{
		static $valid_types = array(
			'dropdown' => true,
			'multiselect' => true,
			'text' => true,
			'string' => true
		);
		$category = $this->_get_category_configuration($field, $ini);	
		// Custom fields must always have a separate category.
		if (str::starts_with($field, 'customfield_'))
		{
			if (!$category)
			{
				throw new ValidationException(
					str::format(
						'Field "{0}" is enabled but configuration ' .
						'section [field.settings.{0}] is missing',
					 	$field
					 )
				);
			}

			$keys = array('label', 'type');
			foreach ($keys as $key)
			{
				if (!isset($category[$key]))
				{
					throw new ValidationException(
						str::format(
							'Missing configuration for key "{0}" in ' . 
							'section [push.field.{1}]',
							$key,
							$field
						)
					);
				}
			}
		}

		// The specified type must be well-known.
		$type = arr::get($category, 'type');
		if ($type)
		{
			if (!isset($valid_types[str::to_lower($type)]))
			{
				throw new ValidationException(
					str::format(
						'Invalid field type specified in section ' .
						'[push.field.{0}]',
						$field
					)
				);
			}
		}
	}

	public function configure($config)
	{
		$ini = ini::parse($config);
		$this->_address = $this->_sanetize_address(
			$ini['connection']['address']
		);
		$this->_user = $ini['connection'][$this->userKey];
		$this->_secret = $ini['connection'][$this->secretKey];
		$this->_config = $ini;
	}

	private function _sanetize_address($address)
	{
		// We work around common configuration issues with the JIRA
		// address by removing often used but invalid paths/addresses.

		$replace = array(
			'\\/secure\\/Dashboard\\.jspa\\??$' => '',
			'\\/secure\\/MyJiraHome\\.jspa\\??$' => '',
			'\\/secure\\/CreateIssue!default\\.jspa\\??$' => '',
			'\\/login\\?dest-url=.*$' => '',
			'\\/login\\??$' => '',
		);

		foreach ($replace as $re => $value)
		{
			$address = preg_replace("/$re/i", $value, $address);
		}

		return str::slash($address);
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

		$this->_api = new Jira_REST_api(
			$this->_address,
			$this->_user,
			$this->_secret
		);
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
	* @param array|object $context default configuration.
	* 
	* @return array
	*/
	public function prepare_push($context): array
	{
		$fields = [];
		$fieldsConfig = isset($this->_config['push.fields'])
		    ? ['summary' => 'on'] + $this->_config['push.fields']
		    : $this->_default_fields;
		// Return a form with a dynamic list of fields/properties,
		// based on the configuration of the defect plugin.
		foreach ($fieldsConfig as $fieldName => $option) {
			if ($option !== 'on') {
				continue;
			}
			$field = $this->_field_defaults[$fieldName] ?? [];
			$category = $this->_get_category_configuration($fieldName, $this->_config);
			if ($category) {
				foreach ($category as $prop => $val) {
					$property = str::to_lower($prop);
					$value = str::to_lower($val);
					if ($property === 'label') {
						$field[$property] = $val;
						continue;
					}
					if (in_array($property, ['required', 'remember', 'cascading'])) {
						$final_value = $value === 'true';
					} elseif ($property === 'rows') {
						$final_value = (int) $value;
					} else {
						$final_value = $value;
					}
					// This may override the default value from above.
					$field[$property] = $final_value;
				}
			}
			if (str::starts_with($fieldName, 'customfield_')) {
				// All custom fields depend on the issue type (and
				// indirectly on the project).
				$field['depends_on'] = 'issuetype';
			}
			if($fieldName === 'epic') {
				$field['depends_on'] = 'issuetype';
			}
			$fields[$fieldName] = $field;
		}
		$result = array('fields' => $fields);
		// The user can also customize the width of the dialog.
		if (isset($this->_config['push.dialog']['width'])) {
			$result['width'] = 
				(int) $this->_config['push.dialog']['width'];
		}
		if (isset($fields['parent'])) {
			// Set the sub-task related fields
			$this->_subtasks_enabled = true;
			$autofill = arr::get($fields['parent'], 'autofill');
			if ($autofill) {
				$this->_subtasks_autofill = 
					str::to_lower($autofill) === 'on';
			}
		}
		if (isset($fields['links'])) {
			$autofill = arr::get($fields['links'], 'autofill');
			if ($autofill) {
				$this->_links_autofill = 
					str::to_lower($autofill) === 'on';
			}
		}
		// Save the form for later use in prepare_field().
		$this->_form = $result;

		return $result;
	}

	/**
	* Checks if "field.settings" and "push.fields" categories are available.
	* If available it will fetch respective property and values from configuration box.
	*
	* @param string  $fieldName field name defined in config.
	* @param array   $config    configuration array
	* 
	* @return array|null
	*/
	private function _get_category_configuration($fieldName, $config)
	{
		return arr::get($config, "field.settings.$fieldName")
		?? arr::get($config, "push.field.$fieldName");
	}

	private function _get_summary_default($context)
	{
		$test = current($context['tests']);
		$summary = 'Failed test: ' . $test->case->title;
		
		if ($context['test_count'] > 1)
		{
			$summary .= ' (+others)';
		}

		return $summary;
	}

	private function _get_description_default($context)
	{
		return $context['test_change']->description;
	}

	private function _get_parent_default($context)
	{
		if (!$this->_subtasks_autofill)
		{
			return null;
		}
		
		foreach ($context['tests'] as $test)
		{
			$case = $test->case;
			if ($case->refs)
			{
				$refs = str::split($case->refs, ',');
				if ($refs)
				{
					// We can only use one reference as the parent.
					return $refs[0];
				}
			}
		}

		return null;
	}
	
	private function _get_links_default($context)
	{
		if (!$this->_links_autofill)
		{
			return null;
		}
		
		$refs = '';
		foreach ($context['tests'] as $test)
		{
			$case = $test->case;
			if ($case->refs)
			{
				if ($refs)
				{
					$refs .= ', ';
				}

				$refs .= $case->refs;
			}
		}

		return $refs;
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

	public function prepare_field($context, $input, $field)
	{
		$data = array();

		// Process those fields that do not need a connection to the
		// Jira installation.	
		if ($field == 'summary' || $field == 'description' ||
			$field == 'parent' || $field == 'links')
		{
			switch ($field)
			{
				case 'summary':
					$data['default'] = $this->_get_summary_default(
						$context);
					break;
					
				case 'description':
					$data['default'] = $this->_get_description_default(
						$context);
					break;

				case 'parent':
					$data['default'] = $this->_get_parent_default(
						$context);
					break;

				case 'links':
					$data['default'] = $this->_get_links_default(
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
			case 'project':
				$data['default'] = arr::get($prefs, 'project');
				$data['options'] = $this->_to_id_name_lookup(
					$api->get_projects()
				);
				break;

			case 'issuetype':
				$data['options'] = $this->_to_id_name_lookup(
					$api->get_types(
						$input['project'],
						$this->_subtasks_enabled
					)
				);
				
				// Select the stored preference or the first item in
				// the list otherwise.
				$default = arr::get($prefs, 'issuetype');
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

			case 'assignee':
				$data['default'] = arr::get($prefs, 'assignee');
				$data['options'] = $this->_to_id_name_lookup(
					$api->get_assignees($input['project'])
				);
				break;

			case 'components':
				$data['default'] = arr::get($prefs, 'components');
				$data['options'] = $this->_to_id_name_lookup(
					$api->get_components($input['project'])
				);
				break;

			case 'affects_version':
			case 'fix_version':
				$show_archived = true;
				$show_released = true;
				$show_overdue = true;

				$category = arr::get(
					$this->_config, "push.field.$field"
				);

				if ($category)
				{
					if (isset($category['show_archived']))
					{
						if ($category['show_archived'] == 'false')
						{
							$show_archived = false;
						}
					}

					if (isset($category['show_released']))
					{
						if ($category['show_released'] == 'false')
						{
							$show_released = false;
						}
					}

					if (isset($category['show_overdue']))
					{
						if ($category['show_overdue'] == 'false')
						{
							$show_overdue = false;
						}
					}
				}

				$data['default'] = arr::get($prefs, $field);
				$data['options'] = $this->_to_id_name_lookup(
					$api->get_versions(
						$input['project'],
						$show_archived,
						$show_released,
						$show_overdue
					)
				);
				break;
				
			case 'epic':
				$data['default'] = arr::get($prefs, 'epic');
				$data['options'] = $this->_to_id_name_lookup(
					$api->get_epics($input['project'],  $input['issuetype'])
				);
				break;

			case 'sprint':
				$data['default'] = arr::get($prefs, 'sprint');
				$data['options'] = $this->_to_id_name_lookup(
               					 	$api->get_sprints($input['project'])
						   );
				break;          


            		case 'priority':
				$data['default'] = arr::get($prefs, 'priority');
				$data['options'] = $this->_to_id_name_lookup(
					$api->get_priorities($input['project'] ?? '')
				);
				break;

			case 'linktype':
				$data['default'] = arr::get($prefs, 'linktype');
				$data['options'] = $this->_to_id_name_lookup(
					$api->get_link_types()
				);
				break;
		}

		if (str::starts_with($field, 'customfield_'))
		{
			// All custom fields depend on both the project and issue
			// type.
			$data['default'] = arr::get($prefs, $field);
			$data['options'] = $this->_to_id_name_lookup(
				$api->get_customfield_values(
					$input['project'],
					$input['issuetype'],
					$field
				)
			);
		}

		// Prevent an error message in case the field was a multi-
		// select and was changed back to dropdown. The preferences
		// would be an array in this case and the defects controller
		// may raise an error. We need to clear the default value
		// in this case.

		$fields = arr::get($this->_form, 'fields');
		if ($fields[$field]['type'] == 'dropdown')
		{
			$default = arr::get($data, 'default');
			if (is_array($default))
			{
				$data['default'] = '';
			}
		}

		return $data;
	}
	
	public function validate_push($context, $input)
	{
	}

	public function push($context, $input, $path= null)
	{
		$api = $this->_get_api();		
		return $api->add_issue($input, $path);
	}

	/**
     * Return attribute label from multi or text field name.
     *
     * @param $fieldNames Configuration field names
     *
     * @return string
     */
    private function getAttributeLabel($fieldNames)
    {
		if (is_string($fieldNames)) {
			return $fieldNames;
		}
		
		if(isset($fieldNames->value)) {
			return h($fieldNames->value);
		} 
		
		return implode(' ', array_column($fieldNames, 'value'));
    }

    /**
     * Lookup
     *
     * Creates an array of objects of default and custom field with default and
     * user defined configuration to display on hover popup.
     *
     * @param int $defectId Defect id of an issue.
     *
     * @throws Jira_RESTException
     * 
     * @return array
     */
    public function lookup($defectId): array
    {
        $fields = $attributes = [];
        $description = null;
        $issue = $this->_get_api()->get_issue($defectId);
        $fullAttributes = [];
        $issueFields = $issue->fields;
        $status = $issueFields->status->name ?? '';
        $status_id = empty($issueFields->resolution)
            ? GI_DEFECTS_STATUS_OPEN
            : GI_DEFECTS_STATUS_RESOLVED;
        $fieldsConfig = $this->_config['hover.fields'] ?? $this->_default_fields;
        foreach ($fieldsConfig as $fieldName => $option) {
            if ($option !== 'on' || in_array($fieldName, ['summary', 'attachments'])) {
                continue;
            }
            if (isset($this->_field_defaults[$fieldName])) {
                $field = $this->_field_defaults[$fieldName];
            } else {
                $field = str::starts_with($fieldName, 'customfield_')
                    ? $this->_get_category_configuration($fieldName, $this->_config)
                    : [];
            }
            $apiField = $field['api_field'] ?? null;

            if (in_array($fieldName, ['issuetype', 'project', 'status', 'priority'])
                && isset($issueFields->$fieldName->name)) {
                $value = h($issueFields->$fieldName->name);
            } elseif (in_array($fieldName, ['components', 'affects_version', 'fix_version', 'sprint'])
                && !empty($issueFields->$apiField)) {
                $value = implode(' ', array_column($issueFields->$apiField, 'name'));
            } elseif ($fieldName === 'project' && isset($issueFields->$fieldName->name)) {
                $value = str::format(
                    '<a target="_blank" href="{0}browse/{1}">{2}</a>',
                    a($this->_address),
                    a($issueFields->project->key),
                    h($issueFields->project->name)
                );
            } elseif ($fieldName === 'assignee' && isset($issueFields->$fieldName->displayName)) {
                $value = h($issueFields->$fieldName->displayName);
            } elseif (isset($issueFields->$fieldName) && str::starts_with($fieldName, 'customfield_')) {
                $value = $this->getAttributeLabel($issueFields->$fieldName);
            } elseif ($fieldName === 'labels') {
                $value = implode(', ', $issueFields->labels);
            } elseif ($fieldName === 'environment') {
                $value = $issueFields->$fieldName;
            } elseif ($fieldName === 'estimate' && isset($issueFields->timetracking->originalEstimate)) {
                $value = $issueFields->timetracking->originalEstimate;
            } elseif ($fieldName === 'links' || $fieldName === 'linktype' && !empty($issueFields->issuelinks)) {
                $links = [];
                foreach($issueFields->issuelinks ?? [] as $link) {
                    $is_inward_issue = empty($link->outwardIssue);
                    $links[] = $fieldName === 'links'
                        ? ($is_inward_issue ? h($link->inwardIssue->key) : h($link->outwardIssue->key))
                        : ($is_inward_issue ? h($link->type->inward) : h($link->type->outward));
                }
                $value = implode(', ', $links);
            } else {
				$value = "&ndash;";
            }
            if ($fieldName === 'description') {
                $description = str::format(
					'<div class="monospace">{0}</div>',
					nl2br(html::link_urls(h($issueFields->description)))
                );
            } elseif (!isset($field['size']) || ($field['size'] === 'full'
                && in_array($field['type'], ['text', 'string']))
                && isset($value)
            ) {
                $fullAttributes[$field['label']] = str::format(
                    '<div class="monospace">{0}</div>',
                    strip_tags(html_entity_decode($value))
                );
            } else {
                $attributes[$field['label']] = $value;
            }
        }
        if (!isset($issue->fields->summary)) {
            throw new Jira_RESTException(
                'Invalid response from JIRA (issue is missing the Summary field).'
            );
        }

        return [
            'id' => $defectId,
            'url' => str::format(
                '{0}browse/{1}',
                $this->_address,
                $defectId
            ),
            'title' => $issue->fields->summary,
            'status_id' => $status_id,
            'status' => $status,
            'description' => $description,
            'attributes' => $attributes,
            'fullAttributes' => $fullAttributes
        ];
    }
}

/**
 * Jira REST API
 *
 * Wrapper class for the Jira REST API with functions for retrieving
 * projects, getting and issues etc.
 */
class Jira_REST_api
{
	private $_address;
	private $_user;
	private $_secret;
	private $_curl;

	private $jira_cloud;  

	private $_createmeta = array();
	private const JIRA_PRIORITY_SCHEME_MIN_VERSION = '7.7.0';

	/**
	 * Jira_REST_api constructor.
	 *
	 * Initializes a new Jira API object. Expects the web address
	 * of the Jira installation including http or https prefix.
	 *
	 * @param string $address
	 * @param string $user JIRA Cloud email / JIRA Server
	 * @param string $secret JIRA Cloud token / JIRA Server password
	 */
	public function __construct($address, $user, $secret)
	{
		$this->_address = str::slash($address);
		$this->_user = $user;
		$this->_secret = $secret;
	}

	/**
	 * Get Types
	 *
	 * Returns a list of issue types for the Jira installation. The
	 * issue types are returned as array of objects, each with its ID
	 * and name.
	 */	
	public function get_types($project_key, $allow_subtasks = true)
	{
		$response = $this->_send_command(
			'GET', 
			"project/$project_key"
		);
		
		if (!$response->issueTypes)
		{
			return array();
		}
		
		$result = array();
		foreach ($response->issueTypes as $type)
		{
			if (!$allow_subtasks)
			{
				if (isset($type->subtask) && $type->subtask)
				{
					continue; // A sub-task issue type
				}
			}

			$t = obj::create();
			$t->id = (string) $type->id;
			$t->name = (string) $type->name;
			$result[] = $t;
		}
		
		return $result;
	}
	
	/**
	 * Get Projects
	 *
	 * Returns a list of projects for the Jira installation. The
	 * projects are returned as array of objects, each with its ID
	 * and name.
	 */	
	public function get_projects()
	{
		$response = $this->_send_command('GET', 'project');
		
		if (!$response)
		{
			return array();
		}
		
		$result = array();
		foreach ($response as $project)
		{
			$p = obj::create();
			$p->id = (string) $project->key;
			$p->name = (string) $project->name;
			$result[] = $p;
		}
		
		return $result;
	}

	/** 
	 * Get Assignees in batches of $limit
	 * 
	 * Return a list of Assignees based on $offset and $limit, as the
	 * Jira API limits the number of results to 1000, 50 if no limit
	 * is specified.
	 */
	private function _get_assignee_batches($project_key, $offset, 
		$limit)
	{
		$response = $this->_send_command(
			'GET',
			str::format(
				"user/assignable/search?project={0}&startAt={1}&maxResults={2}",
				$project_key,
				$offset,
				$limit
			)
		);
		
		return $response;
	}

	/**
	 * Get Assignee
	 *
	 * Returns a list of assignees for the given project for the Jira
	 * installation. Assignees are returned as array of objects, each
	 * with its name (ID) and display name.
	 *
	 * GDPR: name to accountId
	 */
	public function get_assignees($project_key)
	{
		$offset = 0;
		$limit = 999;

		$r = $this->_get_assignee_batches($project_key, $offset, $limit);
		$response = $r;

		$count = count($r);
		while ($count == $limit)
		{
			$offset += $limit;
			$r = $this->_get_assignee_batches($project_key, $offset,
				$limit);

			$count = count($r);
			if ($count > 0)
			{
				$response = array_merge($response, $r);
			}
		}

		if (!$response)
		{
			return array();
		}
		
		$result = array();
		foreach ($response as $assignee)
		{
			$a = obj::create();
			if (property_exists($assignee, 'accountId'))
			{
				$this->jira_cloud = 1;
				$a->id = (string) $assignee->accountId;
			} else 
			{
				$this->jira_cloud = 0;
				$a->id = (string) $assignee->name;
			}
			$a->name = (string) $assignee->displayName;
			$result[] = $a;
		}
		
		return $result;
	}

	/**
	 * Get Components
	 *
	 * Returns a list of components for the given project for the Jira
	 * installation. Components are returned as array of objects, each
	 * with its ID and name.
	 */
	public function get_components($project_key)
	{
		$response = $this->_send_command(
			'GET',
			"project/$project_key/components"
		);

		if (!$response)
		{
			return array();
		}
		
		$result = array();
		foreach ($response as $component)
		{
			$c = obj::create();
			$c->id = (string) $component->id;
			$c->name = (string) $component->name;
			$result[] = $c;
		}
		
		return $result;
	}

	public function get_epics($project_key, $issue_type)
	{
		$issue_types = $this->get_types($project_key);
		$epic_field = null;
		foreach ($issue_types as $issue)
		{
			if($issue->name == 'Epic'){
				$epic_field = $issue->id;
			}
		}

		if($issue_type == $epic_field)
		{
			return array();
		}

		$field = $this->_address . 'rest/api/2/field/';
		$res = $this->_send_request('GET', $field, null);
		$name_custom_id = 0;
		foreach ($res as $r){
			if($r->name == 'Epic Name'){
				$name_custom_id = $r->id;
				break;
			}
		}

		$result = array();
		$count = 0;

		do {
			$url = 'search?jql=project='.$project_key.'%20AND%20issuetype=Epic&startAt=' . strval($count);;
			$response = $this->_send_command('GET',
				$url
			);

			foreach ($response->issues as $epic)
			{
				$epic_object = obj::create();
				$epic_object->id = (string) $epic->key;
				$epic_object->name = (string) $epic->fields->$name_custom_id." - (".$epic->key. ")";
				$result[] = $epic_object;
			}
			$count += 50;
		} while(count($response->issues) > 0);

		return $result;
    }

    /* Get the available sprints which are active or open*/
    public function get_sprints($project)
    {
        $url = $this->_address.'rest/agile/1.0/board?projectKeyOrId='.$project;
        $response = $this->_send_request('GET', $url, null);
        if(!$response->values)
        {
            return array();
        }
        $result = array();

        foreach ($response->values as $board)
        {
            if (in_array($board->type, ['simple', 'scrum'])) {
                $count = 0;
                do {
                    $url = $this->_address . 'rest/agile/1.0/board/' . $board->id . '/sprint?startAt=' . strval($count);
                    $sprints = $this->_send_request('GET', $url, null);
                    if ($sprints->values) {
                        foreach ($sprints->values as $sprint) {
                            if ($sprint->state !== 'closed') {
                                $sprint_obj = obj::create();
                                $sprint_obj->id = (string)$sprint->id;
                                $sprint_obj->name = (string)$sprint->name;
                                $result[] = $sprint_obj;
                            }
                        }
                    }
                    $count += 50;
                } while(count($sprints->values) > 0);
            }
        }
        return $result;
    }

	/**
	 * Get Versions
	 *
	 * Returns a list of versions for the given project for the Jira
	 * installation. Versions are returned as array of objects, each
	 * with its ID and name.
	 */
	public function get_versions($project_key, $show_archived,
		$show_released, $show_overdue)
	{
		$response = $this->_send_command(
			'GET',
			"project/$project_key/versions"
		);

		if (!$response)
		{
			return array();
		}

		$result = array();
		foreach ($response as $version)
		{
			// Don't show Archived versions if they are disabled in the
			// configuration.
			if (!$show_archived && $version->archived)
			{
				continue;
			}

			// Don't show Released versions if they are disabled in the
			// configuration.
			if (!$show_released && $version->released)
			{
				continue;
			}

			// Don't show Overdue versions if they are disabled in the
			// configuration.
			if (isset($version->overdue))
			{
				if (!$show_overdue && $version->overdue)
				{
					continue;
				}
			}

			$v = obj::create();
			$v->id = (string) $version->id;
			$v->name = (string) $version->name;
			$result[] = $v;
		}
		
		return $result;
	}

	/**
	 * Get Link Types
	 *
	 * Returns a list of link types for the given project for the Jira
	 * installation. Link types are returned as array of objects, each
	 * with its ID and name.
	 */
	public function get_link_types()
	{
		$response = $this->_send_command('GET', 'issueLinkType');

		if (!$response)
		{
			return array();
		}

		if (!isset($response->issueLinkTypes))
		{
			return array();
		}

		$result = array();
		foreach ($response->issueLinkTypes as $type)
		{
			$t = obj::create();
			$t->id = (string) $type->id;
			$t->name = (string) $type->name;
			$result[] = $t;
		}
		
		return $result;
	}

	/**
	 * Get Priorities
	 *
	 * Returns a list of priorities for the given project for the Jira
	 * installation. Priorities are returned as array of objects, each
	 * with its ID and name.
	 *
	 * @param string $project_key
	 *
	 * @return array
	 */
	public function get_priorities(string $project_key = ''): array
	{
		$response = $this->_send_command('GET', 'priority');

		if (!$response)
		{
			return array();
		}
		
		$result = array();
		foreach ($response as $priorities)
		{
			$p = obj::create();
			$p->id = (string) $priorities->id;
			$p->name = (string) $priorities->name;
			$result[] = $p;
		}

        $serverInfo = $this->_send_command('GET', 'serverInfo');
		$havePermission = false;

		if (!empty($serverInfo->deploymentType) && str::to_upper($serverInfo->deploymentType) === 'SERVER') {
            $havePermissionInfo = $this->_send_command('GET', 'mypermissions');

            if (!empty($havePermissionInfo) && $havePermissionInfo->permissions->PROJECT_ADMIN->havePermission) {
                    $havePermission = true;
            }
        }

		if (!empty($project_key) && !empty($result) && $havePermission) {
			if (
				!empty($serverInfo->deploymentType)
				&& str::to_upper($serverInfo->deploymentType) === 'SERVER'
				&& version_compare($serverInfo->version, self::JIRA_PRIORITY_SCHEME_MIN_VERSION) >= 0
			) {
				$prioritySchemes = $this->_send_command('GET', 'priorityschemes?expand=schemes.projectKeys');

				foreach ($prioritySchemes->schemes ?? [] as $scheme) {
					if (
						is_array($scheme->optionIds)
						&& is_array($scheme->projectKeys)
						&& in_array($project_key, $scheme->projectKeys)
					) {
						foreach ($result as $scheme_key => $scheme_data) {
							if (!in_array($scheme_data->id, $scheme->optionIds)) {
								unset($result[$scheme_key]);
							}
						}
					}
				}
			}
		}

		return $result;
	}

	private function _get_createmeta($project_key, $issuetype)
	{
		if (isset($this->_createmeta[$project_key][$issuetype]))
		{
			return $this->_createmeta;
		}

		//Determine createmeta endpoint to use
		//https://developer.atlassian.com/server/jira/platform/jira-rest-api-examples/#createmeta-in-integrations-that-work-across-versions---detect-a-new-api-functionality
		$api_capabilities = $this->_send_request(
			'GET',
			$this->_address . '/rest/capabilities'
		);
		
		//Use createmeta from Jira 8.4 and forward
		if (isset($api_capabilities->{'capabilities'}->{'list-project-issuetypes'}))
		{
			//Maximum of 50 results
			$offset = 0;
			$limit = 50;
			$field_list = [];
			
			do {
				$meta = $this->_send_command(
					'GET',
					str::format(
						'issue/createmeta/{0}/issuetypes/{1}?startAt={2}&maxResults={3}',
						$project_key,
						$issuetype,
						$offset,
						$limit
					)
				);
				$offset += $limit;
				$field_list = array_merge($field_list, $meta->values);
				
			} while (!$meta->isLast);
			
			$field_options = obj::create();

			foreach ($field_list as $issue_field) {
				$field_options->{$issue_field->fieldId} = $issue_field;
			}
			$this->_createmeta[$project_key][$issuetype] = $field_options;
		} else {	//Use Jira Server 8.3 or Jira Cloud API endpoint
			$meta = $this->_send_command(
				'GET',
				str::format(
					'issue/createmeta?projectKeys={0}&issuetypeIds={1}&expand=projects.issuetypes.fields',
					$project_key,
					$issuetype
				)
			);
			
			foreach ($meta->projects as $project) 
			{
				foreach ($project->issuetypes as $issuetype) {
					$this->_createmeta[$project->key][$issuetype->id] = 
						$issuetype->fields;
				}
			}
		}
		return $this->_createmeta;
	}

	/**
	 * Get Customfield Values
	 *
	 * Returns a list of customfield values for the given project, 
	 * issue type and custom field name for the Jira installation.
	 * Priorities are returned as array of objects, each with its ID
	 * and value.
	 */
	public function get_customfield_values($project_key, $issuetype,
		$field_name)
	{
		$meta = $this->_get_createmeta($project_key, $issuetype);

		if (!isset($meta[$project_key][$issuetype]))
		{
			return array();
		}
		
		$fields = $meta[$project_key][$issuetype];

		if (!isset($fields->$field_name) || 
			!isset($fields->$field_name->schema->custom))
		{
			return array();
		}

		$field_meta = $fields->$field_name;
				
		switch ($field_meta->schema->custom)
		{
			case 'com.atlassian.jira.plugin.system.customfieldtypes:userpicker':
			case 'com.atlassian.jira.plugin.system.customfieldtypes:multiuserpicker':
				return $this->get_assignees($project_key);

			case 'com.atlassian.jira.plugin.system.customfieldtypes:grouppicker':
			case 'com.atlassian.jira.plugin.system.customfieldtypes:multigrouppicker':
				return $this->_get_customfield_values_groups(
					$project_key,
					$field_meta
				);

			default:
				return $this->_get_customfield_values_default(
					$project_key,
					$field_meta
				);
		}

		return $result;
	}

	private function _get_customfield_values_default($project_key,
		$field_meta)
	{
		if (!isset($field_meta->allowedValues))
		{
			return array();
		}

		$values = $field_meta->allowedValues;

		$result = array();
		foreach ($values as $field_id => $field_value)
		{
			// Handle the special case 'Cascading Select'
			if (isset($field_value->children))
			{
				foreach ($field_value->children as $child_value)
				{
					// Save the id of the parent and child separated
					// by ':' that way we can decode it when it's
					// selected in the dropdown, as we need to provide
					// parent and child id in add_issue().
					$c = obj::create();
					$c->id = (string) $field_value->id . ':' . 
						$child_value->id;
					$c->name = (string) $field_value->value . ' > ' .
						$child_value->value;
					$result[] = $c;
				}
			}
			else
			{
				$c = obj::create();
				$c->id = (string) $field_value->id;
				if (isset($field_value->value))
				{
					$c->name = (string) $field_value->value;
				}
				else 
				{
					$c->name = (string) $field_value->name;
				}
				$result[] = $c;
			}
		}

		return $result;
	}

	private function _get_customfield_values_groups()
	{
		$response = $this->_send_command(
			'GET',
			'groups/picker?maxResults=1000'
		);

		$result = array();
		foreach ($response->groups as $group)
		{
			$a = obj::create();
			$a->id = (string) $group->name;
			$a->name = (string) $group->name;
			$result[] = $a;
		}

		return $result;
	}

	/**
	 * Get Customfield Type
	 *
	 * Gets the full type of a custom field and returns it as string,
	 * e.g.:
	 * com.atlassian.jira.plugin.system.customfieldtypes:textfield
	 */
	private function _get_customfield_type($project_key, $issuetype, 
		$field_name)
	{
		$meta = $this->_get_createmeta($project_key, $issuetype);

		if (!isset($meta[$project_key][$issuetype]))
		{
			return array();
		}
		
		$fields = $meta[$project_key][$issuetype];

		$result = '';
		if (isset($fields->$field_name->schema->custom))
		{
			$result = $fields->$field_name->schema->custom;
		}

		return $result;
	}

	/**
	 * Get Issue
	 *
	 * Gets an existing case from the Jira installation and returns
	 * it. The resulting issue object has various properties such
	 * as the summary, description, project etc.
	 */	 
	public function get_issue($issue_id)
	{
		return $this->_send_command(
			'GET',
			'issue/' . urlencode($issue_id)
		);
	}

    	private function _add_sprint($issue, $sprint)
    	{
        	$url = $this->_address . 'rest/agile/1.0/sprint/' . $sprint . '/issue';
        	$post_data = array(
			'issues' => array($issue)
			);
        	return $this->_send_request('POST', $url, $post_data);
    	}


    	private function _add_epic($issue, $epic)
    	{
		$url = $this->_address . 'rest/agile/1.0/epic/' . $epic . '/issue';
		$post_data = array(
		    'issues' => array(
		        $issue
		    )
		);
        	return $this->_send_request('POST', $url, $post_data);
    	}

    private function _send_command($method, $command, $data = null, $isNewIssue = null)
	{
		return $this->_send_request(
		    $method,
            $this->_address . 'rest/api/2/' . $command,
            $data,
            $isNewIssue
        );
	}
	
	private function _send_request($method, $url, $data = null, $isNewIssue = null)
	{
	    if (!$isNewIssue) {
	        $method = strtolower(
	            HttpMethodCodesEnum::tryParse($method)
            );
        }

		if (!$this->_curl)
		{
			// Initialize the cURL handle. We re-use this handle to
			// make use of Keep-Alive, if possible.
			$this->_curl = http::open();
		}

		if (logger::is_on(GI_LOG_LEVEL_DEBUG))
		{
			logger::debug('Issuing Jira HTTP REST request');
			logger::debugr(
				'$request',
				array(
					'method' => $method,
					'url' => $url,
					'data' => $data
				)
			);
		}
				
		$response = http::request_ex(
			$this->_curl,
			$method, 
			$url, 
			array(
				'user' => $this->_user,
				'password' => $this->_secret,
				'data' => json::encode($data),
				'headers' => array(
					'Content-Type' => 'application/json',
					'x-atlassian-force-account-id' => 'true'
				)
			)
		);

		// In case debug logging is enabled, we append the data we've
		// sent and the entire request/response to the log.
		if (logger::is_on(GI_LOG_LEVEL_DEBUG))
		{
			logger::debug('Got the following response');
			logger::debugr('$response', $response);
		}

		$obj = json::decode($response->content);

		if ($response->code != 200 && $response->code != 201 && $response->code !=204)
		{
			if ($response->code == 401 || $response->code == 403)
			{
				$this->_throw_error(
					'Invalid user or password or insufficient permissions ' .
					'for the integration user (HTTP code {0}). Please ' .
				    'check the Jira User value in the Integration and/or ' .
				    'User Settings has been configured correctly.',
					$response->code
				);
			}
			elseif ($response->code != 400 || !$obj)
			{
				$this->_throw_error(
					'Invalid HTTP code ({0}). Please verify the address ' .
					'of your JIRA installation in the configuration ' .
					'settings and that TestRail can reach your JIRA ' . 
					'server.',
					$response->code
				);
			}
			else
			{
				$errors = '';

				if (isset($obj->errorMessages))
				{
					foreach ($obj->errorMessages as $error)
					{
						$errors .= "\n$error";
					}
				}

				if (isset($obj->errors))
				{
					foreach ($obj->errors as $field => $error)
					{
						$errors .= "\n$field: $error";
					}
				}

				$this->_throw_error($errors);
			}
		}

		return $obj;
	}

	/**
	 * Add Issue
	 *
	 * Adds a new issue to the Jira installation with the given
	 * parameters (title, project etc.) and returns its ID. The
	 * parameters must be named according to the Jira API format,
	 * e.g.:
	 *
	 * summary:     The summary of the new issue
	 * issuetype:   The ID of the type of the new issue (bug,
	 *              feature request etc.)
	 * project:     The ID of the project the issue should be added
	 *              to
	 * component:   The ID of the component the issue should be
	 *              added to
	 * description: The description of the new issue
	 */	
	public function add_issue($options, $path)
	{
		$this->jira_cloud = (bool) strpos($this->_address, '.atlassian.net');
		if(isset($options['epic']))
        	{
		    $epic = $options['epic'];
            	unset($options['epic']);
        	}
		if(isset($options['sprint']))
        	{
		    $sprint = $options['sprint'];
            	unset($options['sprint']);
        	}



		$fields = array();

		// Get the JIRA submit format for the fields to submit (system
		// and custom).
		foreach ($options as $field_name => $field_value)
		{
			if ($field_value === null || $field_value === '')
			{
				continue;
			}

			if (!str::starts_with($field_name, 'customfield_'))
			{
				if ($field_name == 'links' || $field_name == 'linktype')
				{
					continue;
				}

				$field = $this->_format_system_field(
					$field_name,
					$field_value);
			}
			else
			{
				$field = $this->_format_custom_field(
					$field_name,
					$field_value,
					$options['project'],
					$options['issuetype']
				);
			}

			if (isset($field['name']) && isset($field['value']))
			{
				$fields[$field['name']] = $field['value'];
			}
		}

		// Submit the JIRA issue.
		$data = array('fields' => $fields);
		$response = $this->_send_command('POST','issue', $data, true);
		$issue_id = $response->key;
		if(isset($epic))
		{
		    $this->_add_epic($response->key, $epic);
		}

		if(isset($sprint))
		{
		    $this->_add_sprint($response->key, $sprint);
		}

		if($path)
		{
		    foreach ($path as $p)
			$this->_add_attachment($response->self, $p);
		}


		// Create links to other JIRA issues, if any.
		if (isset($options['links']) && isset($options['linktype']))
		{
			$links = str::split($options['links'], ',');
			foreach ($links as $linked_id)
			{
				$data = array(
					'type' => array(
						'id' => $options['linktype']
					),
					'inwardIssue' => array(
						'key' => $issue_id
					),
					'outwardIssue' => array(
						'key' => str::trim($linked_id)
					)
				);

				$this->_send_command('POST', 'issueLink', $data);
			}
		}

		return $issue_id;
	}

	private function _add_attachment($url,$data=null)
	{
	$url = $url.'/attachments/';
	$Jirausername = $this->_user;
	$Jirapassword = $this->_secret;

	$ch=curl_init();
	$headers = array(
	    'X-Atlassian-Token: nocheck',
	    'Content-Type: multipart/form-data'
	);


	$cfile = curl_file_create($data);
	$data = array('file' => $cfile);


	curl_setopt_array(
	    $ch,
	    array(
		CURLOPT_URL=>$url,
		CURLOPT_POST=>true,
		CURLOPT_VERBOSE=>1,
		CURLOPT_POSTFIELDS=>$data,
		CURLOPT_INFILESIZE => 5,
		CURLOPT_SSL_VERIFYHOST=> 0,
		CURLOPT_SSL_VERIFYPEER=> 0,
		CURLOPT_RETURNTRANSFER=>true,
		CURLOPT_HEADER=>true,
		CURLOPT_HTTPHEADER=> $headers,
		CURLOPT_USERPWD=>"$Jirausername:$Jirapassword"
	    )
	);
	$result=curl_exec($ch);

	$ch_error = curl_error($ch);
	if ($ch_error) {
	    echo "cURL Error: $ch_error";
	}
	curl_close($ch);


	}

	private function _format_system_field($field_name, $field_value)
	{
		$data = array();
		$data['name'] = $field_name;

		switch ($field_name)
		{
			case 'parent':
				$data['value'] = array('key' => $field_value);
				break;

			case 'project':
				$data['value'] = array('key' => $field_value);
				break;

			case 'assignee':
				if ($this->jira_cloud) 
				{
					$data['value'] = array('accountId' => $field_value);
				} else 
				{
					$data['value'] = array('name' => $field_value);
				}
				break;

			case 'components':
			case 'affects_version':
			case 'fix_version':
				if ($field_name == 'fix_version')
				{
					$data['name'] = 'fixVersions';
				}
				elseif ($field_name == 'affects_version')
				{
					$data['name'] = 'versions';
				}
				else
				{
					$data['name'] = 'components';
				}

				if (is_array($field_value))
				{
					$tmp = array();
					foreach ($field_value as $value)
					{
						$tmp[]['id'] = $value;
					}
					$data['value'] = $tmp;
				}
				else
				{
					$data['value'] = array(array('id' =>
						$field_value));
				}
				break;

			case 'priority':
			case 'issuetype':
				$data['value'] = array('id' => $field_value);
				break;

			case 'estimate':
				$data['name'] = 'timetracking';
				$data['value'] = array('originalEstimate' =>
					$field_value);
				break;

			case 'labels':
				// Replace all whitespaces in a label as they are not
				// allowed and will return an error by Jira.
				$labels = preg_replace('/\s+/u', '', $field_value);
				$data['name'] = 'labels';
				$data['value'] = str::split($labels, ',');
				break;

			default:
				$data['value'] = $field_value;
				break;
		}

		return $data;
	}

	private function _format_custom_field($field_name, $field_value,
		$project_key, $issuetype)
	{
		$data = array();
		$data['name'] = $field_name;

		// Get the type of the custom field to decide which format to
		// use to submit the field to Jira.
		$field_type = $this->_get_customfield_type(
			$project_key,
			$issuetype,
			$field_name
		);

		switch ($field_type)
		{
			case 'com.atlassian.jira.plugin.system.customfieldtypes:textfield':
			case 'com.atlassian.jira.plugin.system.customfieldtypes:textarea':
				$data['value'] = $field_value;
				break;
				
			case 'com.atlassian.jira.plugin.system.customfieldtypes:float':
				// Make it work with commas, too.
				$field_value = str::replace($field_value, ',', '.');
				$data['value'] = (double) $field_value;
				break;

			case 'com.atlassian.jira.plugin.system.customfieldtypes:select':
			case 'com.atlassian.jira.plugin.system.customfieldtypes:radiobuttons':
			case 'com.atlassian.jira.plugin.system.customfieldtypes:version':
				// These field types do not support multiple items.
				// This needs to be handled in case the user sets the
				// field to a multiselect in TestRail.
				if (is_array($field_value))
				{
					$this->_throw_error(
						'Multi-select is not supported for the ' .
						'custom field "{0}".',
						$field_name
					);
				}
							
				$data['value'] = array('id' => $field_value);
				break;

			case 'com.atlassian.jira.plugin.system.customfieldtypes:multiselect':
			case 'com.atlassian.jira.plugin.system.customfieldtypes:multicheckboxes':
			case 'com.atlassian.jira.plugin.system.customfieldtypes:multiversion':
				// In case the field is configured as dropdown (not
				// multiselect), we need to handle the single value
				// case as well.
				if (!is_array($field_value))
				{
					$field_value = array($field_value);
				}

				$tmp = array();
				foreach ($field_value as $value) 
				{
					$tmp[]['id'] = $value;
				}

				$data['value'] = $tmp;
				break;

			case 'com.atlassian.jira.plugin.system.customfieldtypes:cascadingselect':
				// This field type does not support multiple items.
				// This needs to be handled in case the user sets the
				// field to a multiselect in TestRail.
				if (is_array($field_value))
				{
					$this->_throw_error(
						'Multi-select is not supported for the ' .
						'custom field "{0}".',
						$field_name
					);
				}

				// Split parent and child id e.g. 111002:111003
				$ids = str::split($field_value, ':');
				$parent = obj::create();
				$parent->id = $ids[0];
				if (isset($ids[1]))
				{
					$parent->child = obj::create();
					$parent->child->id = $ids[1];
				}
				$data['value'] = $parent;
				break;

			case 'com.atlassian.jira.plugin.system.customfieldtypes:userpicker':
			case 'com.atlassian.jira.plugin.system.customfieldtypes:grouppicker':
				// This field type does not support multiple items.
				// This needs to be handled in case the user sets the
				// field to a multiselect in TestRail.
				if (is_array($field_value))
				{
					$this->_throw_error(
						'Multi-select is not supported for the ' .
						'custom field "{0}".',
						$field_name
					);
				}

				$data['value'] = array('name' => $field_value);
				break;

			case 'com.atlassian.jira.plugin.system.customfieldtypes:multiuserpicker':
			case 'com.atlassian.jira.plugin.system.customfieldtypes:multigrouppicker':
				$result = array();

				// If $field_value is an array we got the result from a
				// multi-select field
				if (is_array($field_value))
				{
					foreach ($field_value as $user)
					{
						$u = obj::create();
						$u->name = (string) $user;
						$result[] = $u;
					}
					
				}
				else
				{
					// If $field_value is not an array we got it from
					// a field that cannot submit multiple values, e.g.
					// dropdown
					$u = obj::create();
					$u->name = (string) $field_value;
					$result[] = $u;
				}

				$data['value'] = $result;
				break;

			case 'com.atlassian.jira.plugin.system.customfieldtypes:labels':
				// Replace all whitespaces in a label as they are not
				// allowed and will return an error by Jira.
				$labels = preg_replace('/\s+/u', '', $field_value);
				$data['value'] = str::split($labels, ',');
				break;
		}

		return $data;
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
		
		throw new Jira_RESTException($message);
	}
}

class Jira_RESTException extends Exception
{
}
