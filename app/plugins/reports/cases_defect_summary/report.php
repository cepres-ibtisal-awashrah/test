<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

/**
 * Cases Defect Summary report for TestRail
 *
 * Copyright Gurock Software GmbH. All rights reserved.
 *
 * This is the TestRail report for displaying the defect summary for
 * test cases in a coverage matrix.
 *
 * http://www.gurock.com/testrail/
 */

class Cases_defect_summary_report_plugin extends Report_plugin
{
	private $_controls;

	// The controls and options for those controls that are used on
	// the form of this report.
	private static $_control_schema = array(
		'runs_select' => array(
			'namespace' => 'custom_runs',
			'multiple_suites' => false
		),
		'runs_limit' => array(
			'type' => 'limits_select',
			'namespace' => 'custom_runs',
			'min' => 0,
			'max' => 100,
			'default' => 10
		),
		'cases_columns' => array(
			'type' => 'columns_select',
			'namespace' => 'custom_cases',
			'default' => array(
				'cases:id' => 75,
				'cases:title' => 0
			)
		),
		'cases_filter' => array(
			'namespace' => 'custom_cases',
		),
		'cases_limit' => array(
			'type' => 'limits_select',
			'namespace' => 'custom_cases',
			'min' => 0,
			'max' => 5000,
			'default' => 1000
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
				'custom_cases_include_comparison' => array(
					'type' => 'bool',
					'default' => false
				),
				'custom_cases_include_summary' => array(
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
				'cases_include_comparison' => true,
				'cases_include_summary' => true
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
		// comparison).
		if (!$input['custom_cases_include_summary'] &&
			!$input['custom_cases_include_comparison'])
		{
			$validation->add_error(
				lang('reports_cds_form_cases_required')
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
			'cases_include_comparison',
			'cases_include_summary'
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
		$project = $context['project'];

		$params = array(
			'controls' => $this->_controls,
			'project' => $project,
			'case_columns' => $context['case_columns']
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

		// Get the test suite first.
		$suite_id = $options['runs_suites_id'];
		$suite = $this->_helper->get_suite($suite_id);

		// Limit this report to specific test cases, if requested.
		// This is only relevant for single-suite projects and with a
		// section filter.
		$case_ids = $this->_helper->get_case_scope_by_include(
			array($suite_id),
			arr::get($options, 'runs_sections_ids'),
			arr::get($options, 'runs_sections_include'),
			$has_cases
		);

		// Then read the entire/filtered outline (sections and cases
		// tree).
		if ($has_cases)
		{
			$suite_outline = $this->_helper->get_suite_outline(
				$suite_id,
				$case_ids,
				$context['fields'],
				$options['cases_filters'],
				$options['cases_limit'],
				$case_count,
				$case_count_partial,
				$case_ids_out
			);

			$case_ids = $case_ids_out; // Use updated case list
		}
		else
		{
			$suite_outline = array();
			$case_ids = array();
			$case_count = 0;
			$case_count_partial = 0;
		}

		// We then read/compute (depending on the report options):
		// a) the actual list of test runs used in this report
		// b) the current/latest test results for the test cases (so
		// called coverage)
		// c) all test results for the selected test runs (so called
		// comparison)
		$runs = $this->_helper->get_runs_by_include(
			$project->id,
			array($suite_id),
			$options['runs_include'],
			$options['runs_ids'],
			$options['runs_filters'],
			null, // Active and completed
			$options['runs_limit'],
			$run_rels,
			$run_count
		);

		$run_ids = obj::get_ids($runs);

		$show_summary = $options['cases_include_summary'];
		if ($show_summary && $run_ids && $case_ids)
		{
			$defects_summary = 
				$this->_helper->get_defects_for_cases_summary(
					$run_ids,
					$case_ids
				);

			$results_latest = 
				$this->_helper->get_results_for_cases_latest(
					$run_ids,
					$case_ids
				);
		}
		else
		{
			$defects_summary = array();
			$results_latest = array();
		}

		$show_comparison = $options['cases_include_comparison'];
		if ($run_ids && $case_ids)
		{
			$defects = $this->_helper->get_defects_for_cases_many(
				$run_ids,
				$case_ids,
				$runs,
				$runs_with_defects,
				$runs_ignored_count
			);

			$run_count -= $runs_ignored_count; // Adjust run count
			$runs = $runs_with_defects;

			$results = array();
			if ($show_comparison)
			{
				foreach ($runs as $run)
				{
					$results[$run->id] = 
						$this->_helper->get_results_for_cases(
							$run->id,
							$case_ids
						);
				}
			}
		}
		else
		{
			$defects = array();
			$results = array();
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
					'suite' => $suite,
					'suite_outline' => $suite_outline,
					'case_columns' => $context['case_columns'],
					'case_columns_for_user' => 
						$options['cases_columns'],
					'case_fields' => $context['case_fields'],
					'case_count' => $case_count,
					'case_count_partial' => $case_count_partial,
					'case_ids' => $case_ids,
					'runs' => $runs,
					'run_rels' => $run_rels,
					'run_count' => $run_count,
					'run_limit' => $options['runs_limit'],
					'defects' => $defects,
					'defects_summary' => $defects_summary,
					'results' => $results,
					'results_latest' => $results_latest,
					'case_limit' => $options['cases_limit'],
					'show_comparison' => $show_comparison,
					'show_summary' => $show_summary,
					'show_links' => !$options['content_hide_links']
				)
			)
		);
	}
}
