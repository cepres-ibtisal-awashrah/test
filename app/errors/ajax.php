<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

if ($message)
{
	if (defined('DEPLOY_DEVELOP') && DEPLOY_DEVELOP)
	{
		ajax::return_error($message . " at $file:$line");
	}
	else 
	{
		ajax::return_error($message);
	}
}
else 
{
	ajax::return_error();
}
