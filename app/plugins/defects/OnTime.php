<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

/**
 * OnTime Defect Plugin for TestRail
 *
 * Copyright Gurock Software GmbH. All rights reserved.
 *
 * This is the TestRail defect plugin for Axosoft OnTime. Please see
 * http://docs.gurock.com/testrail-integration/defects-plugins for
 * more information about TestRail's defect plugins.
 *
 * http://www.gurock.com/testrail/
 */

class OnTime_defect_plugin extends Defect_plugin
{
	private $_api;
	
	private $_address;
	private $_token;
	
	private static $_meta = array(
		'author' => 'Gurock Software',
		'version' => '1.0',
		'description' => 'OnTime defect plugin for TestRail',
		'can_push' => true,
		'can_lookup' => true,
		'default_config' => 
			'; Please configure your OnTime connection below. The
; address should point to your OnTime SDK.
;
; Note: For OnTime 12.2.2 or later, it is recommended
; to use the \'OnTime REST\' defect plugin which does not
; require installing the OnTime SDK.
[connection]
address=http://<your-server>/
token=secret'
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
		
		$keys = array('address', 'token');
		
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
		$this->_token = $ini['connection']['token'];
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
		
		$this->_api = new OnTime_api($this->_address, $this->_token);
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
					'size' => 'compact'
				),
				'status' => array(
					'type' => 'dropdown',
					'label' => 'Status',
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
	
	private function _get_name_default($context)
	{
		$test = current($context['tests']);
		$name = 'Failed test: ' . $test->case->title;
		
		if ($context['test_count'] > 1)
		{
			$name .= ' (+others)';
		}
		
		return $name;
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
			$result[$item['id']] = $item['name'];
		}
		return $result;
	}
	
	public function prepare_field($context, $input, $field)
	{
		$data = array();
		
		// Process those fields that do not need a connection to the
		// OnTime installation.
		if ($field == 'name' || $field == 'description' || 
			$field == 'type')
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
				
				case 'type':
					$data['default'] = '0';
					$data['options'] = array('0' => 'Defect');
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

			case 'status':
				$data['default'] = arr::get($prefs, 'status');
				$data['options'] = $this->_to_id_name_lookup(
					$api->get_statuses()
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
		
		// Add some important attributes for the issue such as the
		// defect type, current status and project. Note that the
		// attribute values (and description) support HTML and we
		// thus need to escape possible HTML characters (with 'h')
		// in this plugin.		
		$attributes = array('Type' => 'Defect');
		
		$status = '';		
		if (isset($defect['status_id']))
		{
			$s = $this->_api->get_status($defect['status_id']);
			
			if ($s)
			{
				$status = $s['name'];
				$attributes['Status'] = h($s['name']);
			}
		}
		
		if (isset($defect['project_id']))
		{
			$p = $this->_api->get_project($defect['project_id']);
			
			if ($p)
			{
				$attributes['Project'] = h($p['name']);
			}
		}

		// Decide which status to return to TestRail based on the
		// resolution property of the defect. The defect or statuses
		// don't have any additional meta information so that's
		// unfortunately the only distinction we can make for the
		// status.		
		$status_id = GI_DEFECTS_STATUS_OPEN;

		if (isset($defect['resolution']))
		{
			if ($defect['resolution'])
			{
				$status_id = GI_DEFECTS_STATUS_RESOLVED;
			}
		}
		
		// Format the description of the issue (we use a monospace
		// font). Since OnTime supports and returns HTML, we do not
		// escape HTML characters here and pass it to TestRail.
		if (isset($defect['description']) && $defect['description'])
		{
			$description = str::format(
				'<div class="monospace">{0}</div>',
				$defect['description']
			);
		}
		else
		{
			$description = null;
		}
		
		return array(
			'id' => $defect_id,
			/*
			'url' => str::format(
				'{0}browse/{1}',
				$this->_address,
				$defect_id
			),
			*/
			'title' => $defect['name'],
			'status_id' => $status_id,
			'status' => $status,
			'description' => $description,
			'attributes' => $attributes
		);
	}
}

/**
 * OnTime API
 *
 * Wrapper class for the OnTime API with login/logout and functions
 * for retrieving projects etc. from a OnTime installation. Uses the
 * SOAP APIs of OnTime.
 */
class OnTime_api
{
	private $_projects;
	private $_types;
	private $_defects;
	
	/**
	 * Construct
	 *
	 * Initializes a new OnTime API object. Expects the web address
	 * of the OnTime installation including http or https prefix.
	 */	
	public function __construct($address, $token)
	{
		$this->_projects = new OnTime_project_handler($address, $token);
		$this->_types = new OnTime_type_handler($address, $token);
		$this->_defects = new OnTime_defect_handler($address, $token);
	}

	/**
	 * Get Status
	 *
	 * Returns the status item specified by the given status ID.
	 * Use get_statuses to get a list of all statuses.
	 */
	public function get_status($status_id)
	{
		return $this->_types->get_status($status_id);
	}

	public function get_statuses()
	{
		return $this->_types->get_statuses();
	}	
	
	/**
	 * Get Project
	 *
	 * Returns the project item specified by the given project ID.
	 * The returned project includes the name and ID of the parent
	 * project. Use get_projects to get a list of all projects.
	 */
	public function get_project($project_id)
	{
		return $this->_projects->get($project_id);
	}
	
	public function get_projects()
	{
		$projects = $this->_projects->get_all();
		return $this->_sort_projects($projects);
	}
	
	private function _sort_projects($projects)
	{
		// Build a lookup table between project IDs and the child
		// projects.
		$childs = array();
		foreach ($projects as $project)
		{
			$parent_id = $project['parent_id'];
			
			if (!isset($childs[$parent_id]))
			{
				$childs[$parent_id] = array();
			}
			
			$childs[$parent_id][] = $project;		
		}

		// Then sort the childs (it seems that the OnTime API always
		// returns the projects in alphabetical order, but we sort
		// them anyway to be sure).
		foreach ($childs as &$child)
		{
			sort($child);
		}

		// And then build a 'tree' for the projects by traversing the
		// parent IDs and appending the childs.
		$tree = array();
		$this->_build_project_tree($tree, 0, $childs, 0);
		return $tree;
	}
	
	private function _build_project_tree(&$tree, $parent_id, $childs,
		$level)
	{
		$projects = arr::get($childs, $parent_id);
		
		if (!$projects)
		{
			return;
		}
		
		foreach ($projects as $project)
		{
			if ($level > 0)
			{
				// Indent the project name based on the depth/level
				// in the project tree.
				$project['name'] = str::repeat("\xC2\xA0", $level*3) .
					$project['name'];
			}
			
			$tree[] = $project;
			
			$this->_build_project_tree(
				$tree,
				$project['id'],
				$childs,
				$level + 1
			);
		}
	}
	
	/**
	 * Get Defect
	 *
	 * Returns the defect item specified by the given defect ID.
	 * The returned defect includes the name, description as well as
	 * its status and project IDs.
	 */
	public function get_defect($defect_id)
	{
		return $this->_defects->get($defect_id);
	}
	
	public function add_defect($options)
	{
		return $this->_defects->add($options);
	}
}

abstract class OnTime_handler
{
	protected $_address;
	protected $_token;
	protected $_soap;
	
	public function __construct($address, $token)
	{
		$this->_address = str::slash($address);
		$this->_token = $token;
	}
	
	protected abstract function _get_service();
	
	protected function _send_command($command, $data = null)
	{
		if (!$this->_soap)		
		{
			// Create the SOAP client on demand for the specific
			// service type of this handler.
			$this->_soap = soap::get_client(
				$this->_address . $this->_get_service() . 'Service.asmx?wsdl'
			);
		}
		
		if (logger::is_on(GI_LOG_LEVEL_DEBUG))
		{
			logger::debugf('SOAP call: {0}', $command);
		}
		
		// Send along the security token, if available.
		if ($this->_token)
		{
			if (!$data)
			{
				$data = obj::create();
			}

			$data->securityToken = $this->_token;
		}
		
		$result = $this->_soap->$command($data);
		
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
	
	protected function _parse_dataset($xml, $context)
	{
		$dom = xml::parse_string($xml);
		
		if (!isset($dom->NewDataSet))
		{
			throw new OnTimeException(
				"Invalid DOM (missing NewDataSet element for $context)"
			);
		}
		
		$dataset = $dom->NewDataSet;
		if (!isset($dataset->Table))
		{
			throw new OnTimeException(
				"Invalid DOM (missing Table element for $context)"
			);
		}
		
		return $dataset->Table;
	}
}

/**
 * OnTime Type Handler
 *
 * The handler for the type service of OnTime. Provides functions
 * for looking up status types.
 */ 
class OnTime_type_handler extends OnTime_handler
{
	public function __construct($address, $token)
	{
		parent::__construct($address, $token);
	}
	
	protected function _get_service()
	{
		return 'Type';
	}
	
	public function get_status($status_id)
	{
		$statuses = $this->get_statuses();
		
		foreach ($statuses as $status)
		{
			if ($status['id'] == $status_id)
			{
				return $status;
			}
		}
		
		return null;
	}	
	
	public function get_statuses()
	{
		$response = $this->_send_command('GetStatusTypes');
		
		if (!isset($response->GetStatusTypesResult))
		{
			throw new OnTimeException(
				'Invalid response (empty status type result)'
			);
		}

		$statuses = $response->GetStatusTypesResult;
		if (!isset($statuses->any))
		{
			throw new OnTimeException(
				'Invalid response (missing status type data)'
			);
		}
		
		return $this->_parse_statuses($statuses->any);
	}
	
	private function _parse_statuses($xml)
	{
		$dataset = $this->_parse_dataset($xml, 'status');
		
		$fields = array(
			'StatusTypeId' => 'id',
			'Name' => 'name'
		);
		
		$statuses = array();
		foreach ($dataset as $status)
		{
			$s = array();
			
			foreach ($fields as $name => $mapping)
			{
				if (!isset($status->$name))
				{
					throw new OnTimeException(
						"Invalid status DOM (missing $name)"
					);
				}
				
				$s[$mapping] = (string)$status->$name;
			}
			
			$statuses[] = $s;
		}
		
		return $statuses;
	}
}

/**
 * OnTime Project Handler
 *
 * The handler for the project service of OnTime. Provides functions
 * for looking up projects.
 */ 
class OnTime_project_handler extends OnTime_handler
{
	public function __construct($address, $token)
	{
		parent::__construct($address, $token);
	}
	
	protected function _get_service()
	{
		return 'Project';
	}
	
	public function get($project_id)
	{
		$projects = $this->get_all();
		
		foreach ($projects as $project)
		{
			if ($project['id'] == $project_id)
			{
				return $project;
			}
		}
		
		return null;
	}
	
	public function get_all()
	{
		$response = $this->_send_command('GetAllProjects');
		
		if (!isset($response->GetAllProjectsResult))
		{
			throw new OnTimeException(
				'Invalid response (empty project result)'
			);
		}

		$projects = $response->GetAllProjectsResult;
		if (!isset($projects->any))
		{
			throw new OnTimeException(
				'Invalid response (missing project data)'
			);
		}
		
		return $this->_parse_projects($projects->any);
	}
	
	private function _parse_projects($xml)
	{
		$dataset = $this->_parse_dataset($xml, 'project');
		
		$fields = array(
			'ProjectId' => 'id',
			'ParentId' => 'parent_id',
			'Name' => 'name',
			'Path' => 'path'
		);
		
		$projects = array();
		foreach ($dataset as $project)
		{
			$p = array();
			
			if (isset($project->IsActive))
			{
				if ($project->IsActive == 'false')
				{
					continue; // Inactive projects are ignored
				}
			}
			
			foreach ($fields as $name => $mapping)
			{
				if (!isset($project->$name))
				{
					throw new OnTimeException(
						"Invalid project DOM (missing $name)"
					);
				}
				
				$p[$mapping] = (string)$project->$name;
			}
			
			$projects[] = $p;
		}
		
		return $projects;
	}
}

/**
 * OnTime Defect Handler
 *
 * The handler for the defect service of OnTime. Provides functions
 * for looking up defects.
 */ 
class OnTime_defect_handler extends OnTime_handler
{
	public function __construct($address, $token)
	{
		parent::__construct($address, $token);
	}
	
	protected function _get_service()
	{
		return 'Defect';
	}
	
	public function get($defect_id)
	{
		$data = obj::create();
		$data->defectId = $defect_id;
		$response = $this->_send_command('GetByDefectId', $data);
		
		if (!isset($response->GetByDefectIdResult))
		{
			throw new OnTimeException(
				'The requested defect does not exist'
			);
		}
		
		$defect = $response->GetByDefectIdResult;
		
		return array(
			'id' => $defect_id,
			'name' => $defect->Name,
			'description' => $defect->Description,
			'resolution' => $defect->Resolution,
			'project_id' => $defect->ProjectId,
			'status_id' => $defect->StatusTypeId
		);
	}
	
	public function add($options)
	{
		$today = date::format("yyyy-MM-dd'T00:00:00Z'");
		
		// OnTime's API requires all these fields to be present.
		$defect = array(
			'Name' => $options['name'],
			'ProjectId' => $options['project'],
			'StatusTypeId' => $options['status'],
			'Description' => nl2br(
				html::link_urls($options['description'])
			),
			'HasAttachments' => false,
			'HasNotifications' => false,
			'HasRelatedItems' => false,
			'HasSCMFiles' => false,
			'HasEmails' => false,
			'HasWorkLog' => false,
			'HasAlerts' => false,
			'LastUpdatedById' => 0,
			'Archived' => false,
			'WorkflowStepId' => 0,
			'ReportedById' => 0,
			'AssignedToId' => 0,
			'CreatedById' => 0,
			'ReportedByCustomerContactId' => 0,
			'EstimatedDuration' => 0,
			'DurationUnitTypeId' => 0,
			'RemainingDuration' => 0,
			'RemainingUnitTypeId' => 0,
			'ActualDuration' => 0,
			'ActualUnitTypeId' => 0,
			'PubliclyViewable' => false,
			'DueDate' => '1800-01-01T00:00:00Z', // "NULL"
			'PriorityTypeId' => 0,
			'ReleaseId' => 0,
			'PercentComplete' => 0,
			'CreatedDateTime' => $today,
			'LastUpdatedDateTime' => $today,
			'VoteCount' => 0,
			'VoteAverage' => 0,
			'UserVote' => 0,
			'VoteItemType' => 'Defect',
			'ItemId' => 0,
			'DefectId' => 0,
			'DateFound' => $today,
			'DateFixed' => '1800-01-01T00:00:00Z', // "NULL"
			'SeverityTypeId' => 0,
			'CreatorId' => 0,
			'ParentId' => 0,
			'SubitemType' => 'Item',
			'WorkflowStepDirty' => false, 
			'movedParent' => false,
			'unmovedParent' => false			
		);
		
		$data = obj::create();
		$data->defect = $defect;
		$response = $this->_send_command('AddDefect', $data);
	
		if (!isset($response->AddDefectResult))
		{
			throw new OnTimeException(
				'Invalid response (empty project result)'
			);
		}	
	
		return $response->AddDefectResult;
	}
}

class OnTimeException extends Exception
{
}

// Check for the soap PHP module/extensions that is required by
// this plugin.
if (!class_exists('SoapClient', false))
{
	throw new OnTimeException(
		'The OnTime defect plugin requires the soap PHP extension
which has not yet been installed.'
	);
}
