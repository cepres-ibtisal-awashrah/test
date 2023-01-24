<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php $case_count = 0 ?>
<?php $case_count_partial = 0 ?>

<?php $show_suites = !isset($project->suite_mode) || 
	$project->suite_mode != TP_PROJECTS_SUITES_SINGLE ?>

<?php if ($show_suites): ?>
	<?php if ($noreferences->suites): ?>
		<?php
		$temp = array();
		$temp['suites'] = $noreferences->suites;
		$temp['show_links'] = $show_links;
		$report_obj->render_view('index/noreferences/suites', $temp);
		?>
	<?php endif ?>
<?php endif ?>

<?php foreach ($noreferences->content as $suite): ?>
	<?php if ($show_suites): ?>
	<h2 class="newPage"><?php echo h( $suite->name) ?></h2>
	<?php endif ?>
	<?php if ($suite->content): ?>
		<?php $cases = $report_helper->get_cases(
			$suite->case_ids,
			$case_fields,
			$case_assocs,
			$case_rels) ?>
		<?php
		$temp = array();
		$temp['project'] = $project;
		$temp['case_lookup'] = obj::get_lookup($cases);
		$temp['case_assocs'] = $case_assocs;
		$temp['case_rels'] = $case_rels;
		$temp['case_fields'] = $case_fields;
		$temp['case_columns'] = $case_columns;
		$temp['case_columns_for_user'] = $case_columns_for_user;
		$temp['groups'] = $suite->content;
		$temp['index'] = 1;
		$temp['chapter'] = '';
		$temp['show_links'] = $show_links;
		$report_obj->render_view('index/noreferences/groups', $temp);
		?>
		<?php $case_count += $suite->case_count ?>
		<?php $case_count_partial += $suite->case_count_partial ?>
	<?php endif ?>
<?php endforeach ?>

<?php if ($noreferences->suite_count > $noreferences->suite_count_partial): ?>
	<?php if ($case_count > $case_count_partial): ?>
	<p class="partial">
		<?php echo  langf('reports_rcc_noref_more_cases_and_suites',
			$case_count - $case_count_partial,
			$noreferences->suite_count - 
			$noreferences->suite_count_partial) ?>
	</p>
	<?php else: ?>
	<p class="partial">
		<?php echo  langf('reports_rcc_noref_more_suites',
			$noreferences->suite_count - 
			$noreferences->suite_count_partial) ?>
	</p>
	<?php endif ?>
<?php else: ?>
	<?php if ($case_count > $case_count_partial): ?>
	<p class="partial">
		<?php echo  langf(
			$show_suites ? 
				'reports_rcc_noref_more_cases' :
				'reports_rcc_noref_more_cases_single',
			$case_count - $case_count_partial
		) ?>
	</p>
	<?php endif ?>
<?php endif ?>
