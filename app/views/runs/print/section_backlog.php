<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php $to_show = array($section) ?>

<?php $parent = $section->_parent ?>
<?php while ($parent && !$parent->_shown): ?>
	<?php array_unshift($to_show, $parent) ?>
	<?php $parent = $parent->_parent ?>
<?php endwhile ?>

<?php while ($to_show): ?>
	<?php $s = array_shift($to_show) ?>
	<?php $index = $s->_parent->_index++ ?>
	<?php if ($s->_parent->_chapter): ?>
		<?php $chapter = $s->_parent->_chapter . "$index." ?>
	<?php else: ?>
		<?php $chapter = "$index." ?>
	<?php endif ?>
	<h2><?php echo h( $chapter . ' ' . $s->name ) ?></h2>
	<?php if (isset($s->description) && $s->description): ?>
		<div class="markdown" style="margin-bottom: 1.5em">
			<?php echo  markdown::to_html($s->description) ?>
		</div>
	<?php endif ?>	
	<?php $s->_shown = true ?>
	<?php $s->_chapter = $chapter ?>
<?php endwhile ?>
