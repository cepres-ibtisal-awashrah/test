<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

/**
 * Cases Property Groups report for TestRail
 *
 * Copyright Gurock Software GmbH. All rights reserved.
 *
 * This is the TestRail report for displaying the test cases within
 * a configurable scope, grouped by a configurable attribute.
 *
 * http://www.gurock.com/testrail/
 */

class Cases_property_groups_report_plugin extends Report_plugin
{
	private $_controls;

	// The controls and options for those controls that are used on
	// the form of this report.
	private static $_control_schema = array(
		'cases_grouping' => array(
			'type' => 'grouping_select',
			'namespace' => 'custom_cases',
			'default' => 'cases:priority_id'
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
				'cases:title' => 0
			)
		),
		'cases_filter' => array(
			'namespace' => 'custom_cases'
		),
		'cases_limit' => array(
			'type' => 'limits_select',
			'namespace' => 'custom_cases',
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
				'custom_cases_include_summary' => array(
					'type' => 'bool',
					'default' => false
				),
				'custom_cases_include_details' => array(
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
				'cases_include_summary' => true,
				'cases_include_details' => true
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
		if (!$input['custom_cases_include_summary'] &&
			!$input['custom_cases_include_details'])
		{
			$validation->add_error(
				lang('reports_cpg_form_cases_required')
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
			'cases_include_summary',
			'cases_include_details'
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

	private function _get_groupby($project_id, $case_columns, 
		$case_fields)
	{
		// We first add the built-in fields that are groupable.
		static $columns = array(
			'cases:created_by',
			'cases:milestone_id',
			'cases:priority_id',
			'cases:template_id',
			'cases:type_id'
		);

		if (!fields::has_for_cases($project_id, 'milestone_id'))
		{
			unset($columns['cases:milestone_id']);
		}

		$attributes = array();
		foreach ($columns as $key)
		{
			$label = arr::get($case_columns, $key);
			if ($label)
			{
				$attributes[$key] = $label;
			}
		}

		// And then add the custom fields that are groupable.
		foreach ($case_fields as $key => $field)
		{
			if ($field->is_groupable())
			{
				$key = 'cases:' .  $key;
				$label = arr::get($case_columns, $key);
				if ($label)
				{
					$attributes[$key] = $label;
				}
			}
		}

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
			'case_groupby' => $this->_get_groupby(
				$project->id,
				$context['case_columns'],
				$context['case_fields']
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

		$show_summary = $options['cases_include_summary'];
		$show_details = $options['cases_include_details'];

		if ($suite_ids && $has_cases)
		{
			$case_groups = $this->_helper->get_case_groups_ex(
				$suite_ids,
				$case_ids,
				$context['fields'],
				$options['cases_groupby'],
				$options['cases_filters']
			);

			$cases = array();
			if ($show_details)
			{
				foreach ($case_groups as $group)
				{
					$cases[$group->id] = 
						$this->_helper->get_cases_by_group_ex(
							$suite_ids,
							$case_ids,
							$context['fields'],
							$options['cases_groupby'],
							$group->id,
							$options['cases_filters'],
							$options['cases_limit']
						);
				}
			}
		}
		else
		{
			$cases = array();
			$case_groups = array();
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
					'cases' => $cases,
					'case_groups' => $case_groups,
					'case_groupby' => $options['cases_groupby'],
					'case_columns' => $context['case_columns'],
					'case_columns_for_user' => 
						$options['cases_columns'],
					'case_fields' => $context['case_fields'],
					'case_limit' => $options['cases_limit'],
					'show_summary' => $show_summary,
					'show_details' => $show_details,
					'show_links' => !$options['content_hide_links']
				)
			)
		);
	}
}
