<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php 

$names = array('en' => 'English');

if (file_exists(CUSPATH . 'config/languages.php'))
{
	include(CUSPATH . 'config/languages.php');
	
	if (isset($languages))
	{
		$names = array_merge($names, $languages);
	}
}

$config['names'] = $names;
