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
 */

class Jira_defect_plugin extends Defect_plugin
{
	public $userKey = 'user';
	public $secretKey = 'password';

	private $_api;
	
	private $_address;
	private $_user;
	private $_password;
	
	private static $_meta = array(
		'author' => 'Gurock Software',
		'version' => '1.0',
		'description' => 'JIRA defect plugin for TestRail',
		'can_push' => true,
		'can_lookup' => true,
		'default_config' => 
			'; Please configure your JIRA connection below.
;
; Note: this plugin is for JIRA 3.x and 4.x. You can
; use our new and more advanced JIRA REST plugin for
; JIRA Server 5.x, 6.x and later. For cloud version
; use JIRA Cloud
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
		
		$this->_api = new Jira_api($this->_address);
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
					'label' => 'Issue Type',
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
				'component' => array(
					'type' => 'dropdown',
					'label' => 'Component',
					'required' => true,
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
		// Jira installation.		
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

			case 'component':
				if (isset($input['project']))
				{
					$data['default'] = arr::get($prefs, 'component');
					$data['options'] = $this->_to_id_name_lookup(
						$api->get_components($input['project'])
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
		
		if (isset($issue->type))
		{
			$t = arr::get(
				obj::get_lookup($api->get_types()), 
				$issue->type
			);
			
			if ($t)
			{
				$attributes['Type'] = h($t->name);
			}
		}

		$status = '';
		if (isset($issue->status))
		{
			$s = arr::get(
				obj::get_lookup($api->get_statuses()),
				$issue->status
			);
			
			if ($s)
			{
				$attributes['Status'] = h($s->name);
				$status = $s->name;
			}
		}

		if (isset($issue->project))
		{
			// Add a link to the project.
			$attributes['Project'] = str::format(
				'<a target="_blank" href="{0}browse/{1}">{2}</a>',
				a($this->_address),
				a($issue->project),
				h($issue->project)
			);
		}
		
		// Decide which status to return to TestRail based on the
		// resolution property of the issue (whether the issue was
		// resolved or not). The issue or statuses don't have any
		// additional meta information so that's unfortunately the
		// only distinction we can make for the status.
		$status_id = GI_DEFECTS_STATUS_OPEN;

		if (isset($issue->resolution))
		{
			if ($issue->resolution)
			{
				$status_id = GI_DEFECTS_STATUS_RESOLVED;
			}
		}
		
		// Format the description of the issue (we use a monospace
		// font).
		if (isset($issue->description) && $issue->description)
		{
			$description = str::format(
				'<div class="monospace">{0}</div>',
				nl2br(
					html::link_urls(
						h($issue->description)
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
				'{0}browse/{1}',
				$this->_address,
				$defect_id
			),
			'title' => $issue->summary,
			'status_id' => $status_id,
			'status' => $status,
			'description' => $description,
			'attributes' => $attributes
		);
	}
}

/**
 * Jira API
 *
 * Wrapper class for the Jira API with login/logout and functions
 * for retrieving projects etc. from a Jira installation. Uses the
 * SOAP API of Jira.
 */
class Jira_api
{
	private $_soap;
	private $_token;
	
	/**
	 * Construct
	 *
	 * Initializes a new Jira API object. Expects the web address
	 * of the Jira installation including http or https prefix.
	 */	
	public function __construct($address)
	{
		$address = str::slash($address);
		$this->_soap = soap::get_client(
			$address . 'rpc/soap/jirasoapservice-v2?wsdl'
		);
	}
	
	private function _send_command($command, $data = array())
	{
		if (logger::is_on(GI_LOG_LEVEL_DEBUG))
		{
			logger::debugf('SOAP call: {0}', $command);
		}
		
		// Send along the token of the login, if available.
		if ($this->_token)
		{
			if ($data)
			{
				array_unshift($data, $this->_token);
			}
			else 
			{
				$data = array($this->_token);
			}
		}
		
		$result = $this->_soap->__soapCall($command, $data);
		
		// In case debug logging is enabled, we append the data
		// we've sent and the entire request/response to the log.
		if (logger::is_on(GI_LOG_LEVEL_DEBUG))
		{
			logger::debugr(
				'$soap',
				array(
					'request_headers' => 
						$this->_soap->__getLastRequestHeaders(),
					'request' => 
						$this->_soap->__getLastRequest(),
					'response_headers' => 
						$this->_soap->__getLastResponseHeaders(),
					'response' => 
						$this->_soap->__getLastResponse()
				)
			);
		}
		
		return $result;
	}
	
	/**
	 * Login
	 *
	 * Logs in to the Jira installation using the provided user
	 * and password.
	 */	
	public function login($user, $password)
	{
		$data = array($user, $password);
		$this->_token = $this->_send_command('login', $data);
	}
	
	/**
	 * Logout
	 *
	 * Logs the user out. You can use login() to log in again.
	 */	
	public function logout()
	{
		$this->_send_command('logout');
		$this->_token = null;
	}

	/**
	 * Get Types
	 *
	 * Returns a list of issue types for the Jira installation.
	 * The issue types are returned as array of objects, each
	 * with its ID and name.
	 */	
	public function get_types()
	{
		$response = $this->_send_command('getIssueTypes');
		
		if (!$response)
		{
			return array();
		}
		
		$result = array();
		foreach ($response as $type)
		{
			$t = obj::create();
			$t->id = (string) $type->id;
			$t->name = (string) $type->name;
			$result[] = $t;
		}
		
		return $result;
	}
	
	/**
	 * Get Statuses
	 *
	 * Returns a list of statuses for the Jira installation.
	 * The statuses are returned as array of objects, each with
	 * its ID and name.
	 */	
	public function get_statuses()
	{
		$response = $this->_send_command('getStatuses');
		
		if (!$response)
		{
			return array();
		}
		
		$result = array();
		foreach ($response as $status)
		{
			$s = obj::create();
			$s->id = (string) $status->id;
			$s->name = (string) $status->name;
			$result[] = $s;
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
		$response = $this->_send_command('getProjectsNoSchemes');
		
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
	 * Get Components
	 *
	 * Returns a list of components for the given project for the Jira
	 * installation. Components are returned as array of objects, each
	 * with its ID and name.
	 */
	public function get_components($project_id)
	{
		$data = array($project_id);
		$response = $this->_send_command('getComponents', $data);

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
	
	/**
	 * Get Issue
	 *
	 * Gets an existing case from the Jira installation and returns
	 * it. The resulting issue object has various properties such
	 * as the summary, description, project etc.
	 */	 
	public function get_issue($issue_id)
	{
		$data = array($issue_id);
		return $this->_send_command('getIssue', $data);
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
	 * type:        The ID of the type of the new issue (bug,
	 *              feature request etc.)
	 * project:     The ID of the project the issue should be added
	 *              to
	 * component:   The ID of the component the issue should be
	 *              added to
	 * description: The description of the new issue
	 */	
	public function add_issue($options)
	{
		if (isset($options['component']))
		{
			// Jira requires an array of components instead of a
			// single component.
			$options['components'] = array(
				array('id' => $options['component'])
			);
		}
		
		$data = array($options);
		$response = $this->_send_command('createIssue', $data);
		return $response->key;
	}
}

class JiraException extends Exception
{
}

// Check for the soap PHP module/extensions that is required by
// this plugin.
if (!class_exists('SoapClient', false))
{
	throw new JiraException(
		'The Jira defect plugin requires the soap PHP extension
which has not yet been installed.'
	);
}
