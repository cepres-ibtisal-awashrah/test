<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php $tab = 1 ?>

<input type="hidden" name="tab" id="tab" />

<div class="tabs">
	<div class="tab-header">
		<a href="javascript:void(0)" class="tab1 <?php echo  $tab == 1 ? 'current' : '' ?>" rel="1"
			onclick="App.Tabs.activate(this)"><?php echo  lang('reports_cst_form_statuses') ?></a>
		<a href="javascript:void(0)" class="tab2 <?php echo  $tab == 2 ? 'current' : '' ?>" rel="1"
			onclick="App.Tabs.activate(this)">
			<?php if ($project->suite_mode == TP_PROJECTS_SUITES_SINGLE): ?>
			<?php echo  lang('reports_cst_form_runs_single') ?>
			<?php else: ?>
			<?php echo  lang('reports_cst_form_runs') ?>
			<?php endif ?>
		</a>
		<a href="javascript:void(0)" class="tab3 <?php echo  $tab == 3 ? 'current' : '' ?>" rel="2"
			onclick="App.Tabs.activate(this)"><?php echo  lang('reports_cst_form_cases') ?></a>
	</div>
	<div class="tab-body tab-frame">
		<div class="tab tab1 <?php echo  $tab != 1 ? 'hidden' : '' ?>">
			<?php $report_obj->render_control(
				$controls,
				'statuses_select',
				array(
					'top' => true
				)
			) ?>
			<?php $report_obj->render_control($controls, 'results_select') ?>
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
				'cases_columns',
				array(
					'top' => true,
					'columns' => $case_columns
				)
			) ?>
			<?php $report_obj->render_control(
				$controls,
				'cases_limit',
				array(
					'intro' => lang('reports_cst_form_cases_limit'),
					'limits' => array(5, 10, 25, 50, 100, 250, 500, 1000)
				)
			) ?>
		</div>
	</div>
</div>

<div style="margin-top: 1em">
	<?php $report_obj->render_control($controls, 'content_hide_links') ?>
</div>