<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

/**
 * Mem
 *
 * Contains functions for getting and setting the memory limit of
 * PHP. Is used during the boot process to ensure a minimum level of
 * accessible memory for the application.
 */
final class mem
{
	public static function get_limit()
	{
		$limit = ini_get('memory_limit');
		return $limit ? $limit : 8388608; // Default is '8M'
	}
	
	public static function parse_limit($limit, $default = false)
	{
		if (!preg_match('/(-?\d+)(\w+)?/', $limit, $matches))
		{
			return $default ? $default : 8388608;
		}

		$bytes = (int) $matches[1]; // The int value

		if (isset($matches[2]))
		{
			switch (str::to_upper($matches[2]))
			{
				case 'K':
					$bytes *= 1024;
					break;
					
				case 'M':
					$bytes *= 1024 * 1024;
					break;
					
				case 'G':
					$bytes *= 1024 * 1024 * 1024;
					break;
			}
		}

		return $bytes;
	}

	public static function set_limit($limit)
	{
		return ini_set('memory_limit', $limit);
	}
}
