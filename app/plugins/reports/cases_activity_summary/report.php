<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

/**
 * Cases Activity Summary report for TestRail
 *
 * Copyright Gurock Software GmbH. All rights reserved.
 *
 * This is the TestRail report for displaying new/updated test cases,
 * grouped by various attributes.
 *
 * http://www.gurock.com/testrail/
 */

class Cases_activity_summary_report_plugin extends Report_plugin
{
	private $_controls;

	// The controls and options for those controls that are used on
	// the form of this report.
	private static $_control_schema = array(
		'cases_grouping' => array(
			'type' => 'grouping_select',
			'namespace' => 'custom_cases',
			'default' => 'day'
		),
		'changes_daterange' => array(
			'type' => 'dateranges_select',
			'namespace' => 'custom_changes'
		),		
		'suites_select' => array(
			'namespace' => 'custom_suites'
		),
		'sections_select' => array(
			'namespace' => 'custom_sections'
		),		
		'cases_columns' => array(
			'type' => 'columns_select',
			'namespace' => 'custom_cases',
			'default' => array(
				'cases:id' => 75,
				'cases:title' => 0,
				'cases:created_by' => 125,
				'cases:updated_by' => 125
			)
		),
		'cases_filter' => array(
			'namespace' => 'custom_cases'
		),
		'cases_limit' => array(
			'type' => 'limits_select',
			'namespace' => 'custom_cases',
			'min' => 0,
			'max' => 5000,
			'default' => 1000
		),		
		'content_hide_links' => array(
			'namespace' => 'custom_content'
		)
	);

	// The resources to copy to the output directory when generating a
	// report.
	private static $_resources = array(
		'images/report-assets/suite16.svg',
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
				'custom_cases_include_new' => array(
					'type' => 'bool',
					'default' => false
				),
				'custom_cases_include_updated' => array(
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
				'cases_include_new' => true,
				'cases_include_updated' => true
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
		$project = $context['project'];

		// At least one case option must be selected (summary or
		// details).
		if (!$input['custom_cases_include_new'] &&
			!$input['custom_cases_include_updated'])
		{
			$validation->add_error(
				lang('reports_cas_form_cases_required')
			);

			return false;
		}

		$cases_groupby = $this->_get_groupby($project);
		if (!isset($cases_groupby[$input['custom_cases_groupby']]))
		{
			$validation->add_error(
				lang('reports_cas_form_cases_groupby_invalid')
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
			'cases_include_new',
			'cases_include_updated'
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

	private function _get_groupby($project)
	{
		$attributes = array(
			'day' => lang('reports_cas_form_cases_groupby_day'),
			'month' => lang('reports_cas_form_cases_groupby_month'),
			'suite' => 
				$project->suite_mode == TP_PROJECTS_SUITES_SINGLE ?
					lang('reports_cas_form_cases_groupby_cases') :
					lang('reports_cas_form_cases_groupby_suite')
		);

		asort($attributes);
		return $attributes;
	}

	public function render_form($context)
	{
		$project = $context['project'];

		$params = array(
			'controls' => $this->_controls,
			'project' => $project,
			'case_columns' => $context['case_columns'],
			'case_groupby' => $this->_get_groupby($project)
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

		// We read the test suites first.
		$suites = $this->_helper->get_suites_by_include(
			$project->id,
			$options['suites_ids'],
			$options['suites_include']
		);

		$suite_ids = obj::get_ids($suites);
		
		// Limit this report to specific test cases, if requested.
		// This is only relevant for single-suite projects and with a
		// section filter.
		$case_ids = $this->_helper->get_case_scope_by_include(
			$suite_ids,
			arr::get($options, 'sections_ids'),
			arr::get($options, 'sections_include'),
			$has_cases
		);

		// We then read the available groups in the scope and compute
		// the case counts for these groups. If we also display the
		// test cases we get a list of them for each group.

		$show_new = $options['cases_include_new'];
		$show_updated = $options['cases_include_updated'];

		$this->_helper->get_daterange_tofrom(
			$options['changes_daterange'],
			$options['changes_daterange_from'],
			$options['changes_daterange_to'],
			$changes_from,
			$changes_to
		);

		$cases_created = null;
		$cases_updated = null;

		if ($suite_ids && $has_cases)
		{
			if ($show_new)
			{
				$cases_created = 
					$this->_helper->get_case_changes_created(
						$suite_ids,
						$case_ids,
						$context['fields'],
						$options['cases_groupby'],
						$changes_from,
						$changes_to,
						$options['cases_filters'],
						$options['cases_limit']
					);
			}

			if ($show_updated)
			{
				$cases_updated =
					$this->_helper->get_case_changes_updated(
						$suite_ids,
						$case_ids,
						$context['fields'],
						$options['cases_groupby'],
						$changes_from,
						$changes_to,
						$options['cases_filters'],
						$options['cases_limit']
					);
			}
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
					'suites' => $suites,
					'case_groupby' => $options['cases_groupby'],
					'case_columns' => $context['case_columns'],
					'case_columns_for_user' => 
						$options['cases_columns'],
					'case_fields' => $context['case_fields'],
					'case_limit' => $options['cases_limit'],
					'cases_created' => $cases_created,
					'cases_updated' => $cases_updated,
					'changes_from' => $changes_from,
					'changes_to' => $changes_to,
					'show_new' => $show_new,
					'show_updated' => $show_updated,
					'show_links' => !$options['content_hide_links']
				)
			)
		);
	}
}
