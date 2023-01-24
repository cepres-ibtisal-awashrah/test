<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php
$min_width = 125; // For References column

foreach ($case_columns_for_user as $key => $width)
{
	$min_width += $width ? $width : 300;
}

$min_width = max($min_width, 960);

$header = array(
	'project' => $project,
	'report' => $report,
	'meta' => $report_obj->get_meta(),
	'min_width' => $min_width,
	'show_links' => $show_links,
	'css' => array(
		'styles/reset.css' => 'all',
		'styles/view.css' => 'all',
		'styles/print.css' => 'print'
	),
	'js' => array(
		'js/jquery.js',
		'js/fusioncharts.js',
		'js/fusioncharts.theme.fusion.js'
	)
);

$GI->load->view('report_plugins/layout/header', $header);
?>

<?php
$temp = [];
$temp['references'] = $references;
$temp['noreferences'] = $noreferences;
$temp['report'] = $report;
$report_obj->render_view('index/charts', $temp);
?>

<?php $has_refs = $references != null ?>

<?php if ($references): ?>
<h1 class="top"><img class="right noPrint w16" src="%RESOURCE%:images/report-assets/help.svg" alt="" title="<?php echo  lang('reports_rcc_ref_header_info') ?>" /><?php echo  lang('reports_rcc_ref_header') ?></h1>
	<?php if ($references->reference_count > 0): ?>
		<?php
		$temp = [];
		$temp['project'] = $project;
		$temp['references'] = $references;
		$temp['case_columns'] = $case_columns;
		$temp['case_columns_for_user'] = $case_columns_for_user;
		$temp['case_fields'] = $case_fields;
		$temp['case_limit'] = $case_limit;
		$temp['show_links'] = $show_links;
		$report_obj->render_view('index/references', $temp);
		?>
	<?php else: ?>
		<p><?php echo  lang('reports_rcc_ref_empty') ?></p>
	<?php endif ?>
<?php endif ?>

<?php if ($noreferences): ?>
	<h1 class="<?php echo  $has_refs ? 'newPage' : 'top' ?>"><img class="right noPrint w16" src="%RESOURCE%:images/report-assets/help.svg" alt=""
		title="<?php echo  lang('reports_rcc_noref_header_info') ?>" /><?php echo  lang('reports_rcc_noref_header') ?></h1>
	<?php if ($noreferences->content): ?>
		<?php
		$temp = [];
		$temp['project'] = $project;
		$temp['noreferences'] = $noreferences;
		$temp['case_columns'] = $case_columns;
		$temp['case_columns_for_user'] = $case_columns_for_user;
		$temp['case_fields'] = $case_fields;
		$temp['show_links'] = $show_links;
		$report_obj->render_view('index/noreferences', $temp);
		?>
	<?php else: ?>
		<p><?php echo  lang('reports_rcc_noref_empty') ?></p>
	<?php endif ?>
<?php endif ?>

<?php
$temp = [];
$temp['report'] = $report;
$temp['meta'] = $report_obj->get_meta();
$temp['show_options'] = true;
$temp['show_report'] = true;
$GI->load->view('report_plugins/layout/footer', $temp);
?>
