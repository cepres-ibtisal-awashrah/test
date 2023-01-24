<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

/**
 * TIME LIMIT
 *
 * We (practically) disable PHP's time limit to support requests that
 * may take longer than the usual PHP limit (30 seconds). Note that
 * this does not change the time limit of external dependencies such
 * as FastCGI.
 */

if (!defined('STARTED_WITH_CLI'))
{
	@set_time_limit(3600); // One hour 
}

/**
 * MAGIC QUOTES
 * 
 * Disable magic_quotes functionality of PHP. Note that this 'feature'
 * is deprecated in 5.3 and later but still works I guess. In addition
 * to the runtime quotes, we also need to take care of the $_GET,
 * $_POST and $_COOKIE globals which may have been escaped as well.
 */ 

if (get_magic_quotes_runtime())
{
	@set_magic_quotes_runtime(0);
}

if (get_magic_quotes_gpc())
{
	// "Sets the magic_quotes state for GPC (Get/Post/Cookie)
	//  operations. When magic_quotes are on, all ' (single-quote),
	//  " (double quote), \ (backslash) and NUL's are escaped with a
	//  backslash automatically."	
	$arrays = array(&$_GET, &$_POST, &$_COOKIE);

	if (ini_get('magic_quotes_sybase'))
	{
		// "If the magic_quotes_sybase directive is also ON it will
		//  completely override magic_quotes_gpc. Having both
		//  directives enabled means only single quotes are escaped
		//  as ''. Double quotes, backslashes and NUL's will remain
		//  untouched and unescaped."		
		for ($i = 0; $i < count($arrays); $i++)
		{
			$arr =& $arrays[$i];
			foreach ($arr as $k => $v)
			{
				$arr[$k] = str::replace($v, "''", "'");
			}
		}
	}
	else
	{
		for ($i = 0; $i < count($arrays); $i++)
		{
			$arr =& $arrays[$i];
			foreach ($arr as $k => $v)
			{
				$arr[$k] = str::replace(
					$v,
					array(
						'\\"',
						"\\'",
						"\\\0",
						'\\\\'
					),
					array(
						'"',
						"'",
						"\0",
						"\\"
					)
				);
			}
		}
	}
}

/**
 * REGISTER GLOBALS
 * 
 * Check if register_globals is enabled for this PHP environment
 * and remove all global variables which have been registered through
 * this option (thus, effectively turning register_globals off).
 */

if (ini_get('register_globals'))
{
	$arrays = array($_SERVER, $_ENV, $_FILES, $_COOKIE, $_POST,
		$_GET);
		
	if (isset($_SESSION))
	{
		$arrays[] = $_SESSION;
	}
	
	foreach ($arrays as $arr)
	{
		foreach ($arr as $k => $v)
		{
			unset($GLOBALS[$k]);
		}
	}
	
	ini_set('register_globals', false);
}

/**
 * MEMORY LIMIT
 * 
 * Check whether we need to adjust the memory limit for PHP. The
 * GI_MEMLIMIT constant may be set by the application during boot.
 * It is a good idea to use more than the default 8MB limit of PHP
 * nowadays. Changing the memory limit can be disabled by setting
 * GI_MEMLIMIT to false.
 */ 

define('GI_MEMLIMIT_DEFAULT', '134217728'); // 128M

if (!defined('GI_MEMLIMIT'))
{
	define('GI_MEMLIMIT', GI_MEMLIMIT_DEFAULT);
}

if (GI_MEMLIMIT)
{
	require_once SYSPATH . 'boot/mem.php';
	
	$cur_limit = mem::parse_limit(mem::get_limit());
	$new_limit = mem::parse_limit(GI_MEMLIMIT,
		GI_MEMLIMIT_DEFAULT);
	
	if ($cur_limit != -1) // Do not change unlimited
	{
		if ($cur_limit < $new_limit)
		{
			mem::set_limit($new_limit);
		}
	}
}

/**
 * TIMEZONE
 * 
 * Since PHP 5.3, all date functions generate a E_WARNING when no time
 * zone is set (was E_STRICT previously). They correctly use the local
 * time zone but every usage of a date function would issue a warning
 * message. We explicitly set the time zone to fix this.
 * date_default_timezone_get returns the local time of the server if
 * not overriden previously.
 */

$local_timezone = @date_default_timezone_get();
date_default_timezone_set($local_timezone);
