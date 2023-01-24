<?php

final class prereq
{
	public static function php()
	{
		$version = PHP_VERSION;

		if (!version_compare($version, '7.3.0', '>='))
		{
			errors::show(
				"You are using an unsupported PHP version ($version)",
				"Your PHP version is not supported ($version). Please
				upgrade to a newer PHP version on your server in order
				to use TestRail. Recommended PHP versions are 7.3 -
				7.4.x)."
			);
		}

		if (!version_compare($version, '7.5.0', '<'))
		{
			errors::show(
				"You are using an unsupported PHP version ($version)",
				"PHP 7.5.x or later is currently not supported by TestRail
				($version). We are working on supporting this new PHP
				version. In the meantime, please downgrade to a supported
				version of PHP (recommended are 7.3 - 7.4.x)."
			);
		}
	}

	public static function curl()
	{
		if (!support::curl())
		{
			errors::show(
				'The cURL PHP extension is not installed',
				'TestRail needs the cURL PHP extension to be installed
				on your web server. Please activate this extension in your
				PHP.ini in order to run TestRail.'
			);
		}
	}

	public static function ioncube()
	{
		if (!support::ioncube())
		{
			errors::show(
				'The ionCube PHP Loader is not installed',
				"TestRail needs the free ionCube PHP Loader to be installed
				on your web server. You can download the loader from
				ionCube's website for various platforms
				(http://www.ioncube.com/loaders.php). Please also take a
				look at our knowledge base article on how to install the
				ionCube PHP Loader
				(http://docs.gurock.com/testrail-admin/howto-installing-ioncube)"
			);
		}
	}

	public static function json()
	{
		if (!support::json())
		{
			errors::show(
				'The JSON PHP extension is not installed',
				'TestRail needs the JSON PHP extension to be installed
				on your web server. Please activate this extension in your
				PHP.ini in order to run TestRail.'
			);
		}
	}

	public static function xml()
    {
        if (!support::xml())
        {
            errors::show(
                'The xml PHP extension is not installed',
                'TestRail needs the xml PHP extension to be installed
				on your web server. Please activate this extension in your
				PHP.ini in order to run TestRail.'
            );
        }
    }


	public static function cassandra()
    {
        if (!support::cassandra()) {
            errors::show(
                'The Cassandra PHP driver is not installed',
                'Please install it and retry. You can get the driver
				(https://gurock.assembla.com/spaces/Drivers/git/source)'
			);
		}
	}

    public static function gd()
    {
        if (!support::gd()) {
            errors::show(
                'The GD PHP extension is not installed',
                'TestRail needs the GD PHP extension to be installed
                on your web server. Please activate this extension in your
                PHP.ini in order to run TestRail.'
            );
        }
    }

	private static function _config_define($name)
	{
		if (!defined($name) || !constant($name))
		{
			errors::show(
				"An important setting is not defined ($name)",
				"The configuration setting '$name' hasn't been defined.
				Please check your config.php and make sure that this
				configuration setting is defined."
			);
		}
	}

	public static function config()
	{
		self::_config_define('DB_DRIVER');
		self::_config_define('DB_HOSTNAME');
		self::_config_define('DB_DATABASE');
		self::_config_define('DB_USERNAME');
		self::_config_define('DB_PASSWORD');
	}

	public static function db()
	{
		$driver = str::to_lower(DB_DRIVER);
		if (DB_DRIVER == 'sqlsrv')
		{
		  	if (!support::sqlsrv())
			{
				errors::show(
					'Unsupported database driver specified (sqlsrv)',
					'You have specified MS SQL Server as your database
					driver, but this database engine isn\'t supported by
					your PHP configuration or server platform. Please
					make sure that the required PHP extensions are
					installed.'
				);
			}

		  	if (!support::sqlsrv('1.1'))
			{
				errors::show(
					'Unsupported database driver version (sqlsrv)',
					'You have specified MS SQL Server as your database
					driver, but the version of your database driver
					(sqlsrv) is too old. Please update the sqlsrv PHP
					extension. The minimum required version of sqlsrv
					for TestRail is 1.1.'
				);
			}
		}
		else if (DB_DRIVER == 'mysql')
		{
			if (!support::mysql())
			{
				errors::show(
					'Unsupported database driver specified (mysql)',
					'You have specified MySQL as your database driver,
					but this database engine isn\'t supported by your
					PHP configuration or server platform. Please make
					sure that the required PHP extensions are
					installed.'
				);
			}

			// For PHP < 7.0, we only support the traditional 'mysql'
			// driver (not mysqli).
			if (!support::mysqlt())
			{
				if (version_compare(PHP_VERSION, '7.0.0', '<'))
				{
					errors::show(
						'Unsupported database driver specified (mysql)',
						'You have specified MySQL as your database driver,
						but this database engine isn\'t supported by your
						PHP configuration or server platform. For PHP <
						7.0, TestRail requires the \'mysql\' extension
						(not \'mysqli\'). Please make sure that the
						required PHP extensions are installed.'
					);
				}
			}
		}
		else
		{
			errors::show(
				"Invalid database driver specified ($driver)",
				'You have specified a database driver in your config.php
				that is not supported by TestRail. Please use \'sqlsrv\'
				for MS SQL Server or \'mysql\' for MySQL databases.'
			);
		}
	}
}

/**
 * PREREQUISITES
 *
 * Check the prerequisites of TestRail and exit in case they are not
 * available. This is also the place where we load the configuration
 * file when available. We do a file_exists check before including
 * the config because we've seen reports where the @include succeeded
 * even without an actual config (very rare and likely related to PHP
 * error behavior configuration). The file_exists check would catch
 * this.
 */

prereq::php();
prereq::ioncube();
prereq::curl();
prereq::json();
prereq::xml();
prereq::cassandra();
prereq::gd();

if (defined('CONFIGPATH')) {
  $config = CONFIGPATH . '/config.php';
} else {
  $config = ROOTPATH . '/config.php';
}

if (file_exists($config) && @include($config))
{
	prereq::config();
	prereq::db();
}
else
{
	if (file_exists($config . '.txt'))
	{
		errors::show(
			'Configuration not found (but config.php.txt exists)',
			'TestRail hasn\'t found a valid configuration file
			(config.php) but noticed a config.php.txt. A common
			issue on Windows systems is to save the TestRail
			configuration to a config.php.txt file instead of
			config.php. Please rename config.php.txt to config.php
			and refresh this page.'
		);
	}
}

/**
 * CONSTANT DEFAULTS
 *
 * Set some defaults for defines that are not specified in the config
 * file but required for TestRail to operate correctly.
 */

$defines = array('DEPLOY_DEVELOP', 'DEBUG_ENABLED');

foreach ($defines as $def)
{
	if (!defined($def))
	{
		define($def, false);
	}
}

/**
 * APPLICATION CONSTANTS
 *
 * Include important application constants that should be available in
 * the entire application.
 */

require_once APPPATH . 'config/consts.php';
