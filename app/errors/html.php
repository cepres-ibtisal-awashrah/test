<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php
$page_title = $message;
require APPPATH . 'views/layout/error_header.php';
?>

<?php
$report .= sprintf("---\nVersion: %s", $version);
?>

<?php if ($status_code == 404): ?>
	<?php $title = '404 - Not Found' ?>
<?php elseif ($status_code == 403): ?>
	<?php $title = '403 - Access Denied' ?>
<?php else: ?>
	<?php $title = 'An Error Occurred' ?>
<?php endif ?>

<h1><?php echo h( $title )?></h1>

<h2><?php echo h( $message )?></h2>

<?php if (isset($details) && $details): ?>
<p class="text-monospace"><?php echo h( $details )?></p>
<?php endif ?>

<p><?php echo function_exists('lang') ? lang('error_headline') : 'If you believe this is an error that shouldn\'t happen, please send this error report to Gurock Software. You can optionally enter your email address below and a Gurock Software support engineer will contact you shortly.'; ?></p>

<form target="_blank" method="post" action="<?php echo function_exists('lang') ? lang('link_secure_support') : 'https://secure.gurock.com/customers/support'; ?>">
	<div class="form-group">
		<label for="email">Email Address (optional):</label>
		<input size="35" type="text" name="email" id="email"
			class="form-control form-control-small" />
	</div>
	
	<input type="hidden" name="_token" value="dsHdHAyUyfvUb9DQ6u2T2A29" />
	<input type="hidden" name="first_name" value="NA" />
	<input type="hidden" name="last_name" value="NA" />
	<input type="hidden" name="subject" value="2" />
	<input type="hidden" name="message" value="<?php echo a( $report )?>" />

	<input type="submit" value="Send Error Report" class="button button-ok button-positive" />	
	<span id="backtrace-show" class="font-smaller">
		<a href="javascript:showBacktrace()">What is sent?</a>
	</span>
</form>

<div id="backtrace" class="report hidden">
<p><?php echo nl2br( h( $report ) )?></p>
</div>

<script type="text/javascript">
var showBacktrace = function()
{
	$('#backtrace-show').hide();
	$('#backtrace').show();
}

$(document).ready(function()
{
	$('form').submit(function()
	{
		var email = $('#email');
		if (!$.trim(email.val()))
		{
			email.val('<?php echo function_exists('lang') ? lang('link_support_email') : 'testrail@gurock.com'; ?>');
		}
	});

	if (parent && parent.showReport)
	{
		parent.showReport();
	}
});
</script>

<?php 
require APPPATH . 'views/layout/error_footer.php';
?>
