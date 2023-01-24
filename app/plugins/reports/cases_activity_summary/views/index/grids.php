<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php $index = 1 ?>
<?php foreach ($groups as $group): ?>
	<?php $chapter_cur = "$chapter$index." ?>
	<h3><span class="chapter"><?php echo  $chapter_cur ?></span>
	<?php echo h( $group->name )?>
	<span class="secondary">(<?php echo  count($group->items) ?>)</span>
	</h3>
	<?php if (isset($group->description)): ?>
		<?php $has_description = !str::is_empty($group->description) ?>
		<?php if ($has_description): ?>
		<div class="markdown" style="margin-bottom: 1.5em">
			<?php if ($show_links): ?>
				<?php echo  markdown::to_html($group->description) ?>
			<?php else: ?>
				<?php echo  markdown::to_html_nolinks($group->description) ?>
			<?php endif ?>
		</div>
		<?php endif ?>	
	<?php endif ?>	
	<?php if (isset($group->items) && $group->items): ?>
		<?php
		$temp = array();
		$temp['project'] = $project;
		$temp['case_lookup'] = $case_lookup;
		$temp['case_assocs'] = $case_assocs;
		$temp['case_rels'] = $case_rels;
		$temp['case_fields'] = $case_fields;
		$temp['case_columns'] = $case_columns;
		$temp['case_columns_for_user'] = $case_columns_for_user;
		$temp['case_ids'] = $group->items;
		$temp['case_ids_created_lookup'] = $case_ids_created_lookup;
		$temp['case_ids_updated_lookup'] = $case_ids_updated_lookup;
		$temp['show_links'] = $show_links;
		$report_obj->render_view('index/grid', $temp);
		?>
	<?php endif ?>
	<?php if (isset($group->groups) && $group->groups): ?>
		<div class="gridContainer">
		<?php
		$temp = array();
		$temp['project'] = $project;
		$temp['case_lookup'] = $case_lookup;
		$temp['case_assocs'] = $case_assocs;
		$temp['case_rels'] = $case_rels;
		$temp['case_fields'] = $case_fields;
		$temp['case_columns'] = $case_columns;
		$temp['case_columns_for_user'] = $case_columns_for_user;
		$temp['case_ids_created_lookup'] = $case_ids_created_lookup;
		$temp['case_ids_updated_lookup'] = $case_ids_updated_lookup;
		$temp['groups'] = $group->groups;
		$temp['index'] = $index;
		$temp['chapter'] = $chapter_cur;
		$temp['show_links'] = $show_links;
		$report_obj->render_view('index/grids', $temp);
		?>
		</div>
	<?php endif ?>
	<?php $index++ ?>
<?php endforeach ?>