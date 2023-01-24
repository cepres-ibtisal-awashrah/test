<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php
$filename = $filename . '.csv';
header("Content-Disposition: attachment; filename=\"$filename\"");
header('Content-Type: ' . mime::get_type($filename));
header('Content-Transfer-Encoding: binary');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
?>
<?php
$header = array();
foreach ($columns as $column)
{
	$label = arr::get($fields_csv, $column);
	if ($label)
	{
		$header[] = csv::encode($label);
	}
}
?>
<?php echo  "\xEF\xBB\xBF" ?>
<?php echo  csv::join($header, ',') ?>