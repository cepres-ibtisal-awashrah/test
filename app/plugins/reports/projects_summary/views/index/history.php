<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php
$groups = group::by_day($history, 'created_on');
?>

<?php
$suites = arr::get($history_rels, 'suites');
$runs = arr::get($history_rels, 'runs');
$plans = arr::get($history_rels, 'plans');
$milestones = arr::get($history_rels, 'milestones');
?>

<?php $is_first = true ?>
<?php foreach ($groups as $group): ?>
	<div class="dateSection" style="<?php echo  $is_first ? 'margin-top: 1.5em' : '' ?>">
		<span class="title"><?php echo h( $group->name )?></span>
	</div>
	<?php arr::alternator() ?>
	<table class="grid">
		<colgroup>
			<col class="box"></col>
			<col></col>
			<col class="comment"></col>
		</colgroup>
		<?php foreach ($group->items as $item): ?>
			<?php $alt = arr::alternator('odd', 'even') ?>
			<tr class="<?php echo  $alt ?>">
				<td class="box">
					<span class="statusBox <?php echo  projects::get_history_box($item) ?>"><?php echo  projects::get_history_box_title($item) ?></span>
				</td>
				<td>
					<?php if ($item->is_deleted): ?>
						<span class="deleted"><?php echo h( $item->name )?></span>
					<?php else: ?>
						<?php if ($item->run_id): ?>
							<?php $run = arr::get($runs, $item->run_id) ?>
							<?php if ($run): ?>
								<?php if ($show_links): ?>
									<a target="_top" 
										href="<?php echo  "%LINK%:runs/view/$item->run_id" ?>"><?php echo h( $run->name )?></a>
								<?php else: ?>
									<?php echo h( $run->name )?>
								<?php endif ?>
								<?php if ($run->is_completed): ?>
									<span class="secondary"><?php echo  lang('projects_history_completed') ?></span>
								<?php endif ?>
							<?php endif ?>
						<?php elseif ($item->plan_id): ?>
							<?php $plan = arr::get($plans, $item->plan_id) ?>
							<?php if ($plan): ?>
								<?php if ($show_links): ?>
									<a target="_top" href="<?php echo  "%LINK%:plans/view/$item->plan_id" ?>"><?php echo h( $plan->name )?></a>
								<?php else: ?>
									<?php echo h( $plan->name )?>
								<?php endif ?>
								<?php if ($plan->is_completed): ?>
									<span class="secondary"><?php echo  lang('projects_history_completed') ?></span>
								<?php endif ?>
							<?php endif ?>
						<?php elseif ($item->suite_id): ?>
							<?php $suite = arr::get($suites, $item->suite_id) ?>
							<?php if ($suite): ?>
								<?php if ($show_links): ?>
									<a target="_top" href="<?php echo  "%LINK%:suites/view/$item->suite_id" ?>"><?php echo h( $suite->name )?></a>
								<?php else: ?>
									<?php echo h( $suite->name )?>
								<?php endif ?>
							<?php endif ?>
						<?php elseif ($item->milestone_id): ?>
							<?php $milestone = arr::get($milestones, $item->milestone_id) ?>
							<?php if ($milestone): ?>
								<?php if ($show_links): ?>
									<a target="_top" href="<?php echo  "%LINK%:milestones/view/$item->milestone_id" ?>"><?php echo h( $milestone->name )?></a>
								<?php else: ?>
									<?php echo h( $milestone->name )?>
								<?php endif ?>
								<?php if ($milestone->is_completed): ?>
									<span class="secondary"><?php echo  lang('projects_history_completed') ?></span>
								<?php endif ?>
							<?php endif ?>
						<?php endif ?>
					<?php endif ?>
				</td>
				<td class="right">
					<?php $user_name = h(names::shorten($GI->cache->get_scalar('user', $item->user_id, 'name', ''))) ?>
					<?php if ($item->action == TP_HISTORY_CREATED): ?>
						<span class="secondary"><?php echo  langf('layout_messages_createdby', $user_name) ?></span>
					<?php elseif ($item->action == TP_HISTORY_DELETED): ?>
						<span class="secondary"><?php echo  langf('layout_messages_deletedby', $user_name) ?></span>
					<?php elseif ($item->action == TP_HISTORY_COMPLETED): ?>
						<span class="secondary"><?php echo  langf('layout_messages_completedby', $user_name) ?></span>
					<?php elseif ($item->action == TP_HISTORY_REOPENED): ?>
						<span class="secondary"><?php echo  langf('layout_messages_reopenedby', $user_name) ?></span>
					<?php elseif ($item->action == TP_HISTORY_CLOSED): ?>
						<span class="secondary"><?php echo  langf('layout_messages_closedby', $user_name) ?></span>
					<?php endif ?>
				</td>
			</tr>
		<?php endforeach ?>
	</table>
	<?php $is_first = false ?>
<?php endforeach ?>
