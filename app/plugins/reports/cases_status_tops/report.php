<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

/**
 * Case Status Tops report for TestRail
 *
 * Copyright Gurock Software GmbH. All rights reserved.
 *
 * This is the TestRail report for displaying the most failed/passed
 * etc. test cases.
 *
 * http://www.gurock.com/testrail/
 */

class Cases_status_tops_report_plugin extends Report_plugin
{
	private $_model;
	private $_controls;

	// The controls and options for those controls that are used on
	// the form of this report.
	private static $_control_schema = array(
		'statuses_select' => array(
			'namespace' => 'custom_statuses'
		),
		'results_select' => array(
			'namespace' => 'custom_results'
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
		'images/report-assets/run16.svg',
		'images/report-assets/help.svg',
		'js/fusioncharts.js',
		'js/fusioncharts.charts.js',
		'js/fusioncharts.theme.fusion.js',
		'js/jquery.js',
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
		$this->_model = new Cases_status_tops_model();
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
			$defaults = array();
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
		// All fields on the form are covered by controls, so we just
		// need to validate the controls.
		return $this->validate_controls(
			$this->_controls,
			$context,
			$input,
			$validation);
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

		// Get the statuses first, depending on the report options.
		$statuses = $this->_helper->get_statuses_by_include(
			$options['statuses_ids'],
			$options['statuses_include']
		);

		$status_ids = obj::get_ids($statuses);

		// Then read the test suites.
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

		// And finally read the tops and status counts (note that we
		// differentiate between all and the latest test results per
		// test, ie. all test changes and the current status only).		
		$results_include = $options['results_include'];
		$tops = array();
		$case_count = 0;
		$case_count_partial = 0;
		foreach ($status_ids as $status_id)
		{
			if ($run_ids && $has_cases)
			{
				if ($results_include == TP_REPORT_PLUGINS_RESULTS_ALL)
				{
					$items = $this->_model->get_tops(
						$status_id,
						$run_ids,
						$case_ids,
						$options['cases_limit'],
						$case_count,
						$case_count_partial
					);
				}
				else 
				{
					$items = $this->_model->get_tops_latest(
						$status_id,
						$run_ids,
						$case_ids,
						$options['cases_limit'],
						$case_count,
						$case_count_partial
					);
				}
			}
			else
			{
				$items = array();
				$case_count = 0;
				$case_count_partial = 0;
			}

			if (count($items) > 0) {
				$case_count = array_sum($items);
				$case_count_partial = $case_count;
			}
			
			$tops[$status_id] = array(
				'items' => $items,
				'case_count' => $case_count,
				'case_count_partial' => $case_count_partial,
			);
		}

		if ($run_ids && $has_cases)
		{			
			if ($results_include == TP_REPORT_PLUGINS_RESULTS_ALL)
			{
				$status_totals = $this->_model->get_status_totals(
					$status_ids,
					$run_ids,
					$case_ids
				);

				$case_totals = $this->_model->get_case_totals(
					$run_ids,
					$case_ids
				);
			}
			else 
			{
				$status_totals = $this->_model->get_status_totals_latest(
					$status_ids,
					$run_ids,
					$case_ids
				);

				$case_totals = $this->_model->get_case_totals_latest(
					$run_ids,
					$case_ids
				);
			}
		}
		else 
		{
			$status_totals = array();
			$case_totals = array();
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
					'runs' => $runs,
					'run_rels' => $run_rels,
					'run_count' => $run_count,
					'statuses' => $statuses,
					'tops' => $tops,
					'status_totals' => $status_totals,
					'case_columns' => $context['case_columns'],
					'case_columns_for_user' => 
						$options['cases_columns'],
					'case_totals' => $case_totals,
					'case_fields' => $context['case_fields'],
					'results_include' => $results_include,
					'show_links' => !$options['content_hide_links']
				)
			)
		);
	}
}

class Cases_status_tops_model extends BaseModel
{
	/**
	 * Get Case Totals
	 *
	 * Returns the total counts for the test cases in the given test
	 * runs, grouped by case IDs. This method takes into account all
	 * test results (per test). Also see get_case_totals_latest for a
	 * variant that looks at the latest results per test only (current
	 * status).
	 */
	public function get_case_totals($run_ids, $case_ids)
	{
		$sql = 
			'SELECT 
				case_id,
				COUNT(*) AS case_counts
			FROM
				tests
			JOIN
				test_changes
					ON
				test_changes.test_id = tests.id
			WHERE
				tests.run_id IN ({0}) AND
				%{cases} AND
				tests.is_selected = 1
			GROUP BY
				case_id';

		// Dynamically inject the case filter, if any.
		$query = $this->db->query(
			$this->_inject_case_filter($sql, $case_ids),
			$run_ids
		);

		$items = $query->result();

		return obj::get_lookup_scalar(
			$items, 
			'case_id', 
			'case_counts');
	}

	private function _inject_case_filter($sql, $case_ids)
	{
		$expr = null;

		if ($case_ids)
		{
			$expr = str::format(
				'tests.case_id IN ({0})',
				$this->db->quote_value($case_ids)
			);
		}
		else
		{
			$expr = '(1 = 1)'; // Replace with a TRUE expression
		}

		return str::formatn(
			$sql, 
			array(
				'cases' => $expr
			)
		);
	}

	public function get_case_totals_latest($run_ids, $case_ids)
	{
		$sql = 
			'SELECT 
				case_id,
				COUNT(*) AS case_counts
			FROM
				tests
			WHERE
				run_id IN ({0}) AND
				%{cases} AND
				is_selected = 1
			GROUP BY
				case_id';

		// Dynamically inject the case filter, if any.
		$query = $this->db->query(
			$this->_inject_case_filter($sql, $case_ids),
			$run_ids
		);

		$items = $query->result();

		return obj::get_lookup_scalar(
			$items, 
			'case_id', 
			'case_counts');
	}

	/**
	 * Get Status Totals
	 *
	 * Returns the total counts of results for the given statuses and
	 * run IDs, grouped by status ID. This method takes into account
	 * all test results (per test). Also see get_status_totals_latest
	 * for a variant that looks at the latest results per test only
	 * (current status).
	 */
	public function get_status_totals($status_ids, $run_ids, $case_ids)
	{
		$sql = 
			'SELECT
				test_changes.status_id,
				COUNT(*) AS status_count
			FROM
				tests
			JOIN
				test_changes
					ON
				test_changes.test_id = tests.id
			WHERE
				tests.run_id IN ({1}) AND
				%{cases} AND
				tests.is_selected = 1 AND
				test_changes.status_id in ({0})
			GROUP BY
				test_changes.status_id';

		// Dynamically inject the case filter, if any.
		$query = $this->db->query(
			$this->_inject_case_filter($sql, $case_ids),
			$status_ids,
			$run_ids
		);

		$totals = $query->result();

		$sql =
			'SELECT
				tests.status_id,
				COUNT(*) AS status_count
			FROM
				tests
			WHERE
				tests.run_id IN ({0}) AND
				%{cases} AND
				tests.is_selected = 1 AND
				tests.status_id = {1}
			GROUP BY
				tests.status_id';

		// Dynamically inject the case filter, if any.
		$query = $this->db->query(
			$this->_inject_case_filter($sql, $case_ids),
			$run_ids,
			TP_TEST_STATUS_UNTESTED
		);

		$totals = array_merge($totals, $query->result());

		return obj::get_lookup_scalar(
			$totals,
			'status_id',
			'status_count'
		);
	}

	public function get_status_totals_latest($status_ids, $run_ids,
		$case_ids)
	{
		$sql = 
			'SELECT
				status_id,
				COUNT(*) AS status_count
			FROM
				tests
			WHERE
				run_id IN ({1}) AND
				%{cases} AND
				is_selected = 1 AND
				status_id in ({0})
			GROUP BY
				status_id';

		// Dynamically inject the case filter, if any.
		$query = $this->db->query(
			$this->_inject_case_filter($sql, $case_ids),
			$status_ids,
			$run_ids
		);

		$totals = $query->result();

		return obj::get_lookup_scalar(
			$totals,
			'status_id',
			'status_count'
		);
	}

	/**
	 * Get Tops
	 *
	 * Gets the test cases included in the given test runs with the
	 * highest amount of test results with the given test status, for
	 * the given limit. This method takes into account all test
	 * results (per test). Also see get_tops_latest for a method that
	 * looks at the latest results per test only (current status). The
	 * result is returned as a lookup table (case ID -> status count).
	 */
	public function get_tops($status_id, $run_ids, $case_ids, $limit,
		&$case_count, &$case_count_partial)
	{
		$sql = null;

		switch ($this->db->get_driver_name())
		{
			// We need to use different queries because of the LIMIT
			// handling (TOP in SQL Server).
			case 'mysql':
				$sql =
					'SELECT
						case_id,
						COUNT(*) AS status_count
					FROM
						tests
					LEFT JOIN
						test_changes
							ON
						test_changes.test_id = tests.id
					WHERE
						tests.run_id IN ({1}) AND
						%{cases} AND
						tests.status_id = '.$status_id.' AND
						tests.is_selected = 1 AND
						(test_changes.status_id = {0} OR test_changes.status_id IS NULL)
					GROUP BY
						case_id
					ORDER BY
						status_count DESC,
						case_id
					LIMIT
						{2}';
				break;

			case 'sqlsrv':
				$sql =
					'SELECT TOP {2}
						case_id,
						COUNT(*) AS status_count
					FROM
						tests
					LEFT JOIN
						test_changes
							ON
						test_changes.test_id = tests.id
					WHERE
						tests.run_id IN ({1}) AND
						%{cases} AND
						tests.status_id = '.$status_id.' AND
						tests.is_selected = 1 AND
						(test_changes.status_id = {0} OR test_changes.status_id IS NULL)
					GROUP BY
						case_id
					ORDER BY
						status_count DESC,
						case_id';
				break;
		}

		if (!$sql)
		{
			return array();
		}

		// Dynamically inject the case filter, if any.
		$query = $this->db->query(
			$this->_inject_case_filter($sql, $case_ids),
			$status_id,
			$run_ids,
			$limit
		);

		$tops = $query->result();
		$case_count_partial = count($tops);
		$case_count = $this->_get_tops_count(
			$status_id, 
			$run_ids,
			$case_ids);

		return obj::get_lookup_scalar(
			$tops,
			'case_id',
			'status_count'
		);
	}

	private function _get_tops_count($status_id, $run_ids, $case_ids)
	{
		$sql = 
			'SELECT 
				COUNT(DISTINCT case_id) AS case_count
			FROM
				tests
			JOIN
				test_changes
					ON
				test_changes.test_id = tests.id
			WHERE
				tests.run_id IN ({1}) AND
				%{cases} AND
				tests.is_selected = 1 AND
				test_changes.status_id = {0}';

		// Dynamically inject the case filter, if any.
		$query = $this->db->query(
			$this->_inject_case_filter($sql, $case_ids),
			$status_id,
			$run_ids
		);

		return $query->scalar('case_count');
	}

	/**
	 * Get Tops (Latest)
	 *
	 * Gets the test cases included in the given test runs with the
	 * highest amount of test results with the given test status, for
	 * the given limit. This takes into account only the latest test
	 * results per test (ie. the current status per test). The result
	 * is returned as a lookup table (case ID -> status count).
	 */
	public function get_tops_latest($status_id, $run_ids, $case_ids,
		$limit, &$case_count, &$case_count_partial)
	{
		$sql = null;

		switch ($this->db->get_driver_name())
		{
			// We need to use different queries because of the LIMIT
			// handling (TOP in SQL Server).
			case 'mysql':
				$sql =
					'SELECT
						case_id,
						COUNT(*) AS status_count
					FROM
						tests
					WHERE
						run_id IN ({1}) AND
						%{cases} AND
						is_selected = 1 AND
						status_id = {0}
					GROUP BY
						case_id
					ORDER BY
						status_count DESC,
						case_id
					LIMIT
						{2}';
				break;

			case 'sqlsrv':
				$sql =
					'SELECT TOP {2}
						case_id,
						COUNT(*) AS status_count
					FROM
						tests
					WHERE
						run_id IN ({1}) AND
						%{cases} AND
						is_selected = 1 AND
						status_id = {0}
					GROUP BY
						case_id
					ORDER BY
						status_count DESC,
						case_id';
				break;
		}

		if (!$sql)
		{
			return array();
		}

		// Dynamically inject the case filter, if any.
		$query = $this->db->query(
			$this->_inject_case_filter($sql, $case_ids),
			$status_id,
			$run_ids,
			$limit
		);

		$tops = $query->result();
		$case_count_partial = count($tops);
		$case_count = $this->_get_tops_count_latest(
			$status_id,
			$run_ids,
			$case_ids
		);

		return obj::get_lookup_scalar(
			$tops,
			'case_id',
			'status_count'
		);
	}

	private function _get_tops_count_latest($status_id, $run_ids,
		$case_ids)
	{
		$sql = 
			'SELECT 
				COUNT(DISTINCT case_id) AS case_count
			FROM
				tests
			WHERE
				run_id IN ({1}) AND
				%{cases} AND
				is_selected = 1 AND
				status_id = {0}';

		// Dynamically inject the case filter, if any.
		$query = $this->db->query(
			$this->_inject_case_filter($sql, $case_ids),
			$status_id,
			$run_ids
		);

		return $query->scalar('case_count');
	}
}
