<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php $tab = 1 ?>

<input type="hidden" name="tab" id="tab" />

<div class="tabs">
	<div class="tab-header">
		<a href="javascript:void(0)" class="tab1 <?php echo  $tab == 1 ? 'current' : '' ?>" rel="1"
			onclick="App.Tabs.activate(this)"><?php echo  lang('reports_tpg_form_grouping') ?></a>
		<a href="javascript:void(0)" class="tab2 <?php echo  $tab == 2 ? 'current' : '' ?>" rel="2"
			onclick="App.Tabs.activate(this)">
			<?php if ($project->suite_mode == TP_PROJECTS_SUITES_SINGLE): ?>
			<?php echo  lang('reports_tpg_form_runs_single') ?>
			<?php else: ?>
			<?php echo  lang('reports_tpg_form_runs') ?>
			<?php endif ?>
		</a>
		<a href="javascript:void(0)" class="tab3 <?php echo  $tab == 3 ? 'current' : '' ?>" rel="3"
			onclick="App.Tabs.activate(this)"><?php echo  lang('reports_tpg_form_tests') ?></a>
	</div>
	<div class="tab-body tab-frame">
		<div class="tab tab1 <?php echo  $tab != 1 ? 'hidden' : '' ?>">
			<?php $report_obj->render_control(
				$controls,
				'tests_grouping',
				array(
					'top' => true,
					'intro' => lang('reports_tpg_form_tests_groupby'),
					'attributes' => $test_groupby
				)
			) ?>
			<p><?php echo  lang('reports_tpg_form_tests_details') ?></p>
			<div class="checkbox form-checkbox" style="margin-left: 15px">
				<label>
					<?php echo  lang('reports_tpg_form_tests_include_summary') ?>
					<input type="checkbox" id="custom_tests_include_summary"
						name="custom_tests_include_summary"
						value="1"
						<?php echo  validation::get_checked('custom_tests_include_summary', 1) ?> />
				</label>
			</div>
			<div class="checkbox" style="margin-left: 15px">
				<label>
					<?php echo  lang('reports_tpg_form_tests_include_tests') ?>
					<input type="checkbox" id="custom_tests_include_details"
						name="custom_tests_include_details"
						value="1"
						<?php echo  validation::get_checked('custom_tests_include_details',
							1) ?> />
				</label>
			</div>
		</div>
		<div class="tab tab2 <?php echo  $tab != 2 ? 'hidden' : '' ?>">
			<?php $report_obj->render_control(
				$controls,
				'runs_select',
				array(
					'top' => true,
					'project' => $project
				)
			) ?>
			<?php $report_obj->render_control(
				$controls,
				'runs_limit',
				array(
					'intro' => lang('report_plugins_runs_limit'),
					'limits' => array(5, 10, 25, 50, 100, 0)
				)
			) ?>
		</div>
		<div class="tab tab3 <?php echo  $tab != 3 ? 'hidden' : '' ?>">
			<?php $report_obj->render_control(
				$controls,
				'tests_filter',
				array(
					'top' => true,
					'project' => $project
				)
			) ?>
			<?php $report_obj->render_control(
				$controls,
				'tests_columns',
				array(
					'columns' => $test_columns
				)
			) ?>
			<?php $report_obj->render_control(
				$controls,
				'tests_limit',
				array(
					'limits' => array(10, 25, 50, 100, 250, 500, 1000),
					'intro' => lang('reports_tpg_form_tests_limit')
				)
			) ?>
		</div>
	</div>
</div>

<div style="margin-top: 1em">
	<?php $report_obj->render_control($controls, 'content_hide_links') ?>
</div>
