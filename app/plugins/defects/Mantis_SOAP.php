<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

/**
 * Mantis Defect Plugin for TestRail
 *
 * Copyright Gurock Software GmbH. All rights reserved.
 *
 * This is the TestRail defect plugin for Mantis. Please see
 * http://docs.gurock.com/testrail-integration/defects-plugins for
 * more information about TestRail's defect plugins.
 *
 * http://www.gurock.com/testrail/
 */

class Mantis_SOAP_defect_plugin extends Defect_plugin
{
	private $_api;
	
	private $_address;
	private $_user;
	private $_password;
	
    private static $_meta = [
        'author' => 'Gurock Software',
        'version' => '1.0',
        'description' => 'Mantis SOAP defect plugin for TestRail',
        'can_push' => true,
        'can_lookup' => true,
        'default_config' => 
            '; Please configure your Mantis connection below
[connection]
address=http://<your-server>/
user=testrail
password=secret'
    ];
		
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
		
		$this->_api = new Mantis_api($this->_address, $this->_user, 
			$this->_password);
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
				'project' => array(
					'type' => 'dropdown',
					'label' => 'Project',
					'required' => true,
					'remember' => true,
					'cascading' => true,
					'size' => 'compact'
				),
				'category' => array(
					'type' => 'dropdown',
					'label' => 'Category',
					'required' => true,
					'remember' => true,
					'depends_on' => 'project',
					'size' => 'compact'
				),
				'reproducibility' => array(
					'type' => 'dropdown',
					'label' => 'Reproducibility',
					'required' => true,
					'remember' => true,
					'size' => 'compact'
				),
				'severity' => array(
					'type' => 'dropdown',
					'label' => 'Severity',
					'required' => true,
					'remember' => true,
					'size' => 'compact'
				),
				'priority' => array(
					'type' => 'dropdown',
					'label' => 'Priority',
					'required' => true,
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
		// Mantis installation.		
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
		
		// And then get the Mantis API object and process the remaining
		// fields.
		$api = $this->_get_api();
		
		switch ($field)
		{
			case 'priority':
				$data['default'] = arr::get($prefs, 'priority');
				$data['options'] = $this->_to_id_name_lookup(
					$api->get_priorities()
				);
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
				break;
			
			case 'reproducibility':
				$data['default'] = arr::get($prefs, 'reproducibility');
				$data['options'] = $this->_to_id_name_lookup(
					$api->get_reproducibilities()
				);
				break;

			case 'category':
				if (isset($input['project']))
				{
					$data['default'] = arr::get($prefs, 'category');
					$data['options'] = $this->_to_id_name_lookup(
						$api->get_categories($input['project'])
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
		// issue category, current status and project. Note that the
		// attribute values (and description) support HTML and we
		// thus need to escape possible HTML characters (with 'h')
		// in this plugin.
		
		$status = '';
		if (isset($issue->status->name))
		{
			$status = $issue->status->name;
		}

		$properties = array(
			'status' => 'Status',
			'project' => 'Project',
			'category' => 'Category',
			'reproducibility' => 'Reproducibility',
			'severity' => 'Severity',
			'priority' => 'Priority'
		);
		
		foreach ($properties as $k => $v)
		{
			if (isset($issue->$k))
			{
				if (isset($issue->$k->name))
				{
					$attributes[$v] = h($issue->$k->name);
				}
				else 
				{
					$attributes[$v] = h($issue->$k);
				}
			}
		}
		
		// Decide which status to return to TestRail based on the 
		// status ID of the issue. 
		$status_id = GI_DEFECTS_STATUS_OPEN;

		if (isset($issue->status))
		{			
			$id = obj::get($issue->status, 'id');
			switch ($id)
			{
				case 80:
					$status_id = GI_DEFECTS_STATUS_RESOLVED;
					break;
					
				case 90:
					$status_id = GI_DEFECTS_STATUS_CLOSED;
					break;
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
				'{0}view.php?id={1}',
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
 * Mantis API
 *
 * Wrapper class for the Mantis Soap API with for retrieving projects
 * etc. from a Mantis installation. Uses the SOAP API of Mantis.
 */
class Mantis_api
{
	private $_soap;
	private $_username;
	private $_password;

	/**
	 * Construct
	 *
	 * Initializes a new Mantis API object. Expects the web address
	 * of the Mantis installation including http or https prefix,
	 * the username and the password to log on to the Mantis installation.
	 */
	public function __construct($address, $username, $password)
	{
		$this->_username = $username;
		$this->_password = $password;
		$this->_soap = soap::get_client(
			$address . 'api/soap/mantisconnect.php?wsdl'
		);
	}
	
	private function _send_command($command, $data = array())
	{
		if (logger::is_on(GI_LOG_LEVEL_DEBUG))
		{
			logger::debugf('SOAP call: {0}', $command);
		}

		if (!$data)
		{
			$data = array($this->_username, $this->_password);
		}
		else
		{
			array_unshift($data, $this->_username, $this->_password);
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
	 * Get Severities
	 *
	 * Returns a list of severities for the Mantis installation
	 * The severities are returned as an array of objects, each
	 * with its ID and name.
	 */ 
	public function get_severities()
	{
		$response = $this->_send_command('mc_enum_severities');
		return $this->_get_id_name_pairs_from_soap_response($response);
	}
	
	/** 
	 * Get Status
	 *
	 * Returns a list of status for the Mantis installation
	 * The status are returned as an array of objects, each
	 * with its ID and name.
	 */ 
	public function get_status()
	{
		$response = $this->_send_command('mc_enum_status');
		return $this->_get_id_name_pairs_from_soap_response($response);
	}

	/** 
	 * Get Reproducibilities
	 *
	 * Returns a list of reproducibilities for the Mantis installation
	 * The reproducibilities are returned as an array of objects, each
	 * with its ID and name.
	 */ 
	public function get_reproducibilities()
	{
		$response = $this->_send_command('mc_enum_reproducibilities');
		return $this->_get_id_name_pairs_from_soap_response($response);
	}
	
	/** 
	 * Get Priorities
	 *
	 * Returns a list of priorities for the Mantis installation
	 * The priorities are returned as an array of objects, each
	 * with its ID and name.
	 */ 
	public function get_priorities()
	{
		$response  = $this->_send_command('mc_enum_priorities');
		return $this->_get_id_name_pairs_from_soap_response($response);
	}
	
	private function _get_id_name_pairs_from_soap_response($response)
	{
		$result = array();
		foreach ($response as $item)
		{
			$id_name_pair = obj::create();
			$id_name_pair->id = (string) $item->id;
			$id_name_pair->name = $item->name;
			$result[] = $id_name_pair;
		}
		
		return $result;
	}
	
	/**
	 * Get Projects
	 * 
	 * Returns a list of all projects within the Mantis installation
	 * that are accessible from the user account given to the constructor.
	 * The projects are returned as an array of objects, each
	 * with its ID and name. The names of subprojects are idented with
	 * whitespaces according to their level.
	 */
	public function get_projects()
	{
		$response = $this->_send_command('mc_projects_get_user_accessible');
		
		$result = array();
		$this->_get_project_array($response, $result, 0);		
		return $result;
	}

	private function _get_project_array($projects, &$result, $level)
	{
		foreach ($projects as $project)
		{
			$p = obj::create();
			$p->id = (string) $project->id;
			$p->name = (string) str::repeat("\xC2\xA0", $level*3) . 
				$project->name;
			$result[] = $p;
			
			if (isset($project->subprojects) &&  $project->subprojects)
			{
				$this->_get_project_array($project->subprojects, $result, 
					$level + 1); 
			}
		}
	}
	
	/**
	 * Get Categories
	 *
	 * Expects a valid id of a project within the Mantis installation.
	 * 
	 * Returns a list of categories available for the given project.
	 * The categories are returned as an array of objects, each
	 * with its ID and name, wheras in this case the ID exactly matches
	 * the project's name.
	 */
	public function get_categories($project_id)
	{
		$data = array($project_id);
		$response = $this->_send_command('mc_project_get_categories', $data);
		
		$result = array();
		foreach ($response as $category)
		{
			$c = obj::create();
			$c->id = $category;
			$c->name = $category;
			$result[] = $c;
		}
		
		return $result;
	}
	
	/**
	 * Get Issue
	 * 
	 * Expects a valid id of an issue within the Mantis installation.
	 *
	 * Returns the complete information of the issue from the
	 * Mantis installation. The resulting issue has various properties
	 * such as the summary, description, project etc. 
	 */
	public function get_issue($issue_id)
	{
		$data = array($issue_id);
		return $this->_send_command('mc_issue_get', $data);
	}
	
	/**
	 * Add Issue
	 *
	 * Adds a new issue to the Mantis installation with the given
	 * parameters (summary, description, project etc.) and returns
	 * its ID. The parameters must be named according to the Mantis
	 * API format, e.g.:
	 *
	 * summary:		The summary of the new issue
	 * priority:	The ID of the priority for the new issue
	 * project:		The name of the project to which the new
	 *				issue belongs
	 * category:	The name of the category for the new issue
	 */
	public function add_issue($options)
	{
		$options['project'] = array(
			'id' => $options['project']
		);
		
		$options['severity'] = array(
			'id' => $options['severity']
		);

		$options['reproducibility'] = array(
			'id' => $options['reproducibility']
		);

		$options['priority'] = array(
			'id' => $options['priority']
		);
		
		$data = array($options);		
		$response = $this->_send_command('mc_issue_add', $data);
		return $response;
	}
}

class MantisException extends Exception
{
}

// Check for the soap PHP module/extensions that is required by
// this plugin.
if (!class_exists('SoapClient', false))
{
	throw new MantisException(
		'The Mantis defect plugin requires the soap PHP extension
which has not yet been installed.'
	);
}
