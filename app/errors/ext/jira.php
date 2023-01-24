<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php
process::$finished = true; // Clean exit
?>
<?php
header('HTTP/1.1 200 OK'); // Always 200 for max. browser/server compatibility
header('Content-Type: text/html; charset=UTF-8');
header('Expires: Sat, 01 Jan 2000 00:00:00 GMT');
header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<script type="text/javascript" src="<?php echo  r('js/jquery.js') ?>"></script>
	<script type="text/javascript" src="<?php echo  r('js/application.js') ?>"></script>
	<script type="text/javascript" src="<?php echo  r('js/application.jira.js') ?>"></script>
	<link rel="stylesheet" href="<?php echo  r("css/reset.css?1000") ?>" media="all" />
	<link rel="stylesheet" href="<?php echo  r("css/ext/jira-modern.css?1000") ?>" media="all" />
</head>
<body>
	<section id="content" class="ac-content">
		<?php if ($status_code == 401 && !$message): ?>
			<?php $login = isset($_GET['login']) ? $_GET['login'] : null ?>
			<?php if ($login !== 'hide'): ?>
				<p class="top"><em>You are not yet logged in to TestRail. 
				Please log in to use the integration.</em></p>
				<p class="bottom"><a class="button" href="<?php echo  url::site('auth/login') ?>" 
					target="_blank">Log in to TestRail</a></p>
			<?php endif ?>
		<?php else :?>
			<p style="margin: 0"><em><?php echo h( $message )?></em>
			<?php if (defined('DEPLOY_DEVELOP') && DEPLOY_DEVELOP): ?>
				at <?php echo h( $file )?>:<?php echo  $line ?>
			<?php endif ?>
			<p>
		<?php endif ?>
	</section>
	<?php $frame = isset($_GET['frame']) ? $_GET['frame'] : null ?>
	<?php if ($frame === 'tr-frame-panel-results' || $frame === 'tr-frame-panel-references' || $frame === 'tr-frame-panel-runsreferences'): ?>
	<script type="text/javascript">
	$(document).ready(
		function()
		{
			App.Jira.Frame.init('<?php echo  $frame ?>');
		}
	)
	</script>
	<?php endif ?>
</body>
</html>