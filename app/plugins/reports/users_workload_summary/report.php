<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

/**
 * Users Workload Summary report for TestRail
 *
 * Copyright Gurock Software GmbH. All rights reserved.
 *
 * This is the TestRail report for displaying the worload summary for
 * users.
 *
 * http://www.gurock.com/testrail/
 */

class Users_workload_summary_report_plugin extends Report_plugin
{
	private $_model;
	private $_controls;

	// The controls and options for those controls that are used on
	// the form of this report.
	private static $_control_schema = array(
		'users_select' => array(
			'namespace' => 'custom_users'
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
		$this->_model = new Users_workload_summary_model();
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
				lang('reports_uws_form_tests_required')
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

	public function render_form($context)
	{
		$project = $context['project'];

		$params = array(
			'controls' => $this->_controls,
			'project' => $project,
			'test_columns' => $context['test_columns']
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

		// Get the users first, depending on the report options.
		$users = $this->_helper->get_users_by_include(
			$options['users_ids'],
			$options['users_include']
		);

		$user_ids = obj::get_ids($users);

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
				false, // Active runs only
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

		// Compute the estimate/forecast averages for the suites/runs
		// that are part of this report. These are used as fallbacks
		// for those cases/tests that don't have an own estimate and/
		// or forecast.
		$run_estimates = array();
		$suite_estimates = array();

		foreach ($runs as $run)
		{
			$estimate = arr::get($suite_estimates, $run->content_id);

			if (!$estimate)
			{
				$estimate = $this->_helper->get_suite_estimate(
					$run->content_id);
				$suite_estimates[$run->content_id] = $estimate;
			}

			$run_estimates[$run->id] = $estimate;
		}

		$test_limit = $options['tests_limit'];
		$show_summary = $options['tests_include_summary'];
		$show_details = $options['tests_include_details'];

		// And then finally read the todos and aggregated stats for
		// each user.
		$user_todos = array();
		$user_estimates = array();
		if ($user_ids && $run_ids && $has_cases)
		{
			foreach ($user_ids as $user_id)
			{
				if ($show_details)
				{
					$todos = $this->_model->get_todos(
						$run_ids,
						$case_ids,
						$user_id,
						$context['fields'],
						$options['tests_filters'],
						$test_limit,
						$todo_count,
						$todo_count_partial
					);

					$t = obj::create();
					$t->todos = $todos;
					$t->todo_count = $todo_count;
					$t->todo_count_partial = $todo_count_partial;

					$user_todos[$user_id] = $t;
				}

				if ($show_summary)
				{
					$e = $this->_model->get_estimates(
						$run_ids,
						$case_ids,
						$user_id,
						$suite_estimates,
						$context['fields'],
						$options['tests_filters']
					);

					if ($e)
					{
						$user_estimates[$user_id] = $e;
					}
				}
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
					'runs' => $runs,
					'run_rels' => $run_rels,
					'run_count' => $run_count,
					'test_columns' => $context['test_columns'],
					'test_columns_for_user' => 
						$options['tests_columns'],
					'test_fields' => $context['test_fields'],
					'test_limit' => $test_limit,
					'case_fields' => $context['case_fields'],
					'users' => $users,
					'user_todos' => $user_todos,
					'user_estimates' => $user_estimates,
					'show_summary' => $show_summary,
					'show_details' => $show_details,
					'show_links' => !$options['content_hide_links']
				)
			)
		);
	}
}

class Users_workload_summary_model extends BaseModel
{
	/**
	 * Get Todos
	 *
	 * Gets the test/todo IDs for the given test runs and user ID,
	 * grouped by test run.
	 */
	public function get_todos($run_ids, $case_ids, $user_id, $fields,
		$filters, $limit, &$todo_count, &$todo_count_partial)
	{
		$this->db->select('tests.id');
		$this->db->select('tests.run_id');
		$this->db->from('tests');
		$this->db->join('cases', 'cases.id = tests.case_id');
		$this->db->where_in('tests.run_id', $run_ids);
		$this->db->where('tests.is_selected', true);
		$this->db->where('tests.assignedto_id', $user_id);

		if ($case_ids)
		{
			$this->db->where_in('case_id', $case_ids);
		}

		if ($filters)
		{
			$this->_apply_todo_filter($fields, $filters);
		}

		if ($limit)
		{
			$this->db->limit($limit);
		}

		$this->db->order_by('tests.run_id');
		$this->db->order_by('tests.status_id', 'desc');
		$todos = $this->db->get_result();

		$todo_count_partial = count($todos);
		$todo_count = $todo_count_partial;

		if ($limit)
		{
			if ($todo_count_partial == $limit)
			{
				$todo_count = $this->_get_todo_count(
					$run_ids,
					$case_ids,
					$user_id,
					$fields,
					$filters);
			}
		}

		return group::by_id_scalar($todos, 'run_id', 'id');
	}

	private function _get_todo_count($run_ids, $case_ids, $user_id,
		$fields, $filters)
	{
		$this->db->from('tests');
		$this->db->join('cases', 'cases.id = tests.case_id');
		$this->db->where_in('run_id', $run_ids);
		$this->db->where('is_selected', true);
		$this->db->where('assignedto_id', $user_id);

		if ($case_ids)
		{
			$this->db->where_in('case_id', $case_ids);
		}

		if ($filters)
		{
			$this->_apply_todo_filter($fields, $filters);
		}

		return $this->db->get_count();
	}

	private function _apply_todo_filter($fields, $filters)
	{
		// Compile and apply the custom filter, if any.
		$filter_model = $this->load->model('filter');
		$expr = $filter_model->get_where($fields, $filters);

		if ($expr)
		{
			$this->db->where_expr($expr);
		}
	}

	/**
	 * Get Estimates
	 *
	 * Gets the total estimate and forecast for the given test runs
	 * and user.
	 */
	public function get_estimates($run_ids, $case_ids, $user_id,
		$suite_estimates, $fields, $filters)
	{
		// Dynamically create a list of WHEN/THEN expressions for the
		// suite estimates and the forecast averages. The averages are
		// used for cases that don't have their own forecast value.
		$when = '';
		foreach ($suite_estimates as $suite_id => $estimate)
		{
			$when .= str::format(
				"WHEN cases.suite_id = {0} THEN {1}\n",
				$suite_id,
				$estimate->forecast_average
			);
		}

		// Format the SQL using the placeholders for the WHEN/THEN
		// expressions and execute the query afterwards.
		$sql = str::formatn(
			'SELECT
				COUNT(id) AS test_count,
				SUM(estimate) AS total_estimate,
				SUM(estimate_forecast) AS total_forecast
			FROM
				(SELECT
					tests.id,
					COALESCE(cases.estimate, 0) AS estimate,
					(CASE WHEN cases.estimate_forecast IS NULL THEN
						(CASE
							%{when}
						ELSE
							0
						END)
					ELSE
						cases.estimate_forecast
					END) AS estimate_forecast
				FROM
					tests
				JOIN
					cases
						ON
					cases.id = tests.case_id
				WHERE
					tests.run_id in ({0}) AND
					%{cases} AND
					tests.is_selected = 1 AND
					tests.assignedto_id = {1} AND
					%{filter}) AS t',
			array(
				'when' => $when,
				'cases' => $this->_get_cases_filter($case_ids),
				'filter' => $this->_get_estimates_filter(
					$fields,
					$filters
				)
			)
		);

		$query = $this->db->query($sql, $run_ids, $user_id);
		return $query->row();
	}

	private function _get_cases_filter($case_ids)
	{
		$expr = null;

		if ($case_ids)
		{
			$expr = str::format(
				'tests.case_id IN ({0})',
				$this->db->quote_value($case_ids)
			);
		}

		return $expr ? $expr : '(1 = 1)';
	}

	private function _get_estimates_filter($fields, $filters)
	{
		$expr = null;

		if ($filters)
		{
			$filter_model = $this->load->model('filter');
			$expr = $filter_model->get_where($fields, $filters);
		}

		return $expr ? $expr : '(1 = 1)';
	}
}
