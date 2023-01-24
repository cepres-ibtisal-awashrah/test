<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

/**
 * Sample Defect Plugin for TestRail
 *
 * Copyright Gurock Software GmbH. All rights reserved.
 *
 * This is a sample TestRail defect plugin that returns sample and
 * randomized data.
 *
 * http://www.gurock.com/testrail/
 */

define(
	'GI_DEFECTS_SAMPLE_INTRO',
	'<p class="message message-help top">Please note: the defect
	plugin you use is not a real defect plugin and only meant to test
	the integration features of TestRail. It does not store	any
	defects and only uses sample/fake/random data.</p>'
);

define(
	'GI_DEFECTS_SAMPLE_TITLE', 
	'This is a sample defect to demonstrate the defect integration'
);

define(
	'GI_DEFECTS_SAMPLE_DESCRIPTION', 
	'<p class="monospace top">Defects usually have a description (steps
	to reproduce) and the description is shown in this area. With a
	real defect plugin, TestRail pulls the live data from the defect
	or issue tracker and displays the current defect attributes in this
	popup.</p>
	<p class="bottom"><a href="{DEFECTS_PLUGINS}" target="_blank">Learn more<p>'
);

define(
	'GI_REFERENCES_SAMPLE_TITLE', 
	'This is a sample issue to demonstrate the reference integration'
);

define(
	'GI_REFERENCES_SAMPLE_DESCRIPTION', 
	'<p class="monospace top">References or requirements usually have a
	description (steps to verify) and the description is shown in this area.
	With a real reference plugin, TestRail pulls the live data from the
	requirement or issue tracker and displays the current attributes in
	this popup.</p>
	<p class="bottom"><a href="{DEFECTS_PLUGINS}" target="_blank">Learn more<p>'
);

class Sample_defect_plugin extends Defect_plugin
{
	private $_api;
	
	private static $_meta = array(
		'author' => 'Gurock Software',
		'version' => '1.0',
		'description' => 'Sample integration plugin for TestRail',
		'can_push' => true,
		'can_lookup' => true,
		'default_config' => 
			'; The sample integration plugin does not require any
; configuration. It can be used for evaluation and
; demonstration purposes and returns sample and random
; data.
;
; Please note: this is not a real integration plugin and
; only meant to test the integration features of TestRail.
; It does not store any defects or references and only
; uses sample and random data.'
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
	}
	
	public function configure($config)
	{
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
		
		$this->_api = new Sample_defect_api();
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
				'title' => array(
					'type' => 'string',
					'label' => 'Title',
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
				'area' => array(
					'type' => 'dropdown',
					'label' => 'Area',
					'required' => true,
					'remember' => true,
					'depends_on' => 'project',
					'size' => 'compact'
				),
				'priority' => array(
					'type' => 'dropdown',
					'label' => 'Priority',
					'required' => true,
					'remember' => true,
					'size' => 'compact'
				),
				'comment' => array(
					'type' => 'text',
					'label' => 'Comment',
					'rows' => 10
				)
			),
			'description' => GI_DEFECTS_SAMPLE_INTRO
		);
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
	
	private function _get_comment_default($context)
	{
		return $context['test_change']->description;
	}
	
	public function prepare_field($context, $input, $field)
	{
		$data = array();
		
		// Process those fields that do not need a connection to the
		// FogBugz installation.
		if ($field == 'title' || $field == 'comment')
		{
			switch ($field)
			{
				case 'title':
					$data['default'] = $this->_get_title_default(
						$context);
					break;
					
				case 'comment':
					$data['default'] = $this->_get_comment_default(
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
			case 'priority':
				$default = arr::get($prefs, 'priority');
				$data['options'] = $api->get_priorities();
				break;

			case 'project':
				$data['default'] = arr::get($prefs, 'project');
				$data['options'] = $api->get_projects();
				break;
				
			case 'area':
				if (isset($input['project']))
				{
					$data['default'] = arr::get($prefs, 'area');
					$data['options'] =
						$api->get_areas($input['project']);
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
		return $api->add_case($input);
	}
	
	// *********************************************************
	// LOOKUP
	// *********************************************************
	
	public function lookup($defect_id)
	{
		$api = $this->_get_api();

		$case = $api->get_case($defect_id);

		$status_id = GI_DEFECTS_STATUS_OPEN;
		if (str::to_lower($case['status']) == 'resolved')
		{
			$status_id = GI_DEFECTS_STATUS_RESOLVED;
		}

		return array(
			'id' => $defect_id,
			'url' => str::format(
				'http://example.com/?{0}',
				$defect_id
			),
			'title' => 
				$this->get_type() == GI_INTEGRATION_TYPE_DEFECTS ?
				GI_DEFECTS_SAMPLE_TITLE :
				GI_REFERENCES_SAMPLE_TITLE,
			'status_id' => $status_id,
			'status' => $case['status'],
			'description' => 
				str_replace(
					'{DEFECTS_PLUGINS}',
					lang('link_integration_defects_plugins'),
					$this->get_type() == GI_INTEGRATION_TYPE_DEFECTS ?
						GI_DEFECTS_SAMPLE_DESCRIPTION :
						GI_REFERENCES_SAMPLE_DESCRIPTION
				),
			'attributes' => array(
				'Project' => h($case['project']),
				'Area' => h($case['area']),
				'Priority' => h($case['priority'])
			)
		);
	}
}

class Sample_defect_api
{
	/**
	 * Get Projects
	 *
	 * Returns a list of sample projects.
	 */
	public function get_projects()
	{
		return array(
			'DH' => 'Datahub',
			'PR' => 'Presenter',
			'SP' => 'Spreadsheet',
			'WR' => 'Writer',
		);
	}

	/**
	 * Get Areas
	 *
	 * Returns a list of sample areas for the given project.
	 */
	public function get_areas($project_id)
	{
		return array(
			'1' => 'Administration',
			'2' => 'Feature 1',
			'3' => 'Feature 2',
			'4' => 'Feature 3',
			'5' => 'Installer',
			'6' => 'Search',
			'7' => 'Help & Documentation'
		);
	}

	/**
	 * Get Priorities
	 *
	 * Returns a list of sample priorities.
	 */
	public function get_priorities()
	{
		return array(
			'1' => 'Low',
			'2' => 'Normal',
			'3' => 'High',
			'4' => 'Critical'
		);
	}

	/**
	 * Get Case
	 *
	 * Returns a sample case.
	 */	 
	public function get_case($case_id)
	{
		$projects = $this->get_projects();
		$project = null;

		if (str::len($case_id) > 2)
		{
			$project = arr::get(
				$projects,
				str::sub($case_id, 0, 2) // Project key, e.g. 'DH'
			);
		}

		if (!$project)
		{
			$project = reset($projects);
		}

		return array(
			'title' => GI_DEFECTS_SAMPLE_TITLE,
			'description' => str_replace(
				'{DEFECTS_PLUGINS}',
				lang('link_integration_defects_plugins'),
				GI_DEFECTS_SAMPLE_DESCRIPTION
			),
			'id' => $case_id,
			'status' => rand(0, 2) ? 'Open' : 'Resolved',
			'project' => $project,
			'area' => 'Feature 1',
			'priority' => 'Normal'
		);
	}
	
	/**
	 * Add Case
	 *
	 * "Adds" a case and returns a random case ID.
	 */
	public function add_case($options)
	{
		$project_keys = array_keys($this->get_projects());
		
		return str::format(
			'{0}-{1}',
			$project_keys[rand(0, count($project_keys) - 1)],
			rand(1, 100)
		);
	}
}
