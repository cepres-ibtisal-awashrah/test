<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php arr::alternator() ?>
<table class="grid">
	<colgroup>
		<col class="icon"></col>
		<col></col>
		<col class="comment"></col>
	</colgroup>
	<?php foreach ($suites as $suite): ?>
	<?php $alt = arr::alternator('odd', 'even') ?>
	<?php if (!isset($suite->case_count) || $suite->case_count > 0): ?>
	<tr class="<?php echo  $alt ?>">
		<td class="icon">
			<img src="%RESOURCE%:images/report-assets/suite16.svg" width="16" height="16"
				alt="" />
		</td>
		<td>
			<?php if ($show_links): ?>
				<a target="_top" href="<?php echo  "%LINK%:/suites/view/$suite->id" ?>"><?php echo h( $suite->name )?></a>
			<?php else: ?>
				<?php echo h( $suite->name )?>
			<?php endif ?>
		</td>
		<td class="right secondary">
			<?php if (isset($suite->case_count)): ?>
				<?php echo  langf('reports_rcc_noref_suites_comment', $suite->case_count) ?>
			<?php else: ?>
				<?php echo  lang('reports_rcc_noref_suites_comment_na') ?>
			<?php endif ?>
		</td>
	</tr>
	<?php endif ?>
	<?php endforeach ?>
</table>