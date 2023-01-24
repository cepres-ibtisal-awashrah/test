<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

/**
 * Bitbucket Cloud Defect Plugin for TestRail
 *
 * Copyright Gurock Software GmbH. All rights reserved.
 *
 * This is the TestRail defect plugin for Bitbucket. Please see
 * http://docs.gurock.com/testrail-integration/defects-plugins for
 * more information about TestRail's defect plugins.
 *
 * http://www.gurock.com/testrail/
 */

class Bitbucket_defect_plugin extends Defect_plugin
{
	private $_api;

	private $_address;
	private $_user;
	private $_password;
	private $_defaultFields = [
		'summary' => 'on',
		'kind' => 'on',
		'priority' => 'on',
		'status' => 'on',
		'description' => 'on'
	];

	private $_fieldDefaults = [
		'summary' => [
			'type' => 'string',
			'label' => 'Summary',
			'size' => 'full',
			'required' => true
		],
		'kind' => [
			'type' => 'dropdown',
			'label' => 'Kind',
			'required' => true,
			'remember' => true,
			'size' => 'compact'
		],
		'priority' => [
			'type' => 'dropdown',
			'label' => 'Priority',
			'required' => true,
			'remember' => true,
			'size' => 'compact'
		],
		'status' => [
			'type' => 'dropdown',
			'label' => 'State',
			'remember' => true,
			'size' => 'compact'
		],
		// The assignee is disabled as it requires owner permissions.
		// It only works if the configured user configured has owner
		// privileges for the repository. This feature is planned for
		// the future:
		// https://bitbucket.org/site/master/issue/7329/users-privilege-a-given-user-should-be
		/*
		'assignee' => array(
			'type' => 'dropdown',
			'label' => 'Assignee',
			'required' => false,
			'remember' => true,
			'size' => 'compact'
		),
		*/
		'description' => [
			'type' => 'text',
			'label' => 'Description',
			'required' => false,
			'rows' => 10
		],
		'version' => [
			'type' => 'dropdown',
			'label' => 'Version',
			'required' => false,
			'remember' => true,
			'size' => 'compact'
		],
		'component' => [
			'type' => 'dropdown',
			'label' => 'Component',
			'required' => false,
			'remember' => true,
			'size' => 'compact'
		],
		'milestone' => [
			'type' => 'dropdown',
			'label' => 'Milestone',
			'remember' => true,
			'required' => false,
			'size' => 'compact'
		],
		'attachments' => [
		    'type' => 'dropbox',
		    'label'=>'attachments',
		    'required' => false,
		    'size' => 'none'
		],
	];

	private static $_meta = [
		'author' => 'Gurock Software',
		'version' => '2.0',
		'description' => 'Bitbucket Cloud defect plugin for TestRail',
		'can_push' => true,
		'can_lookup' => true,
		'default_config' =>
			'; Please configure your Bitbucket connection below.
[connection]
address=https://api.bitbucket.org/
user=testrail
password=secret

[repository]
owner=<repository-owner>
name=<repository-name>

[push.fields]
kind=on
priority=on
status=on
description=on
component=off
milestone=off
version=off

[hover.fields]
summary=off
kind=on
priority=on
status=on
description=off
component=off
milestone=off
version=off
'];

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

	// *********************************************************
	// CONFIGURATION
	// *********************************************************

	public function validate_config($config)
	{
		$ini = ini::parse($config);

		$groups = [
			'connection' => [
				'address',
				'user',
				'password'
			],
			'repository' => [
				'owner',
				'name'
			]
		];

		foreach ($groups as $group => $keys)
		{
			if (!isset($ini[$group]))
			{
				throw new ValidationException(
					"Missing [$group] group"
				);
			}

			// Check required values for existance
			foreach ($keys as $key)
			{
				if (!isset($ini[$group][$key]) ||
					!$ini[$group][$key])
				{
					throw new ValidationException(
						"Missing configuration for key '$key'"
					);
				}
			}
		}

		$address = $ini['connection']['address'];

		// Check whether the address is a valid url (syntax only).
		if (!check::url($address))
		{
			throw new ValidationException(
				'Address is not a valid url'
			);
		}

		foreach ($ini['push.fields'] ?? [] as $field => $option) {
			if ($option === 'on') { 
				$this->_validate_field($ini, $field);
			}
		}
	}
	
	/**
	 * Validate field
	 * Validate default fields and if invalid 
	 * field found then throws error.
	 *
	 * @param array  $ini   API configuration.
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
            'text' => true,
            'string' => true,
            'multiselect' => true
        ];
        $category = arr::get($ini, "field.settings.$field");
        if (str::starts_with($field, 'customfield_') && !$category) {
            throw new ValidationException(
                str::format(
                    'Field "{0}" is enabled but configuration ' 
                        . 'section [field.settings.{0}] is missing ',
                    $field
                )
            );
        }
        if ($category) {
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
        if ($type && !isset($valid_types[str::to_lower($type)])) {
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
		$repository = $ini['repository'];
		$this->_address = str::slash($ini['connection']['address']);
		$this->_user = $ini['connection']['user'];
		$this->_password = $ini['connection']['password'];
		$this->_repo = $repository['owner'] . '/' .
		    $repository['name'];
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

		$this->_api = new Bitbucket_api(
			$this->_address,
			$this->_user,
			$this->_password,
			$this->_repo
		);

		return $this->_api;
	}

	// *********************************************************
	// PUSH
	// *********************************************************
	/**
	* Prepare Push
	* Creates an array of objects of default fields
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
		    : $this->_defaultFields;
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
					if ($property === 'label') {
						$field[$property] = $val;
						continue;
					}

					$value = str::to_lower($val);
					if (in_array($property, ['required', 'remember', 'cascading'])) {
						$final_value = $value === 'true';
					} elseif ($property === 'rows') {
						$final_value = (int) $value;
					} else {
						$final_value = $value;
					}

					$field[$property] = $final_value;
				}
			}
			$fields[$fieldName] = $field;
		}
		$result = ['fields' => $fields];
		$this->_form = $result;

		return $result;
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
		// Bitbucket installation.
		if ($field == 'summary' || $field == 'description')
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
			case 'status':
				$data['default'] = arr::get($prefs, 'status');
				$data['options'] = $this->_to_id_name_lookup(
					$api->get_status()
				);
				break;

			case 'kind':
				$data['default'] = arr::get($prefs, 'kind');
				$data['options'] = $this->_to_id_name_lookup(
					$api->get_kinds()
				);
				break;

			case 'priority':
				$data['default'] = arr::get($prefs, 'priority');
				$data['options'] = $this->_to_id_name_lookup(
					$api->get_priorities()
				);
				break;

			case 'assignee':
				$data['default'] = arr::get($prefs, 'assignee');
				$data['options'] = $this->_to_id_name_lookup(
					$api->get_assignees($this->_repo)
				);
				break;

			case 'milestone':
			case 'component':
			case 'version':
				$data['default'] = arr::get($prefs, $field);
				$data['options'] = $this->_to_id_name_lookup(
					$api->get_field_options($field)
				);
				break;
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
	* @param array        $paths   Array of uploaded user files on push form.
	* 
	* @return int
	*/
	public function push($context, $input, array $paths = []): int
	{
		$api = $this->_get_api();

		return $api->add_issue($input, $paths);
	}

	/**
	 * Return field value for all default and custom.
	 *
	 * @param object $issue Current issue details
	 * @param string $fieldName Configuration field names
	 *
	 * @return string
	*/
    private function _getAttributeLabel(object $issue, string $fieldName): string
    {
		switch ($fieldName) {
			case 'summary':
				return h($issue->title);

			case 'description':
				return h($issue->content->raw);

			case 'status':
				return h($issue->state);
				
			default:
				return $this->_getAttributeLabelByName($issue->$fieldName);
		}
    }
	
	/**
	 * Return field value for all default and custom which are array of objects
	 *
	 * @param object|string $issueDetails Configuration field names
	 *
	 * @return string
	*/
    private function _getAttributeLabelByName($issueDetails): string
    {
		if (isset($issueDetails->name)) {
			return h($issueDetails->name);
		} 

		if (isset($issueDetails->display_name)) {
			return h($issueDetails->display_name);
		}

		if (isset($issueDetails)) {
			return h($issueDetails);
		}

		return "&ndash;";
	}

	// *********************************************************
	// LOOKUP
	// *********************************************************
	/**
	 * Creates an array of objects of default and custom field with default and 
	 * user defined configuration to display on hover popup.
	 * 
	 * @param int $issueId Defect id of an issue.
	 * 
	 * @return array
	 * @throws Jira_RESTException
	 */
    public function lookup($issueId): array
    {
        $issue = $this->_get_api()->get_issue($issueId);
        $attributes = [];
        $fullAttributes = [];
        $description = null;
        $fieldsConfig = $this->_config['hover.fields'] ?? $this->_defaultFields;
        $status = $issue->state ?? '';
        $status_id = empty($issue->state) ? GI_DEFECTS_STATUS_OPEN : GI_DEFECTS_STATUS_RESOLVED;
        foreach ($fieldsConfig as $fieldName => $option) {
            if ($option !== 'on'|| in_array($fieldName, ['summary', 'attachments'])) {
                continue;
            }
            $field = arr::get($this->_config, "field.settings.$fieldName") 
                ?? $this->_fieldDefaults[$fieldName];
            if ($fieldName === 'description' && !empty($issue->content)) {
                $description = str::format(
                    '<div class="monospace">{0}</div>',
                    nl2br(
                        html::link_urls(
                            h($issue->content->raw)
                        )
                    )
                );
            } elseif ((!isset($field['size']) || $field['size'] === 'full' 
                && in_array($field['type'], ['text', 'string']))) {
                $multiLineTxt = $this->_getAttributeLabel($issue, $fieldName);
                if (isset($multiLineTxt)) {
                    $fullAttributes[$field['label']] = str::format(
                        '<div class="monospace">{0}</div>',
                        strip_tags(html_entity_decode($multiLineTxt))
                    );
                }
            } else {
                $attributes[$field['label']] = $this->_getAttributeLabel($issue, $fieldName);
            }
        }

        return [
            'id' => $issueId,
            'url' => str::format(a($issue->links->html->href)),
            'title' => $issue->title,
            'status_id' => $status_id,
            'status' => $status,
            'description' => $description,
            'attributes' => $attributes,
            'fullAttributes' => $fullAttributes
        ];
    }
}

/**
 * Bitbucket REST API
 *
 * Wrapper class for the Bitbucket REST API with functions for
 * retrieving repos, issues etc.
 */
class Bitbucket_api
{
	private $_address;
	private $_user;
	private $_password;
	private $_repo;
	private $_curl;
	private $_apiField = [
		'component' => 'components',
		'version' => 'versions',
		'milestone' => 'milestones',
	];

	/**
	 * Construct
	 *
	 * Initializes a new Bitbucket API object. Expects the full web
	 * address of the Bitbucket installation including http or https
	 * prefix.
	 */
	public function __construct($address, $user, $password, $repo)
	{
		$this->_address = str::slash($address);
		$this->_user = $user;
		$this->_password = $password;
		$this->_repo = $repo;
		$this->_check_issue_tracker();
	}

	private function _check_issue_tracker()
	{
		$response = $this->_send_command(
			'GET',
			str::format(
				"repositories/{0}",
				$this->_repo
			)
		);

		if (!$response)
		{
			return null;
		}

		if (!$response->has_issues)
		{
			$this->_throw_error(
				'The repository {0} was not configured with an issue ' .
				'tracker. You cannot push issues to this repository.',
				$this->_repo
			);
		}
	}

	/**
	 * Get Kinds
	 *
	 * Returns a list of kinds (issue types) for the configured repo.
	 * The kinds are returned as array of objects, each with its ID
	 * and name. Kinds are static in Bitbucket and cannot be configured
	 * nor be fetched via the API.
	 */
	public function get_kinds()
	{
		$kinds = array(
			'bug' => 'Bug',
			'enhancement' => 'Enhancement',
			'proposal' => 'Proposal',
			'task' => 'Task',
		);

		$result = array();
		foreach ($kinds as $id => $name)
		{
			$p = obj::create();
			$p->id = $id;
			$p->name = $name;
			$result[] = $p;
		}

		return $result;
	}

	/**
	 * Get Status
	 *
	 * Returns a list of statuses for the configured repo. The statuses
	 * are returned as array of objects, each with its ID and name.
	 * Statuses are static in Bitbucket and cannot be configured nor be
	 * fetched via the API.
	 */
	public function get_status()
	{
		$statuses = array(
			'new' => 'New',
			'open' => 'Open',
			'resolved' => 'Resolved',
			'on hold' => 'On Hold',
			'invalid' => 'Invalid',
			'duplicate' => 'Duplicate',
			'wontfix' => 'Won\'t Fix'
		);

		$result = array();
		foreach ($statuses as $id => $name)
		{
			$p = obj::create();
			$p->id = $id;
			$p->name = $name;
			$result[] = $p;
		}

		return $result;
	}

	/**
	 * Get Priorities
	 *
	 * Returns a list of priorities for the configured repo. The
	 * priorities are returned as array of objects, each with its ID
	 * and name. Priorities are static in Bitbucket and cannot be
	 * configured nor be fetched via the API.
	 */
	public function get_priorities()
	{
		$priorities = array(
			'trivial' => 'Trivial',
			'minor' => 'Minor',
			'major' => 'Major',
			'critical' => 'Critical',
			'blocker' => 'Blocker'
		);

		$result = array();
		foreach ($priorities as $id => $name)
		{
			$p = obj::create();
			$p->id = $id;
			$p->name = $name;
			$result[] = $p;
		}

		return $result;
	}

	/**
	 * Get Privileges
	 *
	 * Returns a list of users that have privileges to access the give
	 * repository. The users are returned as array of objects, each
	 * with its username and full name.
	 */
	private function _get_privileges($repo)
	{
		$response = $this->_send_command(
			'GET',
			str::format(
				"privileges/{0}",
				$repo
			)
		);

		if (!$response)
		{
			return array();
		}

		$result = array();
		foreach ($response as $user)
		{
			$a =  obj::create();
			$a->id = (string) $user->user->username;
			$a->name = (string) $user->user->first_name . 
				$user->user->last_name;
			$result[] = $a;
		}

		return $result;
	}

	/**
	 * Get Group Privileges
	 *
	 * Returns a list of users that have privileges to access the repo
	 * via a group. The users are returned as array of objects, each
	 * with its username and full name.
	 */
	private function _get_group_privileges($repo)
	{
		$response = $this->_send_command(
			'GET',
			str::format(
				"group-privileges/{0}",
				$repo
			)
		);

		if (!$response)
		{
			return array();
		}

		$result = array();
		foreach ($response as $group)
		{
			foreach ($group->group->members as $user)
			{
				$a =  obj::create();
				$a->id = (string) $user->username;
				$a->name = (string) $user->first_name . 
					$user->last_name;
				$result[] = $a;
			}
		}

		return $result;
	}

	/**
	 * Get Assignees
	 *
	 * Returns a list of assignees. The assignees are returned as array
	 * of objects, each with its username and full name.
	 */
	public function get_assignees($repo)
	{
		// Not yet implemented because the assignee is not supported
		// at this point.
		return array();
	}

	/**
	 * Get Field Options
	 * Returns a list of options for the given field of configured Bitbucket repository.
	 * Options are returned as array of objects, each with its ID and name.
	 * 
	 * @param string $fieldName field name.
	 * 
	 * @return array
	 */
	public function get_field_options(string $fieldName): array
	{
		$apiField= $this->_apiField[$fieldName];
		$response = $this->_send_command(
			'GET',
			"repositories/$this->_repo/$apiField"
		);
		$result = [];
		if (!empty($response->values)) {
			foreach ($response->values as $value) {
				$option = obj::create();
				$option->id = $option->name = $value->name;
				$result[] = $option;
			}
		}
		
		return $result;
	}
			
	/**
	 * Get Issue
	 *
	 * Gets an existing issue/ticket from the Bitbucket installation
	 * and returns it. The resulting object has various properties
	 * such as the summary, description, repo etc.
	 */
	public function get_issue($issue_id)
	{
		return $this->_send_command(
			'GET',
			"repositories/$this->_repo/issues/$issue_id"
		);
	}

	private function _send_command($method, $command, $data = null)
	{
		$url = $this->_address . '2.0/' . $command;
		return $this->_send_request($method, $url, $data);
	}

	private function _send_request($method, $url, $data = null)
	{
		if (!$this->_curl)
		{
			// Initialize the cURL handle. We re-use this handle to
			// make use of Keep-Alive, if possible.
			$this->_curl = http::open();
		}

		if (logger::is_on(GI_LOG_LEVEL_DEBUG))
		{
			logger::debug('Issuing Bitbucket HTTP request');
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
				'password' => $this->_password,
				'data' => json_encode($data),
				'headers' => array(
					'Content-Type' => 'application/json'
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

		if ($response->code != 200 && $response->code != 201)
		{
			$this->_throw_error(
				'Invalid HTTP code ({0}). Please check your user/' .
				'password and the [repository] configuration.',
				$response->code
			);
		}

		return $obj;
	}

	/**
	 * Add Issue
	 *
	 * Adds a new issue to the Bitbucket installation with the given
	 * parameters (summary, kinds etc.) and returns its identifier.
	 * The parameters must be named according to the Bitbucket API
	 * format,
	 * e.g.:
	 *
	 * summary:     The summary of the new issue
	 * kinds:       The kind the issue should be created with
	 * priority:    The priority the issue should be created with
	 * status:      The status the issue should be created with
	 * description: The description of the new issue
	 */
	public function add_issue(array $options, array $paths): int
	{
		$fields = [];
		foreach ($options as $field_name => $field_value) {
			if (!$field_value) {
				continue;
			}
			$field = $this->_format_field(
				$field_name,
				$field_value);
			if (isset($field['name']) && isset($field['value'])) {
				$fields[$field['name']] = $field['value'];
			}
		}
		$response = $this->_send_command(
			'POST',
			"repositories/$this->_repo/issues/",
			$fields
		);
		foreach ($paths ?? [] as $path) {
			$this->_add_attachment($path, $response->id);
		}

		return $response->id;
	}

	/**
	 * Format system field as per bitbucket API. 
	 * e.g summary field convert to title 
	 *
	 * @param string $fieldName  default field name
	 * @param string $fieldValue user select value in push popup
	 *
	 * @return array.
	 */
	private function _format_field(string $field_name, string $field_value): array
	{
		$data = [];
		$data['name'] = $field_name;
		switch ($field_name) {
			case 'summary':
				$data['name'] = 'title';
				$data['value'] = $field_value;
				break;
			case 'description':
				$data['name'] = 'content';
				$value = [];
				$value["raw"] = $field_value;
				$data['value'] = $value;
				break;
			case 'assignee':
				$data['name'] = 'responsible';
				$data['value'] = $field_value;
				break;
			case 'milestone':
			case 'component':
			case 'version':
				$data['value'] = [
				    'name' => $field_value
				];
				break;
			default:
				$data['name'] = $field_name;
				$data['value'] = $field_value;
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

		throw new BitbucketException($message);
	}

	/**
	 * Add Attachment
	 * Store attached file and return token and attachment id.
	 * 
	 * @param string $path User uploaded file path. 
	 * @param string $issueId Newly created Issue id. 
	 * 
	 * @return object
	 * 
	 * @throws BitbucketException
	 */
	private function _add_attachment(string $path, int $issueId)
	{
		$repositories = '2.0/repositories/';  
		$issues = '/issues/';  
		$attachments = '/attachments';
		if (!$this->_curl) {
			// Initialize the cURL handle. We re-use this handle to
			// make use of Keep-Alive, if possible.
			$this->_curl = http::open();
		}
		$cfile = curl_file_create($path);
		$cfile->postname = $this->_getAttachedFileName($cfile->name);
		$data = ['files' => $cfile];
		$response = http::request_ex(
			$this->_curl,
			'POST',
			sprintf(
				$this->_address . '%s' . $this->_repo . '%s' . $issueId . '%s',
				$repositories,
				$issues,
				$attachments
			),
			[
				'user' => $this->_user,
				'password' => $this->_password,
				'data' => $data,
				'headers' => [
					'Content-Type' => 'multipart/form-data'
				],
				'skip_url_encode' => true
			]
		);
		// In case debug logging is enabled, we append the data we've
		// sent and the entire request/response to the log.
		if (logger::is_on(GI_LOG_LEVEL_DEBUG)) {
			logger::debug('Got the following response');
			logger::debugr('$response', $response);
		}

		$obj = json::decode($response->content);

		if (!in_array($response->code, [200, 201])) {
			$this->_throw_error(
				'Invalid HTTP code ({0}). Please check your user/' .
				'password and the [repository] configuration.',
				$response->code
			);
		}
	}

	/**
	 * Fetch pure filename from filepath.
	 * 
	 * @param string $filename User uploaded file path. 
	 * 
	 * @return string
	 */
	private function _getAttachedFileName(string $filename): string
	{
		$str_pattern = ".";
		if (strpos($filename, $str_pattern) !== false) {
			$occurrence = strpos($filename, $str_pattern)+1;
			return substr($filename, $occurrence, strlen($filename));
		}

		return $filename;
	 }
}

class BitbucketException extends Exception
{
}
