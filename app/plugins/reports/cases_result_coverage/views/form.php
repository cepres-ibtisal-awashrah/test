<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php $tab = 1 ?>

<input type="hidden" name="tab" id="tab" />

<div class="tabs">
	<div class="tab-header">
		<a href="javascript:void(0)" class="tab1 <?php echo  $tab == 1 ? 'current' : '' ?>" rel="1"
			onclick="App.Tabs.activate(this)">
			<?php if ($project->suite_mode == TP_PROJECTS_SUITES_SINGLE): ?>
			<?php echo  lang('reports_crc_form_runs_single') ?>
			<?php else: ?>
			<?php echo  lang('reports_crc_form_runs') ?>
			<?php endif ?>
		</a>
		<a href="javascript:void(0)" class="tab2 <?php echo  $tab == 2 ? 'current' : '' ?>" rel="2"
			onclick="App.Tabs.activate(this)"><?php echo  lang('reports_crc_form_cases') ?></a>
	</div>
	<div class="tab-body tab-frame">
		<div class="tab tab1 <?php echo  $tab != 1 ? 'hidden' : '' ?>">
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
		<div class="tab tab2 <?php echo  $tab != 2 ? 'hidden' : '' ?>">
			<?php $report_obj->render_control(
				$controls,
				'cases_filter',
				array(
					'top' => true,
					'project' => $project
				)
			) ?>
			<?php $report_obj->render_control(
				$controls,
				'cases_columns',
				array(
					'columns' => $case_columns
				)
			) ?>
			<p><?php echo  lang('reports_crc_form_cases_columns_extra') ?></p>
			<div class="checkbox form-checkbox" style="margin-left: 15px">
				<label>
					<?php echo  lang('reports_crc_form_cases_columns_comparison') ?>
					<input type="checkbox" id="custom_cases_include_comparison"
						name="custom_cases_include_comparison" value="1"
						<?php echo  validation::get_checked('custom_cases_include_comparison',1) ?> />
				</label>
			</div>
			<div class="checkbox" style="margin-left: 15px">
				<label>
					<?php echo  lang('reports_crc_form_cases_columns_coverage') ?>
					<input type="checkbox" id="custom_cases_include_coverage"
						name="custom_cases_include_coverage" value="1"
						<?php echo  validation::get_checked('custom_cases_include_coverage',1) ?> />
				</label>
			</div>
			<?php $report_obj->render_control(
				$controls,
				'cases_limit',
				array(
					'intro' => lang('report_plugins_cases_limit')
				)
			) ?>
		</div>
	</div>
</div>

<div style="margin-top: 1em">
	<?php $report_obj->render_control($controls, 'content_hide_links') ?>
</div>
