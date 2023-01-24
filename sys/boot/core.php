<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

/**
 * Core functions that are assumed to be available everywhere, even
 * in case the actual framework stack or application cannot be loaded
 * (due to some missing dependencies, for instance).
 */ 
function h($s) // Escapes text
{
	return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

function a($s) // Escapes attributes
{
	return htmlspecialchars($s, ENT_COMPAT, 'UTF-8');
}

function r($s) // Resource url
{
	return DEPLOY_RESOURCE_URL . $s;
}

/**
 * Process
 *
 * Contains static variables to describe this php run ('unique' ID
 * for the client and whether the request is still active or was
 * already served).
 */
final class process
{
	public static $id;
	public static $finished = false;
	
	public static function init()
	{
		$r = rand(0, 99999999);
		self::$id = sprintf('%08d', $r);
	}
}

process::init(); // Set the random ID for this run
