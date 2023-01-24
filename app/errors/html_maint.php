<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php
$page_title = 'Account is in maintenance mode';
require APPPATH . 'views/layout/error_header.php';
?>

<h1><?php echo h( $page_title )?></h1>

<p class="bottom">Sorry, but your TestRail account is currently in maintenance mode.
Please try again in a few minutes.</p>

<?php 
require APPPATH . 'views/layout/error_footer.php';
?>