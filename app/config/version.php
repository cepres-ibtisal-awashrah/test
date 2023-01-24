<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

$config['full'] = '7.5.3.1000';

if (preg_match('/(\d+)\.(\d+)\.(\d+)\.(\d+)/', $config['full'], $matches))
{
	$config['major'] = (int)$matches[1];
	$config['minor'] = (int)$matches[2];
	$config['release'] = (int)$matches[3];
	$config['build'] = (int)$matches[4];
}
