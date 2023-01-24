<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

if (defined('DEPLOY_DEVELOP') && DEPLOY_DEVELOP)
{
	echo "$message at $file:$line\n";
}
else 
{
	echo "$message\n";
}
