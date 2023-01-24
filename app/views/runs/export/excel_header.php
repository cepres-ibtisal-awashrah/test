<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php
$filename = $filename . '.csv';
header("Content-Disposition: attachment; filename=\"$filename\"");
header('Content-Type: ' . mime::get_type('.xls'));
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
<?php $separator = $GI->i18n->get_locale_value('list_separator') ?>
<?php echo  "\xEF\xBB\xBF" ?>
<?php if ($separator_hint): ?>
<?php echo  "sep=$separator\n" ?>
<?php endif ?>
<?php echo  csv::join($header, $separator) ?>