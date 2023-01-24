<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

/**
 * YouTrack Defect Plugin for TestRail
 *
 * Copyright Gurock Software GmbH. All rights reserved.
 *
 * This is the TestRail defect plugin for JetBrains YouTrack. Please
 * see http://docs.gurock.com/testrail-integration/defects-plugins
 * for more information about TestRail's defect plugins.
 *
 * http://www.gurock.com/testrail/
 */

require_once APPPATH . 'plugins/defects/exceptions/YouTrackException.php';

class YouTrack20184_defect_plugin extends Defect_plugin
{
	private $_api;

	private $_address;
	private $_user;
	private $_password;

	private static $_meta = array(
		'author' => 'Gurock Software',
		'version' => '1.0',
		'description' => 'YouTrack20184 defect plugin for TestRail',
		'can_push' => true,
		'can_lookup' => true,
		'default_config' =>
			'; Please configure your YouTrack connection below
[connection]
address=http://<your-server>/
user=testrail
password=secret'
	);

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
				$api->logout();
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
	}

	public function configure($config)
	{
		$ini = ini::parse($config);
		$this->_address = str::slash($ini['connection']['address']);
		$this->_user = $ini['connection']['user'];
		$this->_password = $ini['connection']['password'];
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

		$this->_api = new YouTrack20184_api($this->_address);
		$this->_api->login($this->_user, $this->_password);
		return $this->_api;
	}

	// *********************************************************
	// PUSH
	// *********************************************************

	public function prepare_push($context)
	{
		// Return a form with the following fields/properties
		return array(
			'fields' => array(
				'summary' => array(
					'type' => 'string',
					'label' => 'Summary',
					'required' => true,
					'size' => 'full'
				),
				'type' => array(
					'type' => 'dropdown',
					'label' => 'Type',
					'required' => true,
					'remember' => true,
					'size' => 'compact'
				),
				'project' => array(
					'type' => 'dropdown',
					'label' => 'Project',
					'required' => true,
					'remember' => true,
					'cascading' => true,
					'size' => 'compact'
				),
				'subsystem' => array(
					'type' => 'dropdown',
					'label' => 'Subsystem',
					'required' => false,
					'remember' => true,
					'depends_on' => 'project',
					'size' => 'compact'
				),
				'description' => array(
					'type' => 'text',
					'label' => 'Description',
					'rows' => 10
				)
			)
		);
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
		// YouTrack installation.
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
			case 'type':
				$data['options'] = $this->_to_id_name_lookup(
					$api->get_types()
				);

				// Select the stored preference or the first item in
				// the list otherwise.
				$default = arr::get($prefs, 'type');
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

			case 'subsystem':
				if (isset($input['project']))
				{
					$data['default'] = arr::get($prefs, 'subsystem');
					$data['options'] = $this->_to_id_name_lookup(
						$api->get_subsystems($input['project'])
					);
				}
				break;
		}

		return $data;
	}

	public function validate_push($context, $input)
	{
	}

	public function push($context, $input)
	{
		$api = $this->_get_api();
		return $api->add_issue($input);
	}

	// *********************************************************
	// LOOKUP
	// *********************************************************

	public function lookup($defect_id)
	{
		$api = $this->_get_api();
		$issue = $api->get_issue($defect_id);

		$attributes = array();

		// Add some important attributes for the issue such as the
		// issue type, current status and project. Note that the
		// attribute values (and description) support HTML and we
		// thus need to escape possible HTML characters (with 'h')
		// in this plugin.

		if (isset($issue['type']))
		{
			$attributes['Type'] = h($issue['type']);
		}

		$status = '';
		if (isset($issue['state']))
		{
			$attributes['Status'] = h($issue['state']);
			$status = $issue['state'];
		}

		if (isset($issue['project']))
		{
			// Add a link to the project.
			$attributes['Project'] = str::format(
				'<a target="_blank" href="{0}issues?q=project%3A+{1}">{2}</a>',
				a($this->_address),
				a($issue['project']),
				h($issue['project'])
			);
		}

		// Decide which status to return to TestRail based on the
		// resolved property of the issue's state.
		$status_id = GI_DEFECTS_STATUS_OPEN;

		if ($status)
		{
			$state = arr::get(
				obj::get_lookup(
					$api->get_states()
				),
				$status
			);

			if ($state)
			{
				if ($state->resolved)
				{
					$status_id = GI_DEFECTS_STATUS_RESOLVED;
				}
			}
		}

		// Format the description of the issue (we use a monospace
		// font).
		if (isset($issue['description']) && $issue['description'])
		{
			$description = str::format(
				'<div class="monospace">{0}</div>',
				nl2br(
					html::link_urls(
						h($issue['description'])
					)
				)
			);
		}
		else
		{
			$description = null;
		}

		return array(
			'id' => $defect_id,
			'url' => str::format(
				'{0}issue/{1}',
				$this->_address,
				$defect_id
			),
			'title' => $issue['summary'],
			'status_id' => $status_id,
			'status' => $status,
			'description' => $description,
			'attributes' => $attributes
		);
	}
}

/**
 * YouTrack API
 *
 * Wrapper class for the YouTrack API with login/logout and functions
 * for retrieving projects etc. from a YouTrack installation.
 */
class YouTrack20184_api
{
	private $_address;
	private $_cookies;
	private $_curl;

	/**
	 * Construct
	 *
	 * Initializes a new YouTrack API object. Expects the web address
	 * of the YouTrack installation including http or https prefix.
	 */
	public function __construct($address)
	{
		$this->_address = str::slash($address) . 'rest/';
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

		throw new YouTrackException($message);
	}

	private function _send_command($method, $command, $data = null)
	{
		$url = $this->_address . $command;
		return $this->_send_request($method, $url, $data);
	}

	private function _send_request($method, $url, $data = null)
	{
		$options['data'] = $data;
		if ($this->_cookies)
		{
			$options['cookies'] = $this->_cookies;
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
			$options
		);

		// In case debug logging is enabled, we append the data
		// we've sent and the entire request/response to the log.
		if (logger::is_on(GI_LOG_LEVEL_DEBUG))
		{
			logger::debugr('$data', $data);
			logger::debugr('$response', $response);
		}

		if ($response->code == 501)
		{
			$this->_throw_error(
				'The YouTrack REST API is not enabled ({0})',
				$response->code
			);
		}

		// Parse the DOM before checking the HTTP code in order
		// to make use of the <error> tag which describes any
		// errors in detail.
		$dom = $this->_parse_response($response->content);

		if ($response->code != 200)
		{
			$this->_throw_error(
				'Invalid HTTP code ({0})', $response->code
			);
		}

		if (!$this->_cookies)
		{
			// Save the cookies of the first request which serve
			// as login token.
			$this->_cookies = $response->cookies;
		}

		return $dom;
	}

	private function _parse_response($response)
	{
		if (!str::starts_with($response, '<?xml'))
		{
			// Some commands do not contain an XML header which is
			// needed by our XML parser for detecting the encoding
			// etc.
			$response = '<?xml version="1.0" encoding="UTF-8" ?>' .
				$response;
		}

		// YouTrack does not wrap its result in a <response> tag or
		// something similar. Since it is easier to work with our
		// XML api if we have such a tag, we add it here.
		$response = preg_replace(
			'/(<\?xml[^>]+\?>)(.*)/su',
			'\1<response>\2</response>',
			$response
		);

		$dom = xml::parse_string($response);

		if (isset($dom->error))
		{
			$this->_throw_error((string) $dom->error);
		}

		return $dom;
	}

	/**
	 * Login
	 *
	 * Logs in to the YouTrack installation using the provided user
	 * and password.
	 */
	public function login($user, $password)
	{
		$data['login'] = $user;
		$data['password'] = $password;
		$this->_send_command('POST', 'user/login', $data);
	}

	/**
	 * Logout
	 *
	 * Logs the user out. You can use login() to log in again.
	 */
	public function logout()
	{
		// PLEASE NOTE: YouTrack's API command for logging out is
		// not documented or does not exist at all.
		$this->_cookies = null;
	}

	/**
	 * Get Types
	 *
	 * Returns a list of types for the YouTrack installation. Types
	 * are returned as array of objects, each with its ID and name.
	 */
	public function get_types()
	{

	    $response = $this->_send_command('GET', 'admin/customfield/bundle/Types');

	    if (!$response)
	    {
	        return array();
	    }

	    $result = array();
	    $enum = $response->enumeration;
	    $types = $enum->value;
	    foreach ($types as $type)
	    {
	        $t = obj::create();
	        $t->name = (string) $type;
	        $t->id = $t->name;
	        $result[] = $t;
	    }

	    return $result;
	}

	/**
	 * Get Projects
	 *
	 * Returns a list of projects for the YouTrack installation.
	 * Projects are returned as array of objects, each with its ID
	 * and name.
	 */
	public function get_projects()
	{
		$response =
			$this->_send_command('GET', 'project/all?verbose=true');

		if (!$response)
		{
			return array();
		}

		$result = array();

		$projects = $response->projects;
		foreach ($projects->project as $project)
		{
			$p = obj::create();
			$p->name = (string) $project['name'];
			$p->id = (string) $project['shortName'];

			$p->subsystems = array();
			if (isset($project->subsystems->sub))
			{
				foreach ($project->subsystems->sub as $sub)
				{
					$s = obj::create();
					$s->name = (string) $sub['value'];
					$s->id = $s->name;
					$p->subsystems[] = $s;
				}
			}

			$result[] = $p;
		}

		return $result;
	}

	/**
	 * Get Subsystems
	 *
	 * Returns a list of subsystems for the given project for the
	 * YouTrack installation. Subsystems are returned as array of
	 * objects, each with its ID and name.
	 */
	public function get_subsystems($project_id)
	{
		$project = arr::get(
			obj::get_lookup(
				$this->get_projects()
			),
			$project_id
		);

		if (!$project)
		{
			return array();
		}

		return $project->subsystems;
	}

	/**
	 * Get States
	 *
	 * Returns a list of states for the YouTrack installation.
	 * States are returned as array of objects, each with its ID,
	 * name and a resolved property.
	 */
	public function get_states()
	{

		$response = $this->_send_command('GET', 'admin/customfield/stateBundle/States');


		if (!$response)
		{
			return array();
		}

		$result = array();

		$stateBundle = $response->stateBundle;
                $states = $stateBundle->state;

		foreach ($states as $state)
		{

			$s = obj::create();
			$s->name = (string) $state[0];
			$s->id = $s->name;
			$s->resolved = $state['resolved'] == 'true';
			$result[] = $s;
		}

		return $result;
	}

	/**
	 * Get Issue
	 *
	 * Gets an existing case from the YouTrack installation and
	 * returns it. The resulting issue object has various properties
	 * such as the summary, description, project etc.
	 */
	public function get_issue($issue_id)
	{
		$response = $this->_send_command(
			'GET', 'issue/' . urlencode($issue_id)
		);

		$issue = $response->issue;
		$mappings = array(
			'summary' => 'summary',
			'type' => 'type',
			'projectshortname' => 'project',
			'state' => 'state',
			'subsystem' => 'subsystem',
			'description' => 'description'
		);

		$result = array();
		foreach ($issue->field as $field)
		{
			$name = str::to_lower((string) $field['name']);
			if (!isset($mappings[$name]))
			{
				continue;
			}

			$value = (string) $field->value;
			$result[$mappings[$name]] = $value;
		}

		return $result;
	}

	/**
	 * Add Issue
	 *
	 * Adds a new issue to the YouTrack installation with the given
	 * parameters (title, project etc.) and returns its ID.
	 *
	 * summary:     The summary of the new issue
	 * type:        The ID of the type of the new issue (bug,
	 *              feature request etc.)
	 * project:     The ID of the project the issue should be added
	 *              to
	 * subsystem:   The ID of the subsystem the issue is added to
	 * description: The description of the new issue
	 */
	public function add_issue($options)
	{
		$response = $this->_send_command('POST', 'issue', $options);

		$issue = $response->issue;
		if (!isset($issue['id']))
		{
			$this->_throw_error('No issue ID received');
		}

		return (string) $issue['id'];
	}
}
