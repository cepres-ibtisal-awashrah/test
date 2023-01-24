<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

/**
 * Tests Property Groups report for TestRail
 *
 * Copyright Gurock Software GmbH. All rights reserved.
 *
 * This is the TestRail report for displaying tests within a specific
 * scope, grouped by a configurable attribute.
 *
 * http://www.gurock.com/testrail/
 */

class Tests_property_groups_report_plugin extends Report_plugin
{
	private $_controls;

	// The controls and options for those controls that are used on
	// the form of this report.
	private static $_control_schema = array(
		'tests_grouping' => array(
			'type' => 'grouping_select',
			'namespace' => 'custom_tests',
			'default' => 'tests:status_id'
		),
		'runs_select' => array(
			'namespace' => 'custom_runs',
			'multiple_suites' => true
		),
		'runs_limit' => array(
			'type' => 'limits_select',
			'namespace' => 'custom_runs',
			'min' => 0,
			'max' => 100,
			'default' => 10
		),
		'tests_columns' => array(
			'type' => 'columns_select',
			'namespace' => 'custom_tests',
			'default' => array(
				'tests:id' => 75,
				'cases:title' => 0
			)
		),
		'tests_filter' => array(
			'namespace' => 'custom_tests'
		),
		'tests_limit' => array(
			'type' => 'limits_select',
			'namespace' => 'custom_tests',
			'min' => 0,
			'max' => 1000,
			'default' => 25
		),
		'content_hide_links' => array(
			'namespace' => 'custom_content',
		)
	);

	// The resources to copy to the output directory when generating a
	// report.
	private static $_resources = array(
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
				'custom_tests_include_summary' => array(
					'type' => 'bool',
					'default' => false
				),
				'custom_tests_include_details' => array(
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
				'tests_include_summary' => true,
				'tests_include_details' => true
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
		// At least one case option must be selected (summary or
		// details).
		if (!$input['custom_tests_include_summary'] &&
			!$input['custom_tests_include_details'])
		{
			$validation->add_error(
				lang('reports_tpg_form_tests_required')
			);

			return false;
		}

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
			'tests_include_summary',
			'tests_include_details'
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

	private function _get_groupby($project_id, $test_columns, 
		$case_fields)
	{
		// We first add the built-in fields that are groupable.
		static $columns = array(
			'cases:milestone_id',
			'cases:priority_id',
			'cases:template_id',
			'cases:type_id',
			'tests:assignedto_id',
			'tests:tested_by'
		);

		if (!fields::has_for_cases($project_id, 'milestone_id'))
		{
			unset($columns['cases:milestone_id']);
		}

		$attributes = array();
		foreach ($columns as $key)
		{
			$label = arr::get($test_columns, $key);
			if ($label)
			{
				$attributes[$key] = $label;
			}
		}

		// Also add the case custom fields that are groupable. Note
		// that we can't add the test custom fields because those
		// fields are not groupable (as there can be multiple values
		// per test because they are linked to the test results, not
		// directly to the tests).
		foreach ($case_fields as $key => $field)
		{
			if ($field->is_groupable())
			{
				$key = 'cases:' .  $key;
				$label = arr::get($test_columns, $key);
				if ($label)
				{
					$attributes[$key] = $label;
				}
			}
		}

		// The status ID is a special column that is not part of the
		// standard test columns and needs to be added separately.
		$attributes['tests:status_id'] = lang('tests_status');

		asort($attributes);
		return $attributes;
	}

	public function render_form($context)
	{
		$project = $context['project'];

		$params = array(
			'controls' => $this->_controls,
			'project' => $project,
			'test_columns' => $context['test_columns'],
			'test_groupby' => $this->_get_groupby(
				$project->id,
				$context['test_columns'],
				$context['case_fields'] // sic!
			)
		);

		// Note that we return separate HTML snippets for the form/
		// options and the used dialogs (which must be included after
		// the actual form as they include their own <form> tags).
		return array(
			'form' => $this->render_view(
				'form',
				$params,
				true
			),
			'after_form' => $this->render_view(
				'form_dialogs',
				$params,
				true
			)
		);
	}

	public function run($context, $options)
	{
		$project = $context['project'];

		// Read the test suites first.
		$suites = $this->_helper->get_suites_by_include(
			$project->id,
			$options['runs_suites_ids'],
			$options['runs_suites_include']
		);

		$suite_ids = obj::get_ids($suites);

		// Limit this report to specific test cases, if requested.
		// This is only relevant for single-suite projects and with a
		// section filter.
		$case_ids = $this->_helper->get_case_scope_by_include(
			$suite_ids,
			arr::get($options, 'runs_sections_ids'),
			arr::get($options, 'runs_sections_include'),
			$has_cases
		);

		// We then get the actual list of test runs used, depending on
		// the report options.
		if ($suite_ids)
		{
			$runs = $this->_helper->get_runs_by_include(
				$project->id,
				$suite_ids,
				$options['runs_include'],
				$options['runs_ids'],
				$options['runs_filters'],
				null, // Active and completed
				$options['runs_limit'],
				$run_rels,
				$run_count
			);
		}
		else
		{
			$runs = array();
			$run_rels = array();
			$run_count = 0;
		}

		$run_ids = obj::get_ids($runs);

		$show_summary = $options['tests_include_summary'];
		$show_details = $options['tests_include_details'];

		// We then read the available groups in the scope and compute
		// the test counts for these groups. If we also display the
		// tests we get a list of them for each group.
		if ($run_ids && $has_cases)
		{
			$test_groups = $this->_helper->get_test_groups_ex(
				$run_ids,
				$case_ids,
				$context['fields'],
				$options['tests_groupby'],
				$options['tests_filters']
			);

			$tests = array();
			if ($show_details)
			{
				foreach ($test_groups as $group)
				{
					$tests[$group->id] = 
						$this->_helper->get_tests_by_group_ex(
							$run_ids,
							$case_ids,
							$context['fields'],
							$options['tests_groupby'],
							$group->id,
							$options['tests_filters'],
							$options['tests_limit']
						);
				}
			}
		}
		else
		{
			$tests = array();
			$test_groups = array();
		}

		// Render the report to a temporary file and return the path
		// to TestRail (including additional resources that need to be
		// copied).
		return array(
			'resources' => self::$_resources,
			'html_file' => $this->render_page(
				'index',
				array(
					'report' => $context['report'],
					'project' => $project,
					'runs' => $runs,
					'run_rels' => $run_rels,
					'run_count' => $run_count,
					'test_groups' => $test_groups,
					'tests' => $tests,
					'test_groupby' => $options['tests_groupby'],
					'test_columns' => $context['test_columns'],
					'test_columns_for_user' => 
						$options['tests_columns'],
					'test_fields' => $context['test_fields'],
					'test_limit' => $options['tests_limit'],
					'case_fields' => $context['case_fields'],
					'show_summary' => $show_summary,
					'show_details' => $show_details,
					'show_links' => !$options['content_hide_links']
				)
			)
		);
	}
}
