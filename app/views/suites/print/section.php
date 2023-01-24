<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php if ($chapter): ?>
	<?php $chapter = "$chapter$index." ?>
<?php else: ?>
	<?php $chapter = "$index." ?>
<?php endif ?>
<h2><?php echo h( $chapter . ' ' . $section->name ) ?></h2>
<?php if (isset($section->description) && $section->description): ?>
	<div class="markdown" style="margin-bottom: 1.5em">
		<?php echo  markdown::to_html($section->description) ?>
	</div>
<?php endif ?>
<?php
$temp = array();
$temp['project'] = $project;
$temp['section'] = $section;
$temp['cases'] = $cases;
$temp['case_assocs'] = $case_assocs;
$temp['format'] = $format;
$temp['fields'] = $fields;
$temp['case_fields'] = $case_fields;
$temp['columns'] = $columns;
$temp['columns_for_user'] = $columns_for_user;
$temp['milestone_lookup'] = $milestone_lookup;
$GI->load->view('suites/print/' . $format, $temp);
?>
<?php $next = $sections->peek() ?>
<?php $index = 1 ?>
<?php while ($next && $next->depth > $section->depth): ?>
	<?php $sections->next() ?>
	<?php
	$temp = array();
	$temp['project'] = $project;
	$temp['section'] = $next;
	$temp['sections'] = $sections;
	$temp['cases'] = $cases;
	$temp['case_assocs'] = $case_assocs;
	$temp['format'] = $format;
	$temp['index'] = $index;
	$temp['chapter'] = $chapter;
	$temp['fields'] = $fields;
	$temp['case_fields'] = $case_fields;
	$temp['columns'] = $columns;
	$temp['columns_for_user'] = $columns_for_user;
	$temp['milestone_lookup'] = $milestone_lookup;
	$GI->load->view('suites/print/section', $temp);
	?>	
	<?php $index++ ?>
	<?php $next = $sections->peek() ?>
<?php endwhile ?>
