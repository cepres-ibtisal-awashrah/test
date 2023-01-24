<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

/**
 * Errors
 *
 * Error handling related functions and routines. Redirects and displays
 * errors on the application specific error page.
 */
final class errors
{
	private static $_layout = null;
	private static $_ob_level;	
	
	public static function init()
	{
		ini_set('display_errors', 0);
		self::$_ob_level = ob_get_level();
		self::_try_show_last(); // May catch PHP startup errors early
		register_shutdown_function(array('errors', 'shutdown'));
	}

	public static function set_layout($layout)
	{
		self::$_layout = $layout;
	}

	public static function get_layout()
	{
		return self::$_layout;
	}
	
	/**
	 * Show
	 *
	 * Shows the specified error on the application specific error page
	 * and exits the current request. Generates an error report based
	 * on the current environment and passes it to the error page along
	 * with the error details given by the caller.
	 */
	public static function show(
		$message,
		$details = null,
		$file = null,
		$line = 0,
		$status_code = 500,
		$trace = null)
	{
		// We discard all previous output that was generated by views
		// to show a clean error page (just like in ASP.NET with the
		// yellow page, e.g.). We obviously do not want to display an
		// error page inside another page.
		while (ob_get_level() > self::$_ob_level)
		{
			@ob_end_clean();
		}
		
		if (!$trace)
		{
			$trace = self::format_trace(debug_backtrace());
		}
		else
		{
			// Use the passed trace (for example, a call trace by an
			// exception) which is often more precise/meaningful than
			// calling debug_backtrace here ourselves.
			$trace = self::format_trace($trace);
		}
		
		// Generate and format the report for the error page.
		$report = self::format_report(
			$message,
			$details,
			$file,
			$line,
			$status_code,
			$trace
		);
		
		$layout = self::$_layout; // Bring layout into scope

		/**
		 * Try to load translations using GI
		 */
		if (class_exists ('Services')) { 
		   try {
		 	$loader = Services::get('loader_core');
			$i18n = $loader->library('i18n');
			$i18n->set_fallback_language();
			$i18n->set_fallback_locale();
			$translations = $loader->library('translations');
			$controller = obj::create();
			$controller->translations = $translations;
			Gizmo::set($controller);
		    } catch (Exception $exception) {
		  	true; // Do nothing
		    }
		}

		process::$finished = true;
		require APPPATH . 'errors/index.php';
		
		die(1);
	}
	
	/**
	 * Format Trace
	 *
	 * Formats the given call trace and returns the result. Each stack
	 * frame gets its own line and includes the caller (class and/or
	 * function as well as file and source code line, if available).
	 */	 
	public static function format_trace($trace)
	{
		$result = '';
		
		foreach ($trace as $frame)
		{
			if (isset($frame['class']))
			{
				$caller = $frame['class'] . $frame['type'] . 
					$frame['function'];
			}
			else 
			{
				$caller = $frame['function'];
			}
			
			if (isset($frame['file']))
			{			
				$file = basename($frame['file']);
			}
			else 
			{
				$file = '<unknown>';
			}

			$line = isset($frame['line']) ? $frame['line'] : '<unknown>';			
			$result .= "\nat $caller ($file:$line)";
		}
		
		return $result;
	}
	
	/**
	 * Format Report
	 *
	 * Creates and formats an error report ready to be displayed. Uses
	 * the passed arguments and current request environment to generate
	 * the report and returns the report as string.
	 */	 	
	public static function format_report(
		$message,
		$details,
		$file,
		$line,
		$status_code,
		$trace)
	{
		$report = "$message\n";
		
		$vars = array(
			'Details' => $details,
			'File' => $file,
			'Line' => $line,
			'Status Code' => $status_code,
			'Host' => self::_get_server_variable('HTTP_HOST'),
			'Uri' => sprintf(
				"%s (%s)",
				self::_get_server_variable('REQUEST_URI'),
				self::_get_server_variable('REQUEST_METHOD')
			),
			'---',
			'Browser' => self::_get_server_variable('HTTP_USER_AGENT')
		);

		// The DEPLOY_DEBUG_SERVER define configures if server details
		// are included in the error report. This is used to disable
		// information leaks about the hosted platform, e.g.
		if (!defined('DEPLOY_DEBUG_SERVER') || DEPLOY_DEBUG_SERVER)
		{
			$vars = array_merge(
				$vars,
				array(
					'PHP' => phpversion(),
					// Same as php_uname('a') but without host
					'Server' => sprintf( 
						'%s %s %s %s',
						php_uname('s'),
						php_uname('r'),
						php_uname('v'),
						php_uname('m')
					)
				)
			);
		}
		
		$report .= "---\n";
		foreach ($vars as $k => $v)
		{
			if (is_string($k))
			{
				$report .= "$k: ";
				$report .= $v ? $v : '<missing>';
				$report .= "\n";
			}
			else 
			{
				$report .= "$v\n";
			}
		}
		
		if (isset($_POST) && count($_POST) > 0)
		{
			$report .= "---\n";
			foreach ($_POST as $k => $v)
			{
				$report .= "$k: ";
				
				if ($v)
				{
					// Do not include passwords in the log/report. We
					// cannot use our str:: class here because it might
					// not be available at this point (errors can also
					// occur while trying to load the str class).
					if (strpos($k, 'password') === false &&
						strpos($k, 'confirm') === false)
					{
						$report .= is_array($v) ? 
							trim(print_r($v, true)) : 
							$v;
					}
					else 
					{
						$report .= '<hidden>';
					}
				}
				else
				{
					$report .= '<empty>';
				}
				
				$report .= "\n";
			}
		}	
		
		if ($trace)
		{
			$report .= "---\nTrace:";

			if (is_array($trace))
			{
				$trace = self::format_trace($trace);				
			}

			$report .= "$trace\n";
		}
		
		return $report;
	}
	
	private static function _get_server_variable($name)
	{
		return isset($_SERVER[$name]) ? $_SERVER[$name] : '';
	}

	/**
	 * Shutdown
	 *
	 * Checks for any errors that have occurred during the request and
	 * displays them. This shutdown function allows us to catch those
	 * error messages that are not passed to an error handler set via
	 * set_error_handler such as PARSE errors or calling functions that
	 * don't exist. Only works with PHP 5.2 and later.
	 */
	public static function shutdown()
	{
		if (process::$finished)
		{
			// In case we've already displayed an error, we exit right
			// away. This shutdown function is always called (even if
			// we exit explicitly with die/exit as in self::show) and
			// we do not want to display the error twice.
			return true;
		}
	
		return self::_try_show_last();
	}

	private static function _try_show_last()
	{		
		if (function_exists('error_get_last')) // 5.2 and later only
		{
			$error = error_get_last();
		}
		else 
		{
			$error = null;
		}
		
		if (!$error)
		{
			return true;
		}
		
		$report = false;
		
		// We only display a specific set of error messages here. For
		// example, we ignore all E_NOTICE errors.
		switch ($error['type'])
		{
			case E_ERROR:
			case E_PARSE:
			case E_CORE_ERROR:
			case E_COMPILE_ERROR:
				$report = true;
				break;
		}
			
		if (!$report)
		{
			return true;
		}
		
		if (isset($error['file']) && $error['file'])
		{
			$file = $error['file'];
		}
		else 
		{
			$file = '<unknown>';
		}
		
		if (isset($error['line']) && $error['line'])
		{
			$line = $error['line'];
		}
		else 
		{
			$line = '<unknown>';
		}

		$message = $error['message'];
		$message = "PHP error: $message in $file at $line";	
		self::show($message, null, $file, $line);
		
		return true;
	}
}

errors::init();