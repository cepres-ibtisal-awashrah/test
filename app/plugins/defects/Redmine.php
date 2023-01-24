<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

/**
 * Redmine Defect Plugin for TestRail
 *
 * Copyright Gurock Software GmbH. All rights reserved.
 *
 * This is the TestRail defect plugin for Redmine. Please see
 * http://docs.gurock.com/testrail-integration/defects-plugins for
 * more information about TestRail's defect plugins.
 *
 * http://www.gurock.com/testrail/
 */

class Redmine_defect_plugin extends Defect_plugin
{
	private $_api;

	private $_address;
	private $_user;
	private $_password;

	private $_is_legacy = false;
	private $_trackers;
	private $_categories;
	private $_customFields = [];
	private $_defaultFields = [
		'subject'	=> 'on',
		'tracker'   => 'on',
		'project'   => 'on',
		'category'  => 'on',
		'description' => 'on',
		'attachments' => 'on',
	];
	private $_fieldDefaults = [
		'subject' => [
			'type' => 'string',
			'label' => 'Subject',
			'required' => true,
			'size' => 'full',
		],
		'tracker' => [
			'type' => 'dropdown',
			'label' => 'Tracker',
			'required' => true,
			'remember' => true,
			'size' => 'compact',
		],
		'project' => [
			'type' => 'dropdown',
			'label' => 'Project',
			'required' => true,
			'remember' => true,
			'cascading' => true,
			'size' => 'compact',
		],
		'category' => [
			'type' => 'dropdown',
			'label' => 'Category',
			'remember' => true,
			'depends_on' => 'project',
			'size' => 'compact',
		],
		'description' => [
			'type' => 'text',
			'label' => 'Description',
			'rows' => 10,
		],
		'attachments' => [
		    'type' => 'dropbox',
		    'label'=>'attachments',
		    'required' => false,
		    'size' => 'none'
		],
	];
	private $_hoverDefaultFields = [
		'subject' => 'on',
		'tracker' => 'on',
		'project' => 'on',
		'category' => 'on',
		'description' =>'on',
	];
	private static $_meta = [
		'author' => 'Gurock Software',
		'version' => '1.0',
		'description' => 'Redmine defect plugin for TestRail',
		'can_push' => true,
		'can_lookup' => true,
		'default_config' =>
			'; Please configure your Redmine connection below
; For Redmine versions older than 1.3, you need to
; activate the legacy mode of this plugin. Please
; contact the Gurock Software support in case you
; have any questions or refer to the documentation:
; http://on.gurock.com/redmine35
[connection]
address=http://<your-server>/
user=testrail
password=secret

[push.fields]
subject=on
tracker=on
project=on
category=on
description=on
attachments=on

[hover.fields]
subject=on
tracker=on
project=on
category=on
description=on
'];

	public function get_meta()
	{
		return self::$_meta;
	}

	// *********************************************************
	// CONFIGURATION
	// *********************************************************

	public function validate_config($config)
	{
		$ini = ini::parse($config);

		if (!isset($ini['connection']))
		{
			throw new ValidationException('Missing [connection] group');
		}

		$keys = array('address', 'user', 'password');

		// Check required values for existance
		foreach ($keys as $key)
		{
			if (!isset($ini['connection'][$key]) ||
				!$ini['connection'][$key])
			{
				throw new ValidationException(
					"Missing configuration for key '$key'"
				);
			}
		}

		$address = $ini['connection']['address'];

		// Check whether the address is a valid url (syntax only)
		if (!check::url($address))
		{
			throw new ValidationException('Address is not a valid url');
		}

		if (isset($ini['connection']['mode']))
		{
			// Mode must be set to 'legacy' when available.
			if ($ini['connection']['mode'] != 'legacy')
			{
				throw new ValidationException(
					'Mode given but not set to "legacy"'
				);
			}

			if (!isset($ini['trackers']))
			{
				throw new ValidationException(
					'Using legacy mode but [trackers] is missing'
				);
			}

			if (!isset($ini['categories']))
			{
				throw new ValidationException(
					'Using legacy mode but [categories] is missing'
				);
			}
		}
		$this->_ensure_valid_fields('push.fields', $ini);
		$this->_ensure_valid_fields('hover.fields', $ini);
	}

    /**
     * Ensure Valid fields
     * Validate all push and hover fields which are set '=on' 
     *
     * @param string $field_list Field name.
     * @param array  $ini        API configration.
     *
     * @return void
    */
    private function _ensure_valid_fields(string $field_list, array $ini) 
    {
        $fields = $ini[$field_list] ?? [];
        foreach ($fields as $field => $option) {
            if ($option === 'on') {
                $this->_validate_field($ini, $field);
            }
        }
        if ($field_list === 'push.fields' && !empty($fields)) {
            foreach (['tracker', 'project'] as $requiredField) {
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
	 * @param string $field field name.
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
			'string' => true
		];
		$category = arr::get($ini, "field.settings.$field");
		// Custom fields must always have a separate category.
		if (str::starts_with($field, 'customfield_')) {
			if (!$category) {
				throw new ValidationException(
					str::format(
						'Field "{0}" is enabled but configuration ' .
						'section [field.settings.{0}] is missing',
						$field
					 )
				);
			}
			$keys = ['label', 'type'];
			foreach ($keys as $key) {
				if (!isset($category[$key])) {
					throw new ValidationException(
						str::format(
							'Missing configuration for key "{0}" in ' . 
							'section [field.settings.{1}]',
							$key,
							$field
						)
					);
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
		$this->_config = $ini;

		if (isset($ini['connection']['mode']))
		{
			$this->_is_legacy = true;
			$this->_trackers = $ini['trackers'];
			$this->_categories = $this->_parse_categories(
				$ini['categories']);
		}
	}

	private function _parse_categories($ini)
	{
		$categories = [];

		// Uses the given ini section with keys 'project_id.item_id'
		// to create a category key => value mapping for the given
		// projects.
		foreach ($ini as $key => $value)
		{
			if (preg_match('/^([^\.]+)\.([^\.]+)$/', $key, $matches))
			{
				$project_id = (int) $matches[1];
				$item_id = (int) $matches[2];
				$categories[$project_id][$item_id] = $value;
			}
		}

		return $categories;
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

		$this->_api = new Redmine_api(
			$this->_address,
			$this->_user,
			$this->_password);

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
			? ['subject' => 'on'] + $this->_config['push.fields']
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
						$value = $value === 'true' ? true : false;
					} elseif ($property === 'rows') {
						$value = (int) $value;
					} else {
						// NOP
					}
					// This may override the default value from above.
					$field[$property] = $value;
				}
			}
			$fields[$fieldName] = $field;
		}
		$result = ['fields' => $fields];
		// Save the form for later use in prepare_field().
		$this->_form = $result;

		return $result;
	}

	private function _get_subject_default($context)
	{
		$test = current($context['tests']);
		$subject = 'Failed test: ' . $test->case->title;

		if ($context['test_count'] > 1)
		{
			$subject .= ' (+others)';
		}

		return $subject;
	}

	private function _get_description_default($context)
	{
		return $context['test_change']->description;
	}

	private function _to_id_name_lookup($items)
	{
		$result = [];
		foreach ($items as $item)
		{
			$result[$item->id] = $item->name;
		}
		return $result;
	}

	private function _get_trackers($api)
	{
		// In legacy mode for Redmine versions older than 1.3, we use
		// the user-configured values for the trackers. Otherwise,
		// we can just use the API.
		if ($this->_is_legacy)
		{
			if (is_array($this->_trackers))
			{
				return $this->_trackers;
			}
			else
			{
				return null;
			}
		}
		else
		{
			return $this->_to_id_name_lookup(
				$api->get_trackers()
			);
		}
	}

	private function _get_categories($api, $project_id)
	{
		// In legacy mode for Redmine versions older than 1.3, we use
		// the user-configured values for the categories. Otherwise,
		// we can just use the API.
		if ($this->_is_legacy)
		{
			$categories = arr::get($this->_categories, $project_id);

			if (!is_array($categories))
			{
				return null;
			}

			return $categories;
		}
		else
		{
			return $this->_to_id_name_lookup(
				$api->get_categories($project_id)
			);
		}
	}

	/**
	 * Get Default Customfield Values.
	 *
	 * @param object $api       Redmine API object.
	 * @param string $fieldName Defect field name.
	 *
	 * @return array|string
	 */ 
	private function _get_default_customfield_values(
		object $api, 
		string $fieldName
	) {
		$customField = $this->_get_customfield_values(
			$api,
			str::replace(
				$fieldName, 
				'customfield_', 
				''
			)
		);
		$returnedValue = [];
		if (isset($customField)) {
			$returnedValue = $customField->default_value;
			$fieldFormat = $customField->field_format; 
			if (in_array($fieldFormat, ['list', 'dropdown', 'bool', 'enumeration'])) {
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
	 * @param object $api Redmine API. 
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
	 * @param int 	 $id           Custom field ID
	 * @param array $customFields  Array of custom fields
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
		$data = [];

		// Process those fields that do not need a connection to the
		// Redmine installation.
		if ($field == 'subject' || $field == 'description')
		{
			switch ($field)
			{
				case 'subject':
					$data['default'] = $this->_get_subject_default(
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
			case 'tracker':
				$data['default'] = arr::get($prefs, 'tracker');
				$data['options'] = $this->_get_trackers($api);
				break;

			case 'project':
				$data['default'] = arr::get($prefs, 'project');
				$data['options'] = $this->_to_id_name_lookup(
					$api->get_projects()
				);
				break;

			case 'category':
				if (isset($input['project']))
				{
					$data['default'] = arr::get($prefs, 'category');
					$data['options'] = $this->_get_categories($api,
						$input['project']);
				}
				break;
		}
		if (str::starts_with($field, 'customfield_')) {
			$data['default'] = arr::get($prefs, $field);
			$data['options'] = $this->_get_default_customfield_values(
				$api,
				$field
			);
		}
		// Prevent an error message in case the field was a multi-
		// select and was changed back to dropdown. The preferences
		// would be an array in this case and the defects controller
		// may raise an error. We need to clear the default value
		// in this case.
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
	* @param array        $path    Array of uploaded user files on push form.
	* 
	* @return int
	*/
	public function push($context, $input, array $path = []): int
	{
		$api = $this->_get_api();

		return $api->add_issue($input, $path);
	}

	// *********************************************************
	// LOOKUP
	// *********************************************************
    /**
     * Creates an array of objects of default and custom field with default and 
     * user defined configuration to display on hover popup.
     * 
     * @param int $defectId Defect id of an issue. 
     *
     * @return array
     */
    public function lookup($defectId): array
    {
        $api = $this->_get_api();
        $issue = $api->get_issue($defectId);
        $status_id = GI_DEFECTS_STATUS_OPEN;
        $status = $description = null;
        if (isset($issue->status)) {
            $status = $issue->status->name;
            // Redmine's status API is only available in Redmine 1.3
            // or later, unfortunately, so we can only try to guess
            // by its name.
            switch (str::to_lower($status)) {
                case 'resolved':
                    $status_id = GI_DEFECTS_STATUS_RESOLVED;
                    break;
                case 'closed':
                    $status_id = GI_DEFECTS_STATUS_CLOSED;
                    break;
            }
        }
        $attributes = [];
        $fullAttributes = [];
        if ($status) {
            $attributes['Status'] = h($status);
        }
        $hoverFields = $this->_config['hover.fields'] ?? $this->_hoverDefaultFields;
        foreach ($hoverFields as $fieldName => $value) {
            if ($value !== 'on' || in_array($fieldName, ['subject', 'attachments'])) {
                continue;
            }
            if ($fieldName === 'description' && !empty($issue->description)) {
                $description = str::format(
                    '<div class="monospace">{0}</div>',
                    nl2br(
                        html::link_urls(
                            h($issue->description)
                        )
                    )
                );
            } elseif ($fieldName === 'project') {
                $attributes['Project'] = str::format(
                    '<a target="_blank" href="{0}projects/{1}">{2}</a>',
                    a($this->_address),
                    a($issue->project->id),
                    h($issue->project->name)
                );
            } elseif ($fieldName === 'category') {
                $attributes['Category'] = isset($issue->category->name) ? h($issue->category->name) : '-';
            } elseif ($fieldName === 'tracker') {
                $attributes['Tracker'] = isset($issue->tracker->name) ? h($issue->tracker->name) : '-';
            } elseif (str::starts_with($fieldName, 'customfield_')) {
                $configGroup = $this->_config["field.settings.$fieldName"];
                if (!isset($configGroup)) {
                    continue;
                }
                $customField = $this->_find_custom_field_by_id(
                    str::replace($fieldName, 'customfield_', ''),
                    $issue->custom_fields ?? []
                );
                $value = isset($customField) && is_array($customField->value)
                    ? join(', ', $customField->value)
                    : $customField->value;
                if (!isset($configGroup['size']) || ($configGroup['size'] === 'full'
                    && in_array($configGroup['type'], ['text', 'string']))
                    && isset($value)
                ) {
                    $fullAttributes[$configGroup['label']] = str::format(
                        '<div class="monospace">{0}</div>',
                        strip_tags(html_entity_decode($value))
                    );
                } else {
                    $attributes[$configGroup['label']] = $value;
                }
            }
        }
            
        return [
            'id' => $defectId,
            'url' => str::format(
                '{0}issues/{1}',
                $this->_address,
                $defectId
            ),
            'title' => $issue->subject,
            'status_id' => $status_id,
            'status' => $status,
            'description' => $description,
            'attributes' => $attributes,
            'fullAttributes' => $fullAttributes
        ];
    }
}

/**
 * Redmine API
 *
 * Wrapper class for the Redmine API with functions for retrieving
 * projects, bugs etc. from a Redmine installation.
 */
class Redmine_api
{
	private $_address;
	private $_user;
	private $_password;
	private $_version;
	private $_curl;

	/**
	 * Construct
	 *
	 * Initializes a new Redmine API object. Expects the web address
	 * of the Redmine installation including http or https prefix.
	 */
	public function __construct($address, $user, $password)
	{
		$this->_address = str::slash($address);
		$this->_user = $user;
		$this->_password = $password;
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

		throw new RedmineException($message);
	}

	/**
	 * Send Command
	 * create API url and add limit and offect as parameters.
	 *
	 * @param string $method  API method
	 * @param string $command relative path of API
	 * @param array  $data    API request body.
	 * @param int    $offect  retrieve a subset of records starting with the offset value
	 *
	 * @return object|array
	 */ 
	private function _send_command($method, $command, $data = [], $offset = null)
	{
		$url = $this->_address . $command . '.json';

		if ($method == 'GET')
		{
			$url .= '?limit=100';
			if ($offset)
			{
				$url .= '&offset=' . $offset;
			}
		}

		return $this->_send_request($method, $url, $data);
	}
	/**
	 * Send Request
	 * Send request to Redmine server and return response.
	 * 
	 * @param string       $method      HTTP methods for RESTful APIs.
	 * @param string       $url         Redmine API url.
	 * @param array|string $data        Body of API request.
	 * @param string       $contentType Content type of API.
	 * 
	 * @return array|object
	 * 
	 * @throws RedmineException.
	 */
	private function _send_request(
		string $method, 
		string $url, 
		$data, 
		string $contentType = 'application/json'
	) {
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
				'user' => $this->_user,
				'password' => $this->_password,
				'headers' => array(
					'Content-Type' => $contentType
				)
			)
		);

		// In case debug logging is enabled, we append the data
		// we've sent and the entire request/response to the log.
		if (logger::is_on(GI_LOG_LEVEL_DEBUG))
		{
			logger::debugr('$data', $data);
			logger::debugr('$response', $response);
		}
		$obj = json::decode($response->content);
		if (!in_array($response->code, [200, 201, 204])) {
			if (in_array($response->code, [401, 403])) {
				$this->_throw_error(
					'Invalid HTTP code ({0}). Please check your user/' .
					'password and that the API is enabled in Redmine.',
					$response->code
				);
			} else {
				$errors = '';
				foreach ($obj->errors ?? [] as $error) {
					$errors .= "$error.\n";
				}
				$this->_throw_error($errors);   
			}       
		}

		return $obj;
	}

	/**
	 * Get Issue
	 *
	 * Gets an existing issue from the Redmine installation and
	 * returns it. The resulting issue object has various properties
	 * such as the subject, description, project etc.
	 */
	public function get_issue($issue_id)
	{
		$response = $this->_send_command(
			'GET', 'issues/' . urlencode($issue_id)
		);

		return $response->issue;
	}

	/**
	 * Get Trackers
	 *
	 * Gets the available trackers for the Redmine installation.
	 * Trackers are returned as array of objects, each with its ID
	 * and name. Requires Redmine >= 1.3.
	 */
	public function get_trackers()
	{
		$response = $this->_send_command('GET', 'trackers');
		return $response->trackers;
	}

	/**
	 * Get Projects
	 *
	 * Gets the available projects for the Redmine installation.
	 * Projects are returned as array of objects, each with its ID
	 * and name.
	 */
	public function get_projects()
	{
		$response = $this->_send_command('GET', 'projects');

		$projects_array = $response->projects;

		if (property_exists($response, 'limit')) {
			$limit = $response->limit;

			$total_retrieved = $limit;

			while ($response->total_count > $total_retrieved) {
				$response = $this->_send_command('GET', 'projects', [], $total_retrieved);
				$total_retrieved += $limit;
				$projects_array = array_merge($projects_array, $response->projects);
			}
		}

		return $projects_array;
	}

	/**
	 * Get Categories
	 *
	 * Gets the available categories for the given project ID for the
	 * Redmine installation. Categories are returned as array of
	 * objects, each with its ID and name. Requires Redmine >= 1.3.
	 */
	public function get_categories($project_id)
	{
		$response = $this->_send_command('GET', "projects/$project_id/issue_categories");
		return $response->issue_categories;
	}

	/**
	 * Get Customfield Values
	 *
	 * @return array.
	 */
	public function get_customfields(): array
	{
		return $this->_send_command('GET', 'custom_fields')->custom_fields;
	}

	/**
	* Add Issue
	* Adds a new issue to the Redmine installation with the given
	* parameters (subject, project etc.) and returns its ID.
	*
	* @param array $options Default configuration.
	* @param array $paths   Array of user uploaded files on push form.
	* 
	* @return int
	*/
	public function add_issue(array $options, array $paths): int
	{
		$fields = $customFields = $uploads = [];
		foreach ($paths ?? [] as $path) {
			$upload = $this->_add_attachment($path);
			if (isset($upload->upload)) {
				$uploads[] = $upload->upload;
			}
		}
		foreach ($options as $fieldName => $fieldValue) {
			if (empty($fieldValue)) {
				continue;
			}
			if (str::starts_with($fieldName, 'customfield_')) {
				$field = $this->_format_custom_field(
					$fieldName,
					$fieldValue
				);
				if (isset($field['id']) && isset($field['value'])) {
					$customFields[] =  $field;
				}
			} else {
				$field = $this->_format_system_field(
					$fieldName,
					$fieldValue);
				if (isset($field['name']) && isset($field['value'])) {
					$fields[$field['name']] = $field['value'];
				}
			}
		}
		if (!empty($customFields)) {
			$fields["custom_fields"] = $customFields;
		}
		if (!empty($uploads)) {
			$fields['uploads'] = $uploads;
		}
		$data = json::encode(['issue' => $fields]);
		$response = $this->_send_command('POST', 'issues', $data);

		return $response->issue->id;
	}
    /**
     * Add Attachment
     * Store attachment and return token and attacment id.
     * 
     * @param string $path User uploaded file path. 
     * 
     * @return object
     */
    private function _add_attachment(string $path): object
    {
        $params = [
            'filename' => basename($path)
        ];
        $data = file_get_contents($path);
        $url = $this->_address . 'uploads.json?' . http_build_query($params);

        return $this->_send_request(
            'POST', 
            $url, 
            $data, 
            'application/octet-stream'
        );
    }

	/**
	 * Format system field as per redmine API. 
	 * e.g project field convert to project_id 
	 *
	 * @param string       $fieldName  default field name
	 * @param string|array $fieldValue user select value in push popup
	 *
	 * @return array.
	 */
	private function _format_system_field(string $fieldName, $fieldValue): array
	{
		$data['name'] = $fieldName;
		switch ($fieldName) {
			case 'description':
			case 'subject':
				$data['value'] = $fieldValue;
				break;
			case 'tracker':
				$data['name'] = 'tracker_id';
				$data['value'] = $fieldValue;
				break;
			case 'project':
				$data['name'] = 'project_id';
				$data['value'] = $fieldValue;
				break;
			case 'category':
				$data['name'] = 'category_id';
				$data['value'] = $fieldValue;
				break;
		}

		return $data;
	}

	/**
	 * Format custom field as per redmine API. 
	 * key is ID of custom field and values is value 
	 * which user select in push popup.
	 *
	 * @param string       $fieldName  user defined field name
	 * @param string|array $fieldValue user select value in push popup
	 *
	 * @return array.  
	 */
	private function _format_custom_field(string $fieldName, $fieldValue): array
	{
		return [
			'id' => str::replace($fieldName, 'customfield_', ''),
			'value' => $fieldValue
		];
	}
}

class RedmineException extends Exception
{
}
