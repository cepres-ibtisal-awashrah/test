<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<h1>
<?php if ($milestone): ?>
	<span class="h1-secondary pull-right">
		<?php echo h( $milestone->name )?></span>
<?php endif ?>
<?php echo  entities::run_id($run->id) ?>: <?php echo h( $run->name ) ?>
<?php if ($run->config): ?>
 	<span class="h1-secondary configuration">(<?php echo h( $run->config )?>)</span>
<?php endif ?>
</h1>
<?php if (!str::is_empty($run->description)): ?>
	<div class="markdown" style="margin-bottom: 1em"><?php echo  markdown::to_html($run->description) ?></div>
<?php endif ?>
<?php $show_dates = !isset($show_dates) || $show_dates ?>
<?php if ($show_dates): ?>
<div class="gridContainer">
	<table class="grid">
		<colgroup>
			<col></col>
			<col class="info"></col>
		</colgroup>
		<tr>
			<td><?php echo  lang('layout_grid_createdon') ?></td>
			<td class="info"><?php echo  date::format_short_date($run->created_on) ?></td>
		</tr>
		<tr>
			<td><?php echo  lang('layout_grid_completed') ?></td>
			<?php if ($run->is_completed): ?>
			<td class="info"><?php echo  lang('layout_yes') ?></td>
			<?php else: ?>
			<td class="info"><?php echo  lang('layout_no') ?></td>
			<?php endif ?>
		</tr>
		<?php if ($run->is_completed): ?>
		<tr>
			<td><?php echo  lang('layout_grid_completedon') ?></td>
			<td class="info"><?php echo  date::format_short_date($run->completed_on) ?></td>
		</tr>
		<?php endif ?>
	</table>
</div>
<?php endif ?>
<?php
$temp = array();
$temp['stats'] = $run;
$GI->load->view('runs/print/stats', $temp);
?>