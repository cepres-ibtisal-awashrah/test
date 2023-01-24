<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

/**
 * Projects Summary report for TestRail
 *
 * Copyright Gurock Software GmbH. All rights reserved.
 *
 * This is the TestRail report for displaying a summary/overview for
 * a project.
 *
 * http://www.gurock.com/testrail/
 */

class Projects_summary_report_plugin extends Report_plugin
{
	private $_controls;

	// The controls and options for those controls that are used on
	// the form of this report.
	private static $_control_schema = array(
		'milestones_completed_limit' => array(
			'type' => 'limits_select',
			'namespace' => 'custom_milestones_completed',
			'min' => 0,
			'max' => 25,
			'default' => 10
		),
		'runs_completed_limit' => array(
			'type' => 'limits_select',
			'namespace' => 'custom_runs_completed',
			'min' => 0,
			'max' => 100,
			'default' => 10
		),
		'history_daterange' => array(
			'type' => 'dateranges_select',
			'namespace' => 'custom_history',
			'min' => 0,
			'max' => 1000,
			'default' => 100
		),
		'history_limit' => array(
			'type' => 'limits_select',
			'namespace' => 'custom_history',
			'min' => 0,
			'max' => 1000,
			'default' => 100
		),
		'activities_daterange' => array(
			'type' => 'dateranges_select',
			'namespace' => 'custom_activities'
		),
		'activities_statuses' => array(
			'type' => 'statuses_select',
			'namespace' => 'custom_activities_statuses',
		),
		'activities_limit' => array(
			'type' => 'limits_select',
			'namespace' => 'custom_activities',
			'min' => 0,
			'max' => 1000,
			'default' => 100
		),
		'content_hide_links' => array(
			'namespace' => 'custom_content',
		)
	);

	// The resources to copy to the output directory when generating a
	// report.
	private static $_resources = array(
		'images/report-assets/milestone16.svg',
		'images/report-assets/plan16.svg',
		'images/report-assets/run16.svg',
		'images/report-assets/help.svg',
		'js/jquery.js',
		'js/fusioncharts.js',
		'js/fusioncharts.charts.js',
		'js/fusioncharts.theme.fusion.js',
		'styles/font.css',
		'styles/print.css',
		'styles/reset.css',
		'styles/view.css',
		'font/Barlow-Regular.ttf',
		'font/Barlow-Italic.ttf',
		'font/Barlow-Medium.ttf',
		'font/Barlow-MediumItalic.ttf',
		'font/Barlow-SemiBold.ttf',
		'font/Barlow-SemiBoldItalic.ttf',
		'font/Barlow-Bold.ttf',
		'font/Barlow-BoldItalic.ttf'
	);

	public function __construct()
	{
		parent::__construct();
		$this->_controls = $this->create_controls(
			self::$_control_schema
		);
	}

	public function prepare_form($context, $validation)
	{
		// Assign the validation rules for the controls used on the
		// form.
		$this->prepare_controls($this->_controls, $context, 
			$validation);

		// Assign the validation rules for the fields on the form
		// that are not covered by the controls and are specific to
		// this report.
		$validation->add_rules(
			array(
				'custom_milestones_active_include' => array(
					'type' => 'bool',
					'default' => false
				),
				'custom_milestones_completed_include' => array(
					'type' => 'bool',
					'default' => false
				),
				'custom_runs_active_include' => array(
					'type' => 'bool',
					'default' => false
				),
				'custom_runs_completed_include' => array(
					'type' => 'bool',
					'default' => false
				),
				'custom_activities_include' => array(
					'type' => 'bool',
					'default' => false
				),
				'custom_history_include' => array(
					'type' => 'bool',
					'default' => false
				)
			)
		);

		if (request::is_post())
		{
			return;
		}

		// We assign the default values for the form depending on the
		// event. For 'add', we use the default values of this plugin.
		// For 'edit/rerun', we use the previously saved values of
		// the report/report job to initialize the form. Please note
		// that we prefix all fields in the form with 'custom_' and
		// that the storage format omits this prefix (validate_form).

		if ($context['event'] == 'add')
		{
			$defaults = array(
				'milestones_active_include' => true,
				'milestones_completed_include' => false,
				'runs_active_include' => true,
				'runs_completed_include' => false,
				'activities_include' => true,
				'history_include' => true
			);
		}
		else
		{
			$defaults = $context['custom_options'];
		}

		foreach ($defaults as $field => $value)
		{
			$validation->set_default('custom_' . $field, $value);
		}
	}

	public function validate_form($context, $input, $validation)
	{
		// We begin with validating the controls used on the form.
		$values = $this->validate_controls(
			$this->_controls,
			$context,
			$input,
			$validation);

		if (!$values)
		{
			return false;
		}

		static $fields = array(
			'milestones_active_include',
			'milestones_completed_include',
			'runs_active_include',
			'runs_completed_include',
			'activities_include',
			'history_include'
		);

		// And then add our fields from the form input that are not
		// covered by the controls and return the data as it should be
		// stored in the report options.
		foreach ($fields as $field)
		{
			$key = 'custom_' . $field;
			$values[$field] = arr::get($input, $key);
		}

		return $values;
	}

	public function render_form($context)
	{
		$params = array(
			'controls' => $this->_controls,
			'project' => $context['project']
		);

		return array(
			'form' => $this->render_view(
				'form',
				$params,
				true
			)
		);
	}

	public function run($context, $options)
	{
		$project = $context['project'];

		// We begin with reading the active and completed milestones
		// for the project.
		$milestones_active_include = 
			$options['milestones_active_include'];
		if ($milestones_active_include)
		{
			$milestones_active = 
				$this->_helper->get_milestones_by_filter(
					$project->id,
					null,  // No filter
					false, // Active only
					null,  // No limit,
					$milestones_active_count
				);
		}
		else 
		{
			$milestones_active = array();
			$milestones_active_count = 0;
		}

		$milestones_completed_include = 
			$options['milestones_completed_include'];
		if ($milestones_completed_include)
		{
			$milestones_completed =
				$this->_helper->get_milestones_by_filter(
					$project->id,
					null, // No filter
					true, // Completed only
					$options['milestones_completed_limit'],
					$milestones_completed_count
				);
		}
		else
		{
			$milestones_completed = array();
			$milestones_completed_count = 0;
		}

		$milestone_ids = array_merge(
			obj::get_ids($milestones_active),
			obj::get_ids($milestones_completed)
		);

		if ($milestone_ids)
		{
			// Get the statistics for the milestones we've just read.
			// In contrast to runs/plans, the stats are not part of
			// the milestone object/row.
			$milestone_stats = $this->_helper->get_milestone_stats(
				$milestone_ids);			
		}
		else
		{
			$milestone_stats = array();
		}

		$runs_active_include = $options['runs_active_include'];
		if ($runs_active_include)
		{
			$runs_active = 
				$this->_helper->get_runs_and_plans_by_filter(
					$project->id,
					null,  // No filter
					false, // Active only
					null,  // No limit
					$runs_active_rels,
					$runs_active_count
				);
		}
		else 
		{
			$runs_active = array();
			$runs_active_rels = array();
			$runs_active_count = 0;
		}

		$runs_completed_include = $options['runs_completed_include'];
		if ($runs_completed_include)
		{
			$runs_completed = 
				$this->_helper->get_runs_and_plans_by_filter(
					$project->id,
					null, // No filter
					true, // Completed
					$options['runs_completed_limit'],
					$runs_completed_rels,
					$runs_completed_count
				);
		}
		else 
		{
			$runs_completed = array();
			$runs_completed_rels = array();
			$runs_completed_count = 0;
		}

		$activities_include = $options['activities_include'];
		$activities_limit = $options['activities_limit'];

		if ($activities_include)
		{
			$this->_helper->get_daterange_tofrom(
				$options['activities_daterange'],
				$options['activities_daterange_from'],
				$options['activities_daterange_to'],
				$activities_from,
				$activities_to
			);

			$activity = $this->_helper->get_activity_by_project(
				$project,
				$activities_from,
				$activities_to
			);

			// Get the statuses for the status filter, if any. If we
			// include all statuses, we can ignore this.
			if ($options['activities_statuses_include'] == 
				TP_REPORT_PLUGINS_STATUSES_ALL)
			{
				$activities_status_ids = null;	
			}
			else
			{
				$activities_status_ids = obj::get_ids(
					$this->_helper->get_statuses(
						$options['activities_statuses_ids']
					)
				);
			}

			$activities = $this->_helper->get_activities_by_project(
				$project,
				$activities_from,
				$activities_to,
				$activities_status_ids,
				$activities_limit,
				$activities_rels
			);
		}
		else 
		{
			$activity = null;
			$activities = array();
			$activities_rels = array();
			$activities_from = null;
			$activities_to = null;
		}

		$history_include = $options['history_include'];
		$history_limit = $options['history_limit'];

		if ($history_include)
		{
			$this->_helper->get_daterange_tofrom(
				$options['history_daterange'],
				$options['history_daterange_from'],
				$options['history_daterange_to'],
				$history_from,
				$history_to
			);

			$history = $this->_helper->get_history_by_project(
				$project->id,
				$history_from,
				$history_to,
				$history_limit,
				$history_rels
			);
		}
		else 
		{
			$history = array();	
			$history_rels = array();
		}

		return array(
			'resources' => self::$_resources,
			'html_file' => $this->render_page(
				'index',
				array(
					'report' => $context['report'],
					'project' => $project,
					'milestones_active_include' => 
						$milestones_active_include,
					'milestones_active' => $milestones_active,
					'milestones_completed_include' => 
						$milestones_completed_include,
					'milestones_completed' => $milestones_completed,
					'milestones_completed_count' => 
						$milestones_completed_count,
					'milestone_stats' => $milestone_stats,
					'runs_active_include' => $runs_active_include,
					'runs_active' => $runs_active,
					'runs_active_rels' => $runs_active_rels,
					'runs_active_count' => $runs_active_count,
					'runs_completed_include' => 
						$runs_completed_include,
					'runs_completed' => $runs_completed,
					'runs_completed_rels' => $runs_completed_rels,
					'runs_completed_count' => $runs_completed_count,
					'activities_include' => $activities_include,
					'activity' => $activity,
					'activities' => $activities,
					'activities_rels' => $activities_rels,
					'activities_from' => $activities_from,
					'activities_to' => $activities_to,
					'activities_limit' => $activities_limit,
					'history' => $history,
					'history_rels' => $history_rels,
					'history_limit' => $history_limit,
					'history_include' => $history_include,
					'show_links' => !$options['content_hide_links']
				)
			)
		);
	}
}
