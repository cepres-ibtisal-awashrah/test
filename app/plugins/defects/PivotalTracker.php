<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

/**
 * Pivotal Tracker Defect Plugin for TestRail
 *
 * Copyright Gurock Software GmbH. All rights reserved.
 *
 * This is the TestRail defect plugin for Pivotal Tracker. Please see
 * http://docs.gurock.com/testrail-integration/defects-plugins for
 * more information about TestRail's defect plugins.
 *
 * http://www.gurock.com/testrail/
 */

define('GI_DEFECTS_PIVOTAL_API', 'services/v5/');
define('GI_DEFECTS_PIVOTAL_STORYPOINTS_FMT',
	'{0} {0?{points}:{point}}');
define('GI_DEFECTS_PIVOTAL_STORYPOINTS_UNESTIMATED', 'Unestimated');
define('GI_DEFECTS_PIVOTAL_STORY_TYPE_FEATURE', 'feature');

class PivotalTracker_defect_plugin extends Defect_plugin
{
	// *********************************************************
	// DEFINITIONS
	// *********************************************************

	const DASH = '&ndash;';

	private $_story_types = array(
		'feature' => 'Feature',
		'bug' => 'Bug',
		'chore' => 'Chore',
		'release' => 'Release'
	);

	private $_states = array(
		'finished' => 'resolved',
		'delivered' => 'resolved',
		'accepted' => 'closed'
	);

	private $_api;
	private $_user;
	private $_password;
	private $_address;
	private $_defaultFields = [
		'title'	=> 'on',
		'type' => 'on',
		'project' => 'on',
		'estimate' => 'on',
		'labels' => 'on',
		'description' => 'on',
		'attachments' => 'on',
	];
	private $_fieldDefaults = [
		'title' => [
			'type' => 'string',
			'label' => 'Name',
			'required' => true,
			'size' => 'full'
		],
		'type' => [
			'type' => 'dropdown',
			'label' => 'Type',
			'required' => true,
			'remember' => true,
			'size' => 'compact',
			'cascading' => true
		],
		'project' => [
			'type' => 'dropdown',
			'label' => 'Project',
			'required' => true,
			'remember' => true,
			'size' => 'compact',
			'cascading' => true
		],
		'estimate' => [
			'type' => 'dropdown',
			'label' => 'Estimate',
			'depends_on' => 'project|type',
			'size' => 'compact'
		],
		'labels' => [
			'type' => 'string',
			'label' => 'Labels',
			'size' => 'full',
			'description' => 'A comma separated list of labels.'
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
		'title' => 'on',
		'type' => 'on',
		'project' => 'on',
		'estimate' => 'on',
		'labels' => 'on',
		'description' =>'on',
	];
	private static $_meta = array(
		'author' => 'Gurock Software',
		'version' => '1.0',
		'description' => 'Pivotal Tracker defect plugin for TestRail',
		'can_push' => true,
		'can_lookup' => true,
		'default_config' => 
			'; Please configure your Pivotal Tracker connection
[connection]
address=https://www.pivotaltracker.com/
user=testrail
password=secret
token=<pivotal-tracker-token>

[push.fields]
title=on
type=on
project=on
estimate=on
labels=on
description=on
attachments=on

[hover.fields]
title=on
type=on
project=on
estimate=on
labels=on
description=on'
	);
		
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
		
		// Check required values for existence
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
			foreach (['project', 'type'] as $requiredField) {
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
		$this->_token = $ini['connection']['token'];
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
		
		$this->_api = new PivotalTracker_api($this->_address, 
			$this->_user, $this->_password);
		$this->_api->login($this->_user, $this->_password);
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
			? ['title' => 'on'] + $this->_config['push.fields']
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
			$fields[$fieldName] = $field;
		}
		$result = ['fields' => $fields];
		// Save the form for later use in prepare_field().
		$this->_form = $result;
	
		return $result;
	}

	private function _get_title_default($context)
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

	public function prepare_field($context, $input, $field)
	{
		$data = array();

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
		
		// Process those fields that do not need a connection to the
		// Pivotal Tracker installation.		
		if ($field == 'title' || $field == 'description' ||
			$field == 'type')
		{
			switch ($field)
			{
				case 'title':
					$data['default'] = $this->_get_title_default(
						$context);
					break;
					
				case 'description':
					$data['default'] = $this->_get_description_default(
						$context);
					break;

				case 'type':
					$data['default'] = arr::get($prefs, 'type');
					$data['options'] = $this->_story_types;
					break;
			}
		
			return $data;
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
					$this->_api->get_projects()
				);				
				break;

			case 'estimate':
				$type = arr::get($input, 'type');

				if ($type == GI_DEFECTS_PIVOTAL_STORY_TYPE_FEATURE)
				{
					$project = null;

					if (isset($input['project']))
					{
						$project = $this->_api->get_project(
							$input['project']
						);					
					}

					if (isset($project->point_scale))
					{
						$data['default'] = arr::get($prefs, 'estimate', -1);
						$data['options'] = $this->_get_estimate_scale(
							$project->point_scale);
					}
				}
				else
				{
					$data['disabled'] = true;
				}

				break;
		}
		
		return $data;
	}

	private function _get_estimate_scale($point_scale)
	{
		$result = array(
			-1 => GI_DEFECTS_PIVOTAL_STORYPOINTS_UNESTIMATED
		);

		$points = str::split($point_scale, ',');
		foreach ($points as $p)
		{
			$result[(int)$p] = str::format(
				GI_DEFECTS_PIVOTAL_STORYPOINTS_FMT,
				$p
			);
		}

		return $result;
	}

	public function validate_push($context, $input)
	{
	}

	public function push($context, $input, array $paths = []): int
	{
		$api = $this->_get_api();		
		return $api->add_story($input, $paths);
	}

	// *********************************************************
	// LOOKUP
	// *********************************************************
	/**
	* Creates an array of objects of default field with default and 
	* user defined configuration to display on hover popup.
	* 
	* @param int $story_id Story id of an issue. 
	*
	* @return array
	*/
	public function lookup($story_id)
	{
		$api = $this->_get_api();
		$story = $api->get_story($story_id);
		$status_id = GI_DEFECTS_STATUS_OPEN;
		$status = $description = null;
		if (isset($story->current_state)) {
			$status = $story->current_state;
			if ($status) {
				$status_type = arr::get($this->_states, $status);
				$status_id = $status_type && $status_type == 'resolved'
					? GI_DEFECTS_STATUS_RESOLVED
					: GI_DEFECTS_STATUS_CLOSED;
			}
		}	
		$attributes = [];
		$fullAttributes = [];
		if ($status) {
			$attributes['Status'] = h(ucfirst($status));
		}
		$hoverFields = $this->_config['hover.fields'] ?? $this->_hoverDefaultFields;
		foreach ($hoverFields as $fieldName => $value) {
		    if ($value !== 'on' || in_array($fieldName, ['title', 'attachments'])) {
		        continue;
		    }
		    $field = arr::get($this->_config, "field.settings.$fieldName") ?? $this->_fieldDefaults[$fieldName];
		    if ($fieldName === 'labels') {
		        $labels = str::join(str::split($story->labels, ','),', ');
		        $value = isset($labels) ? h($labels) : static::DASH;
		    } elseif ($fieldName === 'project') {
		        $project = $api->get_project($story->project_id);
		        $value = str::format(
		            '<a target="_blank" href="{0}projects/{1}">{2}</a>',
		            $this->_address,
		            a($story->project_id),
		            h($project->name)
		        );
		    } elseif ($fieldName === 'type') {
		        $story_type = arr::get($this->_story_types, $story->story_type);
		        $value = isset($story_type) ? h(ucfirst($story->story_type)) : static::DASH;
		    } elseif ($fieldName === 'estimate') {
		        $value = isset($story->estimate) && $story->estimate !== -1
		            ? str::format(GI_DEFECTS_PIVOTAL_STORYPOINTS_FMT,$story->estimate)
		            : GI_DEFECTS_PIVOTAL_STORYPOINTS_UNESTIMATED;
		    }
		    $finalValue = empty($value) ? static::DASH : $value;
		    if ($fieldName === 'description') {
		        $description = empty($story->description)
		            ? null
		            : str::format(
		                '<div class="monospace">{0}</div>',
		                nl2br(html::link_urls(h($story->description)))
		            );
		    } elseif (in_array($field['type'], ['text', 'string']) && (!isset($field['size']) || $field['size'] === 'full')) {
		        $fullAttributes[$field['label']] = str::format(
		            '<div class="monospace">{0}</div>',
		            strip_tags(html_entity_decode($finalValue))
		        );                   
		    } else {
		        $attributes[$field['label']] = $finalValue; 
		    }
		}
		
		return [
			'id' => $story_id,
			'url' => str::format(
				'{0}story/show/{1}',
				$this->_address,
				$story_id
			),
			'title' => $story->name,
			'status_id' => $status_id,
			'status' => $status,
			'description' => $description,
			'attributes' => $attributes,
			'fullAttributes' => $fullAttributes
		];
	}
}

/**
 * PivotalTracker API
 *
 * Wrapper class for the Pivotal Tracker Rest API for retrieving
 * stories etc. from a Pivotal Tracker installation. Uses the REST
 * API of Pivotal Tracker.
 */
class PivotalTracker_api
{
	private $_address;
	private $_token;
	private $_curl;
	private $_user;
	private $_password;

	/**
	 * Construct
	 *
	 * Initializes a new Pivotal Tracker API object. Expects the user
	 * and password to log on to the Pivotal Tracker installation.
	 */
	public function __construct($address, $user, $password)
	{
		$this->_address = str::slash($address);
		$this->_user = $user;
		$this->_password = $password;
		
	}

	/**
	 * Login
	 *
	 * Logs in to the Pivotal Tracker with user and password to
	 * retrieve a user token for subsequent calls.
	 */ 
	public function login($user, $password)
	{
		$auth['user'] = $user;
		$auth['password'] = $password;

		$response = $this->_send_command('GET', 'me', null, $auth);
            
                if (!isset($response->api_token))
		{
			$this->_throw_error(
				'Unable to retrieve user token. Please check your
				Pivotal Tracker user and password.'
			);
		}

		$this->_token = $response->api_token;

	}

	private function _send_command($method, $uri, $data = null,
		$auth = null)
	{
		if ($data)
		{
			$options['data'] = $data;
			$options['headers'] = array(
				'Content-type' => 'application/json'
			);
		}

		if ($this->_token)
		{
			$options['headers']['X-TrackerToken'] = $this->_token;
		}
		else
		{
			// In this case, we have to send the credentials to
			// retrieve the access token.
			$options['user'] = $auth['user'];
			$options['password'] = $auth['password'];
		}

		$url = str::format(
			'{0}{1}{2}',
			$this->_address,
			GI_DEFECTS_PIVOTAL_API,
			$uri
		);

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
			$options
		);

		// In case debug logging is enabled, we append the url we
		// tried to access and the response to the log.
		if (logger::is_on(GI_LOG_LEVEL_DEBUG))
		{
			logger::debugr(
				'$rest',
				array(
					'url' => $url,
					'options' => $options,
					'response' => $response
				)
			);
		}
                
		// Error 401 (Unauthorized) has to be handled seperately
		// because it does not deliver an error message in XML format.
		if ($response->code == 401)
		{
			$this->_throw_error(
				'Access denied. Please check your Pivotal Tracker user
				and password.'
			);
		}
  
                $content = json_decode($response->content);

		if ($response->code != 200)
		{
			if (isset($content->error))
			{
				$error = $content->error;
			}
			else
			{
				$error = (string) $content;
			}

			$this->_throw_error(
				'Invalid HTTP code ({0}). {1}',
				$response->code,
				$error
			);
		}

		return $content;
	}

	/**
	 * Get Story
	 *
	 * Gets an existing story from the Pivotal Tracker installation
	 * and returns it. The resulting story object has various 
	 * properties such as the id, the name etc. 
	 */
	public function get_story($story_id)
	{
		$response = $this->_send_command('GET', "stories/$story_id");

                // V5 Api seems to have completely changed labels
                $label_string = "";
                $label_separator = "";
                foreach($response->labels as $label) {
                  $label_string = $label_string . $label_separator . $label->name ;
                  $label_separator = ",";
                }
                $response->labels = $label_string;

		return $response;
	}

	/**
	 * Add Story
	 * Adds a new story to the Pivotal Tracker installation with
	 * the given parameters and returns its ID.
	 * @param array $input Array of push fields
	 *
	 * @return int 
	 */
	public function add_story(array $input, array $paths): int 
	{
		$fields = [];
		foreach ($input as $fieldName => $fieldValue) {
			if (empty($fieldValue)) {
				continue;
			} else {
				$field = $this->_format_system_field($fieldName, $fieldValue);
				if (isset($field['name']) && isset($field['value'])) {
					$fields[$field['name']] = $field['value'];
				}
			}
		}
		$data = json_encode($fields);
		$project = $input["project"]; 
		$response = $this->_send_command(
			'POST',
			str::format(
				'projects/{0}/stories',
				$project
			),
			$data
		);
		$uploads = array_map(
			function ($path) use ($project) {
				return json_decode(
					$this->_add_attachment($path, $project),
					true
				);
			},
			$paths
		);
		if ($uploads) {
			$this->_add_attachment_comment($project, (int)$response->id, $uploads);
		}
		
		return (int)$response->id; 
	}

	/**
	 * Add Attachment
	 * Store attachment and return attachment files.
	 * 
	 * @param string $path      User uploaded file path.
	 * @param int    $projectId Project id. 
	 * 
	 * @return object
	 */
	private function _add_attachment(string $path, int $projectId)
	{
		if (!$this->_curl) {
			$this->_curl = http::open();
		} 
		$response = http::request_ex(
			$this->_curl,
			'POST',
			sprintf(
				$this->_address . '%s' . $projectId . '%s',
				GI_DEFECTS_PIVOTAL_API . 'projects/',
				'/uploads'
			),
			[
				'headers' => [
					'X-TrackerToken'=> $this->_token,
					'Content-Type'=> 'multipart/form-data'
				],
				'user' => $this->_user,
				'password' => $this->_password,
				'data' => ['file' => curl_file_create($path)],
				'skip_url_encode' => true
			]
		);
		
		return $response->content;
	}

	/**
	 * Add Attachment Comment
	 * Store attachment in comments and return attachment files.
	 *
	 * @param int   $projectId Project ID.
	 * @param int 	$storyId   Story ID.
	 * @param array $data      Pass attachments data to add attachment to comment.
	 *
	 * @return object
	 */
	private function _add_attachment_comment(int $projectId, int $storyId, array $data)
	{
		if (!$this->_curl) {
			$this->_curl = http::open();
		} 
		
		return http::request_ex(
			$this->_curl,
			'POST',
			sprintf(
				$this->_address . '%s' . $projectId . '%s' . $storyId . '%s',
				GI_DEFECTS_PIVOTAL_API . 'projects/',
				'/stories/',
				'/comments?fields=:default,file_attachment_ids'
			),
			[
				'headers' => [
					'X-TrackerToken'=> $this->_token,
					'Content-Type'=> 'application/json'
				],
				'user' => $this->_user,
				'password' => $this->_password,
				'data' => json_encode([
					'file_attachments' => $data, 
					'text' => ''
				]),
			]
		);
	}

	/**
	 * Format system field as per Pivotal Tracker API. 
	 * e.g project field convert to story_type 
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
				$data['value'] = $fieldValue;
				break;
			case 'labels':
			$data['name'] = 'labels';
				$data['value'] = explode(',',$fieldValue);
				break;
			case 'title':
				$data['name'] = 'name';
				$data['value'] = $fieldValue;
				break;
			case 'type':
				$data['name'] = 'story_type';
				$data['value'] = $fieldValue;
				break;
			case 'estimate':
				$data['name'] = 'estimate';
				$data['value'] = $fieldValue == -1 ? null : (int) $fieldValue;
				break;
		}

		return $data;
	}
	/**
	 * Get Project
	 *
	 * Gets an existing project from the Pivotal Tracker installation
	 * and returns it. The resulting project object has various 
	 * properties such as the id, the name etc. 
	 */
	public function get_project($project_id)
	{
		$response = $this->_send_command('GET', "projects/$project_id");

		$p = obj::create();
		$p->id = (int)$response->id;
		$p->name = (string)$response->name;
		$p->point_scale = (string)$response->point_scale;

		return $p;
	}

	/**
	 * Get Projects
	 *
	 * Gets a list of all projects accessible from the user whose
	 * credentials were given to the constructor.
	 */
	public function get_projects()
	{
		$response = $this->_send_command('GET', 'projects');
		$result = array();

		foreach ($response as $project)
		{
			$p = obj::create();
			$p->id = (int)$project->id;
			$p->name = (string)$project->name;
			$p->point_scale = (string)$project->point_scale;
			$result[] = $p;
		}

		return $result;
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
		
		throw new PivotalTrackerException($message);
	}
}

class PivotalTrackerException extends Exception
{
}