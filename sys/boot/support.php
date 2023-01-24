<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

/**
 * Support
 *
 * Contains functions for checking external dependencies and loaded
 * PHP modules. Used during the boot process to check whether all
 * required modules etc. are loaded and usable.
 */
final class support
{
	public static function sqlsrv($version = '1.0')
	{
		if (!os::is_win())
		{
			return false;
		}

		if ($version == '1.0')
		{
			return function_exists('sqlsrv_connect');
		}
		elseif ($version == '1.1')
		{
			// sqlsrv_num_rows was introduced in sqlsrv 1.1. I found
			// no official way to check the version (without a valid
			// connection resource, in this case you could leverage
			// sqlsrv_client_info).
			return function_exists('sqlsrv_num_rows');
		}

		return false;
	}

	public static function mysql()
	{
		return self::mysqlt() || self::mysqli();
	}

	public static function mysqlt() // Traditional
	{
		return function_exists('mysql_connect');
	}

	public static function mysqli() // Improved
	{
		return function_exists('mysqli_connect');
	}

	public static function ioncube()
	{
		return extension_loaded('ionCube Loader');
	}

	public static function curl()
	{
		return function_exists('curl_init');
	}

	public static function json()
	{
		return function_exists('json_encode');
	}

	public static function xml()
	{
		return extension_loaded('xml');
	}

	public static function cassandra()
	{
		return extension_loaded('cassandra');
	}

	public static function gd()
	{
		return extension_loaded('gd');
	}
}
