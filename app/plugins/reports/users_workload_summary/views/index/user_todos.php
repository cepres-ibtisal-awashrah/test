<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php foreach ($users as $user): ?>
	<?php $todos_for_user = arr::get($user_todos, $user->id) ?>
	<?php if ($todos_for_user && $todos_for_user->todo_count): ?>
		<h2><?php echo h( $user->name )?></h2>
		<?php foreach ($todos_for_user->todos as $run_id => $todos_for_run): ?>
			<?php $run = arr::get($run_lookup, $run_id) ?>
			<?php if ($run): ?>
				<?php
				$temp = array();
				$temp['project'] = $project;
				$temp['run'] = $run;
				$temp['test_ids'] = $todos_for_run;
				$temp['test_columns'] = $test_columns;
				$temp['test_columns_for_user'] = $test_columns_for_user;
				$temp['test_fields'] = $test_fields;
				$temp['case_fields'] = $case_fields;
				$temp['show_links'] = $show_links;
				$report_obj->render_view('index/user_run', $temp);
				?>
			<?php endif ?>
		<?php endforeach ?>
		<?php if ($todos_for_user->todo_count > $todos_for_user->todo_count_partial): ?>
			<p class="partial">
				<?php echo  langf('reports_uws_tests_more',
					$todos_for_user->todo_count - 
					$todos_for_user->todo_count_partial) ?>
			</p>
		<?php endif ?>
	<?php endif ?>
<?php endforeach ?>
