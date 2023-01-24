<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<stats>
	<?php $statuses = $GI->cache->get_objects('status') ?>
	<?php foreach ($statuses as $status): ?>
		<?php $prop_count = $status->system_name . '_count' ?>
		<?php $prop_percent = $status->system_name . '_percent' ?>
		<?php if ($status->is_active || $stats->$prop_count > 0): ?>
		<<?php echo  $status->name ?>>
			<percent><?php echo  $stats->$prop_percent ?></percent>
			<count><?php echo  $stats->$prop_count ?></count>
		</<?php echo  $status->name ?>>
		<?php endif ?>
	<?php endforeach ?>
</stats>