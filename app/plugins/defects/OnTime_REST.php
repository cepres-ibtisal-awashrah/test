<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

/**
 * OnTime Defect Plugin for TestRail
 *
 * Copyright Gurock Software GmbH. All rights reserved.
 *
 * This is the TestRail defect plugin for OnTime's REST API. Please
 * see http://docs.gurock.com/testrail-integration/defects-plugins
 * for more information about TestRail's defect plugins.
 *
 * http://www.gurock.com/testrail/
 */

class OnTime_REST_defect_plugin extends Defect_plugin
{
	private $_api;

	private $_address;
	private $_user;
	private $_password;
	private $_client_id;
	private $_client_secret;

	private static $_meta = array(
		'author' => 'Gurock Software',
		'version' => '1.0',
		'description' => 'OnTime defect plugin for TestRail',
		'can_push' => true,
		'can_lookup' => true,
		'default_config' => 
			'; Please configure your OnTime connection below.
; The client_id and client_secret can be generated
; in OnTime\'s administration area under Tools |
; System Options | OnTime API Settings.
;
; Note: requires OnTime 12.2.2 or later. You can use
; the \'OnTime SOAP\' defect plugin for older versions.
[connection]
address=https://<your-server>.ontimenow.com/
user=testrail
password=secret
client_id=01010101-0101-0101-0101-010101010101
client_secret=02020202-0202-0202-0202-020202020202'
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

		$keys = array('address', 'user', 'password', 'client_id',
			'client_secret');

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
		$this->_client_id = $ini['connection']['client_id'];
		$this->_client_secret = $ini['connection']['client_secret'];
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

	public function prepare_push($context)
	{
		// Return a form with the following fields/properties
		return array(
			'fields' => array(
				'name' => array(
					'type' => 'string',
					'label' => 'Name',
					'required' => true,
					'size' => 'full'
				),
				'project' => array(
					'type' => 'dropdown',
					'label' => 'Project',
					'required' => true,					
					'remember' => true,
					'cascading' => true,
					'size' => 'compact'
				),
				'workflow_step' => array(
					'type' => 'dropdown',
					'label' => 'Workflow Step',
					'required' => true,
					'remember' => true,
					'depends_on' => 'project',
					'size' => 'compact'
				),
				'release' => array(
					'type' => 'dropdown',
					'label' => 'Release',
					'remember' => true,
					'size' => 'compact'
				),
				'priority' => array(
					'type' => 'dropdown',
					'label' => 'Priority',
					'remember' => true,
					'size' => 'compact'
				),
				'severity' => array(
					'type' => 'dropdown',
					'label' => 'Severity',
					'remember' => true,
					'size' => 'compact'
				),
				'assigned_to' => array(
					'type' => 'dropdown',
					'label' => 'Assigned To',
					'remember' => true,
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

		return $data;
	}
	
	public function validate_push($context, $input)
	{
	}
	
	public function push($context, $input)
	{
		$api = $this->_get_api();
		return $api->add_defect($input);
	}

	// *********************************************************
	// LOOKUP
	// *********************************************************

	public function lookup($defect_id)
	{
		$api = $this->_get_api();

		$defect = $api->get_defect($defect_id);

		if (isset($defect->project->id) &&
			$defect->project->id)
		{
			$p = $this->_api->get_project($defect->project->id);
			
			if ($p)
			{
				$attributes['Project'] = h($p->name);
			}
		}

		if (isset($defect->workflow_step->id) &&
			$defect->workflow_step->id)
		{
			$ws = $this->_api->get_workflow_step($defect->project->id,
				$defect->workflow_step->id);

			if ($ws)
			{
				$attributes['Workflow Step'] = h($ws->name);
			}
		}
		else 
		{
			$ws = null;
		}

		if (isset($defect->release->id) &&
			$defect->release->id)
		{
			$r = $this->_api->get_release($defect->release->id);
			
			if ($r)
			{
				$attributes['Release'] = h($r->name);
			}
		}

		if (isset($defect->priority->id) &&
			$defect->priority->id)
		{
			$p = $this->_api->get_priority($defect->priority->id);
			
			if ($p)
			{
				$attributes['Priority'] = h($p->name);
			}
		}

		if (isset($defect->severity->id) &&
			$defect->severity->id)
		{
			$s = $this->_api->get_severity($defect->severity->id);
			
			if ($s)
			{
				$attributes['Severity'] = h($s->name);
			}
		}

		if (isset($defect->assigned_to->id) && 
			$defect->assigned_to->id)
		{
			$at = $this->_api->get_user($defect->assigned_to->id);
			
			if ($at)
			{
				$attributes['Assigned To'] = h($at->name);
			}
		}

		// Decide which status to return to TestRail based on the
		// name of the Workflow Step. The defect or statuses
		// don't have any additional meta information so that's
		// unfortunately the only distinction we can make for the
		// status.
		$status_id = GI_DEFECTS_STATUS_OPEN;
		$status = '';

		if ($ws)
		{
			$status = $ws->name;

			if (str::to_lower($ws->name) == 'fixed' ||
				str::to_lower($ws->name) == 'rejected') 
			{				
				$status_id = GI_DEFECTS_STATUS_CLOSED;
			}
			else 
			{
				// Check for default IDs as fallback (in case the steps
				// were renamed, for example). 5 = Fixed, 6 = Rejected
				if ($ws->id == 5 || $ws->id == 6)
				{
					$status_id = GI_DEFECTS_STATUS_CLOSED;
				}
			}
		}

		// Format the description of the defect (we use a monospace
		// font).
		if ($defect->description)
		{
			$description = str::format(
				'<div class="monospace">{0}</div>',
				$defect->description
			);
		}
		else
		{
			$description = null;
		}

		return array(
			'id' => $defect_id,
			'url' => str::format(
				'{0}viewitem.aspx?id={1}&type=defects',
				$this->_address,
				$defect_id
			),
			'title' => $defect->name,
			'status_id' => $status_id,
			'status' => $status,
			'description' => $description,
			'attributes' => $attributes
		);
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
		$url = $this->_address . 'api/v1/' . $uri;

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

		if ($response->code != 200)
		{
			$this->_throw_error(
				'Invalid HTTP code ({0}). Please check your user/' . 
				'password for OnTime.',
				$response->code
			);
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
					'item_type' => 'defects',
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
				if ($workflow->item_type == 'defects')
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
				'defects/' . urlencode($defect_id)
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

		return $defect;
	}

	/**
	 * Add Defect
	 *
	 * Adds a new defect to the OnTime installation with the given
	 * parameters (title, project etc.) and returns its ID. The
	 * parameters must be named according to the OnTime's API format,
	 * e.g.:
	 *
	 * name:			The title of the new defect
	 * project:     	The ID of the project the defect should be
	 *                  added to
	 * priority:		The ID of the priority the defect is added with
	 * severity:		The ID of the severity the defect is added with
	 * workflow_step:	The ID of the workflow step (status) the defect
	 *                  is added with
	 * description:		The description of the new defect
	 */
	public function add_defect($options)
	{
		$data = $options;
		if (isset($options['project']))
		{
			$data['project'] = array('id' => $options['project']);			
		}
		
		if (isset($options['severity']))
		{
			$data['severity'] = array('id' => $options['severity']);
		}

		if (isset($options['priority']))
		{
			$data['priority'] = array('id' => $options['priority']);
		}

		if (isset($options['workflow_step']))
		{
			$data['workflow_step'] = array('id' =>
				$options['workflow_step']);
		}
		
		if (isset($options['assigned_to']))
		{
			$data['assigned_to'] = array('id' =>
				$options['assigned_to']);
		}
		
		if (isset($options['release']))
		{
			$data['release'] = array('id' =>
				$options['release']);
		}

		if (isset($options['description']))
		{
			$data['description'] = nl2br(
				html::link_urls(
					h($options['description'])
				)
			);
		}

		$response = $this->_send_command(
			'POST',
			'defects',
			$data
		);

		$defect = $response->data;
		if (!isset($defect->id))
		{
			$this->_throw_error('No issue ID received');
		}

		return (string) $defect->id;
	}
}

class OnTime_RESTException extends Exception
{
}
