<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php
$page_css = 'error';
include APPPATH . 'views/layout/base_header.php';
?>

<div id="header-container">
	<div id="header">
		<div class="logo">
		</div>
		<div class="support">
			<div class="support-inner">
				Got any questions or need help?<br />
				<a href="<?php echo function_exists('lang') ? lang('link_support') : 'http://www.gurock.com/support/'; ?>" target="_blank"><?php echo function_exists('lang') ? lang('help_contact_support') : 'Contact Gurock Software support'; ?></a>
			</div>
		</div>
	</div>
</div>

<div id="content-container">
	<div id="content">
