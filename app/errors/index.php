<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

require APPPATH . 'config/version.php';

// Make the version information available for error reports.
$version = $config['full'];

if (defined('STARTED_WITH_CLI'))
{
	require APPPATH . 'errors/cli.php';
}
else 
{
	$is_ajax = false;
	
	// We cannot use the request class here (request::is_ajax) because
	// an error may occur too early in the boot process to load this
	// class (e.g., when the requested controller does not exist). The
	// same applies to our str:: class so we need to use the regular
	// string functions here.
	
	if (isset($_SERVER['HTTP_X_REQUESTED_WITH']))
	{
		$requested_with = $_SERVER['HTTP_X_REQUESTED_WITH'];
		if (strtolower($requested_with) == 'xmlhttprequest') // sic!
		{
			$is_ajax = true;
		}
	}
	
	$is_api = false;

	$query = trim($_SERVER['QUERY_STRING'] ?? '', '/');
	if (strpos($query, 'api/v2') === 0) {
		$is_api = true;
	}

	if (isset($_SERVER['CONTENT_TYPE']))
	{
		$content_type = strtolower($_SERVER['CONTENT_TYPE']); // sic!
		if ($content_type == 'application/json' ||
			$content_type == 'application/json;charset=utf-8' ||
			$content_type == 'application/json; charset=utf-8')
		{
			$is_api = true;
		}
	}

	$is_hosted = defined('DEPLOY_HOSTED') && DEPLOY_HOSTED;

	if ($is_ajax)
	{
		header('HTTP/1.1 200 OK');
		require APPPATH . 'errors/ajax.php';
	}
	else
	{
		// In the UI case, we output the safer 200 OK as some servers
		// (e.g. IIS) may not display our HTML page otherwise (they may
		// replace this with a generic system error page). We only do
		// this on non-Unix systems (Windows/IIS) and UI requests (can
		// also be overriden per custom error layout, see ext/jira.php
		// for an example).

		if ($is_api || os::is_unix())
		{
			switch ($status_code)
			{
				case 400:
					header('HTTP/1.1 400 Bad Request');
					break;

				case 401:
					header('HTTP/1.1 401 Unauthorized');
					break;

				case 403:
					header('HTTP/1.1 403 Forbidden');
					break;

				case 404:
					header('HTTP/1.1 404 File Not Found');
					break;

				case 500:
					header('HTTP/1.1 500 Internal Server Error');
					break;

				case 503:
					header('HTTP/1.1 503 Service Unavailable');
					break;				

				default:
					header('HTTP/1.1 200 OK');
					break;
			}
		}
		else
		{
			header('HTTP/1.1 200 OK');
		}
	
		$view = null;

		if ($is_api)
		{
			$view = 'api';
		}
		else 
		{
			// In case we deal with a custom error layout, we use this
			// as our error view (e.g. 'ext/jira'). In all other cases,
			// we return either our standard HTML error page or generic
			// maintenance page (if we deal with a generic 503 error +
			// no message and are running on TestRail Cloud, also see
			// base controller: _connect_to_database).

			if (isset($layout) && $layout)
			{
				$view = $layout;
			}
			else 
			{
				if ($is_hosted && $status_code == 503 && !$message)
				{
					$view = 'html_maint';
				}
				else 
				{
					$view = 'html';
				}
			}
		}

		if ($view)
		{
			require APPPATH . "errors/$view.php";
		}
	}
}
