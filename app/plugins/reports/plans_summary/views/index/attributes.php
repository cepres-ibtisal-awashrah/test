<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<table class="grid">
	<colgroup>
		<col></col>
		<col class="comment"></col>
	</colgroup>
	<?php if ($milestone): ?>
	<tr class="odd">
		<td><?php echo  lang('reports_pls_attr_milestone') ?></td>
		<td class="right">
			<?php if ($show_links): ?>
				<a target="_top" href="<?php echo  "%LINK%:/milestones/view/$milestone->id" ?>"><?php echo h( $milestone->name )?></a>
			<?php else: ?>
				<?php echo h( $milestone->name ) ?>
			<?php endif ?>
		</td>
	</tr>
	<?php endif ?>
	<?php if ($plan->created_on): ?>
	<tr class="even">
		<td><?php echo  lang('reports_pls_attr_createdon') ?></td>
		<td class="right">
			<?php echo  date::format_short_date($plan->created_on) ?>
		</td>
	</tr>
	<?php endif ?>
	<tr class="odd">
		<td><?php echo  lang('reports_pls_attr_completed') ?></td>
		<?php if (isset($milestone->is_completed) && $milestone->is_completed): ?>
		<td class="right"><?php echo  lang('layout_yes') ?></td>
		<?php else: ?>
		<td class="right"><?php echo  lang('layout_no') ?></td>
		<?php endif ?>
	</tr>
	<?php if ($plan->is_completed): ?>
	<tr class="even">
		<td><?php echo  lang('reports_pls_attr_completedon') ?></td>
		<td class="right">
			<?php echo  date::format_short_date($plan->completed_on) ?>
		</td>
	</tr>
	<?php endif ?>
</table>