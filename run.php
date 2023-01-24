<?php

function _usage()
{
	echo "Usage: php run.php <routine>\n";
	echo "Supported routines:\n";
	echo "- update: Upgrades a TestRail database to the latest version\n";
	die(1);
}

if (php_sapi_name() != 'cli' || isset($_SERVER['REMOTE_ADDR']))
{
	// The tools are not allowed to be run via browser. They should
	// only be started via command line.
	die('Access denied.');
}

if ($argc <= 1)
{
	_usage();
}
else 
{
	array_shift($argv);
}

$tool = $argv[0];

// Check for list of supported routines/controllers (currently only
// 'update').
if ($tool != 'update')
{
	_usage();
}

@set_time_limit(0);
define('STARTED_WITH_CLI', true);
$_GET['tools/' . $tool] = true; // Set the controller to invoke

// And finally include the standard index.php of TestRail
require_once dirname(__FILE__) . '/' . 'index.php';
