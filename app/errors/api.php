<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

if ($message)
{
	if (defined('DEPLOY_DEVELOP') && DEPLOY_DEVELOP)
	{	
		api::return_error($message . " at $file:$line");
	}
	else 
	{
		api::return_error($message);
	}
}
else 
{
	api::return_error();
}
