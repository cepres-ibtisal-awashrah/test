<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php $tab = 1 ?>

<input type="hidden" name="tab" id="tab" />

<div class="tabs">
	<div class="tab-header">
		<a href="javascript:void(0)" class="tab1 <?php echo  $tab == 1 ? 'current' : '' ?>" rel="1"
			onclick="App.Tabs.activate(this)"><?php echo  lang('reports_ps_form_details') ?></a>
		<a href="javascript:void(0)" class="tab2 <?php echo  $tab == 2 ? 'current' : '' ?>" rel="4"
			onclick="App.Tabs.activate(this)"><?php echo  lang('reports_ps_form_history') ?></a>
		<a href="javascript:void(0)" class="tab3 <?php echo  $tab == 3 ? 'current' : '' ?>" rel="3"
			onclick="App.Tabs.activate(this)"><?php echo  lang('reports_ps_form_activity') ?></a>
	</div>
	<div class="tab-body tab-frame">
		<div class="tab tab1 <?php echo  $tab != 1 ? 'hidden' : '' ?>">
			<p class="top"><?php echo  lang('reports_ps_form_milestones') ?></p>
			<div class="checkbox form-checkbox" style="margin-left: 15px">
				<label>
					<?php echo  lang('reports_ps_form_milestones_active') ?>
					<input type="checkbox" id="custom_milestones_active_include"
						name="custom_milestones_active_include" value="1"
						<?php echo  validation::get_checked('custom_milestones_active_include',1) ?> />
				</label>
			</div>
			<div class="checkbox form-checkbox" style="margin-left: 15px">
				<label>
					<?php echo  lang('reports_ps_form_milestones_completed') ?>
					<input type="checkbox" id="custom_milestones_completed_include"
						name="custom_milestones_completed_include" value="1"
						<?php echo  validation::get_checked('custom_milestones_completed_include',1) ?> />
				</label>
			</div>
			<div style="margin-left: 35px">
			<?php $report_obj->render_control(
				$controls,
				'milestones_completed_limit',
				array(
					'top' => true,
					'intro' => lang('reports_ps_form_milestones_limit'),
					'limits' => array(5, 10, 25)
				)
			) ?>
			</div>
			<p><?php echo  lang('reports_ps_form_runs') ?></p>
			<div class="checkbox form-checkbox" style="margin-left: 15px">
				<label>
					<?php echo  lang('reports_ps_form_runs_active') ?>
					<input type="checkbox" id="custom_runs_active_include"
						name="custom_runs_active_include" value="1"
						<?php echo  validation::get_checked('custom_runs_active_include',1) ?> />
				</label>
			</div>
			<div class="checkbox form-checkbox" style="margin-left: 15px">
				<label>
					<?php echo  lang('reports_ps_form_runs_completed') ?>
					<input type="checkbox" id="custom_runs_completed_include"
						name="custom_runs_completed_include" value="1"
						<?php echo  validation::get_checked('custom_runs_completed_include',1) ?> />
				</label>
			</div>
			<div style="margin-left: 35px">
			<?php $report_obj->render_control(
				$controls,
				'runs_completed_limit',
				array(
					'top' => true,
					'intro' => lang('reports_ps_form_runs_limit'),
					'limits' => array(5, 10, 25, 50, 100)
				)
			) ?>
			</div>
			<p><?php echo  lang('reports_ps_form_details_include') ?></p>
			<div class="checkbox form-checkbox" style="margin-left: 15px">
				<label>
					<?php echo  lang('reports_ps_form_details_include_history') ?>
					<input type="checkbox" id="custom_history_include"
						name="custom_history_include" value="1"
						<?php echo  validation::get_checked('custom_history_include',1) ?> />
				</label>
			</div>
			<div class="checkbox" style="margin-left: 15px">
				<label>
					<?php echo  lang('reports_ps_form_details_include_activity') ?>
					<input type="checkbox" id="custom_activities_include"
						name="custom_activities_include" value="1"
						<?php echo  validation::get_checked('custom_activities_include',1) ?> />
				</label>
			</div>
		</div>
		<div class="tab tab2 <?php echo  $tab != 2 ? 'hidden' : '' ?>">
			<?php $report_obj->render_control(
				$controls,
				'history_daterange',
				array(
					'top' => true
				)
			) ?>
			<?php $report_obj->render_control(
				$controls,
				'history_limit',
				array(
					'intro' => lang('report_plugins_history_limit'),
					'limits' => array(10, 25, 50, 100, 250, 500, 1000)
				)
			) ?>
		</div>
		<div class="tab tab3 <?php echo  $tab != 3 ? 'hidden' : '' ?>">
			<?php $report_obj->render_control(
				$controls,
				'activities_daterange',
				array(
					'top' => true
				)
			) ?>
			<?php $report_obj->render_control($controls, 'activities_statuses') ?>
			<?php $report_obj->render_control(
				$controls,
				'activities_limit',
				array(
					'intro' => lang('report_plugins_activities_limit'),
					'limits' => array(10, 25, 50, 100, 250, 500, 1000)
				)
			) ?>
		</div>
	</div>
</div>

<div class="reportBoxContainerSmall" style="margin-top: 1em">
	<?php $report_obj->render_control($controls, 'content_hide_links') ?>
</div>
