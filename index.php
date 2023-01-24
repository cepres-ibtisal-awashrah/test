<?php

/**
 * PHP ERRORS
 *
 * The php error reporting level. We want all significant errors to
 * be shown, including E_STRICT. We exclude E_DEPRECATED through,
 * because we need to use some deprecated functions to disable
 * certain PHP features that are deprecated but still work (think
 * magic_quotes).
 */

if (defined('E_DEPRECATED'))
{
	error_reporting((E_ALL | E_STRICT) & ~E_DEPRECATED);
}
else
{
	error_reporting(E_ALL | E_STRICT);
}

/**
 * CONSTANTS
 *
 * Mission-critical application and system constants are the first
 * thing to set up. These constants include:
 *
 * ROOTPATH      - The full server path to the root folder
 * EXT           - The file extension.  Typically ".php"
 * SYSPATH       - The full server path to the "system" folder
 * APPPATH       - The full server path to the "application" folder
 * VENPATH       - The full server path to the "vendors" folder
 */

define('ROOTPATH', dirname(__FILE__) . '/');
define('EXT', '.php');
define('SYSPATH', ROOTPATH . 'sys/');
define('APPPATH', ROOTPATH . 'app/');
define('VENPATH', ROOTPATH . 'vendors/');

if (!defined('CONTROLLERS')) // May already be set by test.php
{
	define('CONTROLLERS', 'controllers/');
}

if (defined('DEPLOY_CUSTOM_PATH'))
{
	define('CUSPATH', DEPLOY_CUSTOM_PATH);
}
else
{
	define('CUSPATH', ROOTPATH . 'custom/');
}

if (defined('DEPLOY_EXPORT_PATH'))
{
	define('EXPPATH', DEPLOY_EXPORT_PATH);
}
else
{
	define('EXPPATH', ROOTPATH . 'exports/');
}

if (!defined('DEPLOY_RESOURCE_URL'))
{
	define('DEPLOY_RESOURCE_URL', '');
}

/**
 * CORE HELPERS
 *
 * The next thing we do is to include some helpers that are required
 * during the boot process (and elsewhere in the framework or app)
 * or do some initializing work (setting up the PHP environment, for
 * instance).
 */ 

require_once(SYSPATH . 'boot/core.php');
require_once(SYSPATH . 'boot/os.php');
require_once(SYSPATH . 'boot/errors.php');
require_once(SYSPATH . 'boot/str.php');
require_once(SYSPATH . 'boot/env.php');
require_once(SYSPATH . 'boot/support.php');

/** 
 * APP-SPECIFIC
 *
 * If the application-specific file exists, we load it and the app
 * can check its required dependencies, load and validate its config
 * file and so on.
 */

if (getenv('TR_CONFIGPATH')) {
  define('CONFIGPATH',getenv('TR_CONFIGPATH'));
} 
else 
{
  define('CONFIGPATH',ROOTPATH);
}
 
$application = APPPATH . 'boot/index.php';
if (file_exists($application))
{
	require_once $application;
}

/**
 * GIZMO
 *
 * After initializing the framework and letting the application check
 * its requirements, we load the actual Gizmo framework.
 */
 
require_once(SYSPATH . 'core/gizmo.php');
