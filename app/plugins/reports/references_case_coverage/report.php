<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

/**
 * Reference Case Coverage report for TestRail
 *
 * Copyright Gurock Software GmbH. All rights reserved.
 *
 * This is the TestRail report for displaying the test case coverage
 * for references in a coverage matrix.
 *
 * http://www.gurock.com/testrail/
 */

class References_case_coverage_report_plugin extends Report_plugin
{
	private $_model;
	private $_controls;

	// The controls and options for those controls that are used on
	// the form of this report.
	private static $_control_schema = array(
		'references_select' => array(
			'namespace' => 'custom_references'
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
		$this->_model = new References_case_coverage_model(
			$this->_helper);
		$this->_model->init();
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
				'custom_cases_include_refs' => array(
					'type' => 'bool',
					'default' => false
				),
				'custom_cases_include_norefs' => array(
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
				'cases_include_refs' => true,
				'cases_include_norefs' => true
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
		// At least one case option must be selected (references or
		// no-references).
		if (!$input['custom_cases_include_refs'] &&
			!$input['custom_cases_include_norefs'])
		{
			$validation->add_error(
				lang('reports_rcc_form_cases_required')
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
			'cases_include_refs',
			'cases_include_norefs'
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

		// Convert the reference ID text to an array of reference IDs.
		$references_ids_text = $options['references_ids'];
		if ($references_ids_text)
		{
			$references_ids = str::split_lines($references_ids_text);
		}
		else
		{
			$references_ids = array();
		}

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
		$section_include = arr::get($options, 'sections_include');

		$section_ids = null;
		if ($section_include == TP_REPORT_PLUGINS_SECTIONS_SELECTED)
		{
			$section_ids = $options['sections_ids'];
		}

		$case_ids = $this->_helper->get_case_scope_by_include(
			$suite_ids,
			$section_ids,
			$section_include,
			$has_cases
		);

		$case_limit = $options['cases_limit'];

		if ($suite_ids && $has_cases && $options['cases_include_refs'])
		{
			// And then get the references.
			$references = $this->_helper->get_references_ex(
				$suite_ids,
				$case_ids,
				$options['references_include'],
				$references_ids,
				$case_limit
			);
		}
		else
		{
			$references = null;
		}

		if ($suite_ids && $options['cases_include_norefs'])
		{
			$suite_lookup = obj::get_lookup(
				$this->_helper->get_suites_by_project($project->id)
			);

			// And then get the suites/cases without references.
			$noreferences = $this->_model->get_noreferences(
				$suite_ids,
				$suite_lookup,
				$section_ids,
				$case_limit
			);
		}
		else
		{
			$noreferences = null;
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
					'case_columns' => $context['case_columns'],
					'case_columns_for_user' => 
						$options['cases_columns'],
					'case_fields' => $context['case_fields'],
					'case_limit' => $case_limit,
					'references' => $references,
					'noreferences' => $noreferences,
					'show_links' => !$options['content_hide_links']
				)
			)
		);
	}
}

class References_case_coverage_model extends BaseModel
{
	private $_helper;

	public function __construct($helper)
	{
		parent::__construct(); // Required, initializes the model
		$this->_helper = $helper;
	}

	/**
	 * Get No-References
	 *
	 * Returns the data needed to display the no-references part in
	 * the report, i.e. a) the list of suites with sections/cases and
	 * some b) some suite/case count statistics.
	 */
	public function get_noreferences($suite_ids, $suite_lookup, 
		$section_ids, $limit)
	{
		$suite_count = count($suite_ids);
		$suite_count_partial = 0;
		$suites = array();
		$case_count_partial = 0;

		// Get the full content (section tree including cases) for all
		// requested suites.
		$left = $limit;
		$content = array();
		foreach ($suite_ids as $suite_id)
		{
			$suite = arr::get($suite_lookup, $suite_id);
			if (!$suite)
			{
				continue;
			}

			$suites[] = $suite;
			if ($limit && !$left)
			{
				// No cases left to display, so the remaining suites
				// are not included in the content, just in the
				// suite overview.
				continue;
			}

			$suite->content = $this->_get_noreferences_suite(
				$suite_id,
				$section_ids,
				$left,
				$case_count,
				$case_count_partial,
				$case_ids
			);

			$suite_count_partial++;
			$suite->case_ids = $case_ids;
			$suite->case_count = $case_count;
			$suite->case_count_partial = $case_count_partial;

			if ($suite->content)
			{
				// Only include test suites in the content that have
				// sections/cases.
				$content[] = $suite;
			}

			// Make sure to respect the given case limit, if any.
			if ($limit)
			{
				$left -= $case_count_partial;
			}
		}

		$r = obj::create();
		$r->content = $content;
		$r->suites = $suites;
		$r->suite_count = $suite_count;
		$r->suite_count_partial = $suite_count_partial;
		$r->case_count = $this->_get_noreferences_case_count(
			$suite_ids,
			$section_ids
		);

		return $r;
	}

	private function _get_noreferences_suite($suite_id, $section_ids,
		$limit, &$case_count, &$case_count_partial, &$case_ids)
	{
		$case_ids = $this->_get_noreferences_case_ids($suite_id,
			$section_ids);

		if ($case_ids)
		{
			$content = $this->_helper->get_suite_outline(
				$suite_id,
				$case_ids,
				null, // No fields needed
				null, // No property filter
				$limit,
				$case_count,
				$case_count_partial,
				$case_ids
			);
		}
		else
		{
			$content = array();
			$case_count = 0;
			$case_count_partial = 0;
		}

		return $content;
	}

	private function _get_noreferences_case_ids($suite_id,
		$section_ids)
	{
		$this->db->select('id');
		$this->db->from('cases');
		$this->db->where('suite_id', $suite_id);

		if ($section_ids)
		{
			$this->db->where_in('section_id', $section_ids);
		}

		$this->db->where_expr('refs IS NULL');
		return $this->db->get_fields('id');
	}

	private function _get_noreferences_case_count($suite_ids,
		$section_ids)
	{
		$this->db->from('cases');
		$this->db->where_in('suite_id', $suite_ids);

		if ($section_ids)
		{
			$this->db->where_in('section_id', $section_ids);
		}

		$this->db->where_expr('refs IS NULL');
		return $this->db->get_count();
	}
}
