<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php
header('Content-Type: text/html; charset=UTF-8');
header('Expires: Sat, 01 Jan 2000 00:00:00 GMT');
header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');

// Set application style if no other style has been specified
if (!isset($page_css))
{
	$page_css = 'app';
}

// Are we allowed to use optimized/combined versions of our css files?
// Note that these settings are not defined when no config.php is
// present (e.g. during the installation) and we therefore default to
// true.
$optimize_css_include_build = true;

if (defined('DEPLOY_DEVELOP') && DEPLOY_DEVELOP)
{
	$optimize_css = false;
}
else
{
	$optimize_css = !defined('DEPLOY_OPTIMIZE_CSS') || DEPLOY_OPTIMIZE_CSS;
	if (defined('DEPLOY_HOSTED') && DEPLOY_HOSTED)
	{
		$optimize_css_include_build = false;
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title><?php echo  isset($page_title) ? h($page_title) . ' - ' : '' ?>TestRail</title>

<?php $themesuffix = class_exists('themes') ? themes::current_tag() : '-modern'; ?>

<?php if ($optimize_css): ?>
	<?php if ($optimize_css_include_build): ?>
		<link type="text/css" rel="stylesheet" href="<?php echo  r("css/{$page_css}{$themesuffix}-combined.css?1000") ?>" media="all" />
	<?php else: ?>
		<link type="text/css" rel="stylesheet" href="<?php echo  r("css/{$page_css}{$themesuffix}-combined.css") ?>" media="all" />
	<?php endif ?>
<?php else: ?>
	<link type="text/css" rel="stylesheet" href="<?php echo  r('css/reset.css') ?>" media="all" />
	<link type="text/css" rel="stylesheet" href="<?php echo  r("css/base{$themesuffix}.css") ?>" media="all" />
	<link type="text/css" rel="stylesheet" href="<?php echo  r("css/ui{$themesuffix}.css") ?>" media="all" />
	<link type="text/css" rel="stylesheet" href="<?php echo  r("css/tree{$themesuffix}.css") ?>" media="all" />
	<link type="text/css" rel="stylesheet" href="<?php echo  r("css/colorpicker{$themesuffix}.css") ?>" media="all" />
	<link type="text/css" rel="stylesheet" href="<?php echo  r("css/fancybox{$themesuffix}.css") ?>" media="all" />
	<link type="text/css" rel="stylesheet" href="<?php echo  r("css/chosen{$themesuffix}.css") ?>" media="all" />
	<link type="text/css" rel="stylesheet" href="<?php echo  r("css/controls{$themesuffix}.css") ?>" media="all" />
	<link type="text/css" rel="stylesheet" href="<?php echo  r("css/charts{$themesuffix}.css") ?>" media="all" />
	<link type="text/css" rel="stylesheet" href="<?php echo  r("css/forms{$themesuffix}.css") ?>" media="all" />
	<link type="text/css" rel="stylesheet" href="<?php echo  r("css/dialogs{$themesuffix}.css") ?>" media="all" />
	<link type="text/css" rel="stylesheet" href="<?php echo  r("css/markdown{$themesuffix}.css") ?>" media="all" />
	<link type="text/css" rel="stylesheet" href="<?php echo  r("css/dropzone{$themesuffix}.css") ?>" media="all" />
	<link type="text/css" rel="stylesheet" href="<?php echo  r("css/banner{$themesuffix}.css") ?>" media="all" />
	<link type="text/css" rel="stylesheet" href="<?php echo  r("css/{$page_css}{$themesuffix}.css") ?>" media="all" />
<?php endif ?>
	<link type="text/css" rel="stylesheet" href="<?php echo  r('css/font.css') ?>" media="all" />
	<link type="text/css" rel="stylesheet" href="<?php echo  r('css/drilldown.css') ?>" media="all" />
	<link type="text/css" rel="stylesheet" href="<?php echo  r("css/brand/style.css") ?>" media="all" />
	<link type="text/css" rel="stylesheet" href="<?php echo  r("css/brand/brand{$themesuffix}.css") ?>" media="all" />
	<link type="text/css" rel="stylesheet" href="<?php echo  r("css/assembla.css") ?>" media="all" />
	<link type="text/css" rel="stylesheet" href="<?php echo  r("css/banner-enterprise{$themesuffix}.css") ?>" media="all" />
    <?php
    if (class_exists('ViewModel')) {
        echo ViewModel::getCssScriptDataProvider()->getHeaderScripts();
    }
    ?>
	<link type="text/css" rel="stylesheet" href="<?php echo  r("css/autocomplete.css") ?>" media="all" />
<?php if (isset($page_print_css)): ?>
	<?php if ($optimize_css_include_build): ?>
		<link type="text/css" rel="stylesheet" href="<?php echo  r("css/print/$page_print_css.css?1000") ?>"
			media="print" />
	<?php else: ?>
		<link type="text/css" rel="stylesheet" href="<?php echo  r("css/print/$page_print_css.css") ?>"
			media="print" />
	<?php endif ?>
<?php endif ?>

    <link rel="shortcut icon" href="<?php echo  r('images/favicon.ico') ?>"/>
    <script type="text/javascript" src="<?php echo  r('js/jquery.js') ?>"></script>
<?php
if (class_exists('ViewModel')) {
    echo ViewModel::getJavaScriptDataProvider()->getHeaderScripts();
}
?>
<?php
// Note: The only JS file that is included in the head is jQuery. This
// is for $(document).ready which is used throughout the application
// for inline JS sections (to kick off some actions, depending on the
// individual pages). Additional JS files are loaded right before the
// </body> tag in base_footer.php for performance reasons.
//
// Also see:
// http://developer.yahoo.com/blogs/ydn/posts/2007/07/high_performanc_5/
//
// Note: when updating jQuery to an incompatible version, we also need
// to add the build number to the following include.
?>
<script type="text/javascript" src="<?php echo  r('js/fusioncharts.js') ?>"></script>
<?php
    $fusionTheme = class_exists('themes')
        ? themes::getFusionTheme()
        : 'fusion';
?>
<script type="text/javascript" src="<?php echo  r('js/fusioncharts.theme.' . $fusionTheme . '.js') ?>"></script>
<?php if (!empty($GI)) { ?>
    <script type="text/javascript">
        <?php echo  $GI->config->get('charting.obfuscated_license_script') ?>
    </script>
<?php } ?>
<script type="text/javascript" src="<?php echo  r('js/html2canvas.js') ?>"></script>
<script type="text/javascript" src="<?php echo  r('js/jquery.js') ?>"></script>
</head>
<?php if (isset($page_min_threshold)): ?>
	<?php if (!isset($page_min_width) || $page_min_threshold > $page_min_width): ?>
		<?php $page_min_width = $page_min_threshold ?>
	<?php endif ?>
<?php endif ?>
<?php if (isset($page_min_width)): ?>
<body style="min-width: <?php echo  $page_min_width ?>px" class="<?php echo  substr($themesuffix, 1) ?>">
<?php else: ?>
<body>
<?php endif ?>
