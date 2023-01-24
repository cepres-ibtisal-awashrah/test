<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

/**
 * OS
 *
 * Operating system dependent functions and routines for checking the
 * current operating system.
 */
final class os
{
	public static function is_win()
	{
		return DIRECTORY_SEPARATOR == '\\';
	}
	
	public static function is_unix()
	{
		return !self::is_win();
	}
}
