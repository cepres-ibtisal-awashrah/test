<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

/**
 * SmartInspect for PHP
 * Copyright 2003-2011 Gurock Software GmbH. All rights reserved.
 * http://www.gurock.com/smartinspect/
 *
 * Requires PHP 4.3.0 or newer.
 * 
 * SmartInspect for PHP is a general purpose logging tool which helps
 * in debugging and monitoring PHP applications. The SmartInspect for
 * PHP library supports one simple but very useful feature: it can
 * send log messages to the SmartInspect Console viewer application,
 * either locally or to a remote Console on a different machine.
 *
 * The main focus for SmartInspect for PHP is on live-debugging web
 * applications and web sites. That's the reason why this library does
 * not contain any support for log files or other logging protocols.
 *
 * The SmartInspect library basically consists of two classes,
 * SmartInspect and SmartInspectSession. The SmartInspect class is
 * responsible for managing the logging status as well as the
 * connection to the SmartInspect Console. The SmartInspectSession
 * class, on the other hand, provides the actual log methods.
 * Multiple session objects can use the same SmartInspect object and
 * thus share the same connection.
 *
 * The usage is simple. You first create a new SmartInspect object
 * and pass the connection information for the Console, whether
 * logging should be enabled as well as some application specific
 * information:
 * 
 * $si = new SmartInspect(
 *   'Some web application', // The name of the web application
 *   'localhost',            // The host name of the Console
 *   4228,                   // The TCP port of the Console
 *   true);                  // Whether logging should be enabled
 *                           // right away
 *
 * Then you can create as many SmartInspectSession objects as you
 * like. Each session can have a different name and background color
 * in the SmartInspect Console for filtering and identification
 * purposes:
 * 
 * $main =& $si->addSession('Main');
 * $main->setColor(..); // Pass an RGB value
 * $db =& $si->addSession('Database');
 *
 * After creating the sessions, you can use the log methods as
 * follows:
 *
 * $main->logMessage('Some info message .. ');
 * $main->logError('Some error message .. ');
 * ..
 *
 * If you are finished with the SmartInspect and session objects,
 * call the setEnabled method of the SmartInspect objects like
 * this:
 *
 * $si->setEnabled(false);
 *
 * There are methods for logging simple messages with different
 * severities, entering and leaving methods, for logging variables,
 * for clearing the Console and for logging so called watches.
 * Watches are another way to log variable values. The Console
 * always displays the latest value for each variable and, in case
 * of a numeric variable, also a time graph with past values.
 *
 * The following log methods are currently available:
 *
 * logSeparator()                   - Logs a separator
 * enterMethod($method)             - Enters a method
 * leaveMethod($method)             - Leaves a method
 * logDebug($message)               - Logs a debug message
 * logVerbose($message)             - Logs a verbose message
 * logMessage($message)             - Logs an info message
 * logWarning($message)             - Logs a warning message
 * logError($message)               - Logs an error message
 * logFatal($message)               - Logs a fatal error
 * logValue($name, $value)          - Logs a variable value
 * logConditional($expr, $message)  - Logs a message if the $expr
 *                                    is true
 * logAssert($expr, $message)       - Logs an error if the $expr
 *                                    is false
 * clearAll()                       - Clears the Console
 * watchString($name, $value)       - Logs a string watch
 * watchInt($name, $value)          - Logs an integer watch
 * watchFloat($name, $value)        - Logs a float watch
 * watchBool($name, $value)         - Logs a boolean watch
 *
 * In addition to the object-oriented interface provided by the
 * SmartInspect and SmartInspectSession classes, this library also
 * contains a procedural interface wrapper. Instead of creating
 * instances of the SmartInspect and SmartInspectSession classes you
 * do the following:
 *
 * si_initialize('Some web application', 'localhost', 4228, true);
 * si_log_message('Some message ... ');
 * ...
 * si_shutdown();
 *
 * The wrapper maintains a single SmartInspect instance and one
 * associated so called 'main' session. All methods provided by the
 * procedural interface operate on these two objects. The procedural
 * interface somewhat mimics the SiAuto functionality of the other
 * SmartInspect libraries and makes it easier to work with a single
 * SmartInspect instance (and a single main session) across your entire
 * application (global variables as in the Delphi library are not an
 * option since they are cumbersome to use in PHP and static class
 * members or properties as in .NET or Java are not supported in PHP 4).
 * If needed, you can get the underlying objects as follows:
 *
 * $main =& si_get_session();
 * $si =& si_get_smartinspect();
 *
 * If you have any questions about SmartInspect in general or this
 * library, feel free to contact us at info@gurock.com. Also, learn
 * more about SmartInspect at:
 *
 * http://www.gurock.com/products/smartinspect/
 * http://blog.gurock.com/
 *
 * Changelog:
 * 0.2: - Changed default value of $enabled parameter in SmartInspect
 *        constructor to False in order to match the behavior of the
 *        other SmartInspect libraries
 *      - Combined enable/disable methods of the SmartInspect class to
 *        a single setEnabled method
 *      - Fixed reference handling in procedural interface wrapper
 * 0.1: - Initial beta 1 release.
 */

define("DEFAULTPORT", 4228);
define("DEFAULTSERVER", "localhost");
define("DEFAULTSESSION", "Main");
define("DEFAULTAPPNAME", "Auto");
define("DEFAULTCOLOR", 0xff000005);
define("CLIENTBANNER", "SmartInspect PHP Library v0.2\n");

class SmartInspectLogger
{
	private $_socket;
	private $_appName;
	private $_hostName;
	private $_enabled;
	private $_connected;
	private $_server;
	private $_port;
	private $_isUtf8;
	private $_encoding;

	public function __construct($appName = DEFAULTAPPNAME,
		$server = DEFAULTSERVER,
		$port = DEFAULTPORT,
		$enabled = false)
	{
		$this->_server = $server;
		$this->_port = $port;
		$this->_appName = $appName;
		$this->_enabled = $enabled;
		$this->_hostName = $this->_getHostName();
		$this->_connected = false;
		
		if ($this->_enabled)
		{
			$this->_connect();
		}

		$this->_isUtf8 = false;
	}
	
	public function _getHostName()
	{
		if (isset($_SERVER['SERVER_NAME']))
		{
			return $_SERVER['SERVER_NAME'];
		}
		else 
		{
			return '';
		}
	}

	public function addSession($name = DEFAULTSESSION)
	{
		return new SmartInspectSession($this, $name);
	}

	public function getAppName() 
	{
		return $this->_appName;
	}

	public function setAppName($name) 
	{
		$this->_appName = $name;
	}

	public function getEncoding()
	{
		return $this->_encoding;
	}

	public function setEncoding($encoding)
	{
		$this->_encoding = strtolower($encoding);
		$this->_isUtf8 = $this->_encoding == 'utf8' || 
			$this->_encoding == 'utf-8';
	}

	public function _connect()
	{
		if ($this->_connected)
		{
			return true;
		}
		
		$this->_socket = @fsockopen(
			$this->_server, 
			$this->_port, 
			$errno, 
			$errstring);

		if (!$this->_socket)
		{
			return false;
		}
		
		if (!fgets($this->_socket))
		{
			$this->_close();
			return false;
		}
		
		if (!fwrite($this->_socket, CLIENTBANNER))
		{
			$this->_close();
			return false;
		}
		
		$this->_connected = true;
		return true;
	}

	public function _close()
	{
		$this->_connected = false;

		if ($this->_socket) 
		{
			$socket = $this->_socket;
			$this->_socket = false;		
			return fclose($socket);
		}
		
		return true;
	}

	public function _disconnect() 
	{
		if (!$this->_connected)
		{
			return true;
		}
		else 
		{	
			return $this->_close();
		}
	}

	public function isConnected()
	{
		return $this->_connected;
	}

	public function isEnabled() 
	{
		return $this->_enabled;
	}
	
	public function setEnabled($enabled)
	{
		if ($enabled)
		{
			$this->_enable();
		}
		else 
		{
			$this->_disable();
		}
	}
	
	public function _enable() 
	{
		if (!$this->_enabled)
		{
			$this->_enabled = true;
			return $this->_connect();
		}
		else 
		{
			return true;
		}
	}

	public function _disable()
	{
		if ($this->_enabled)
		{
			$this->_enabled = false;
			return $this->_disconnect();
		}
		else 
		{
			return true;
		}
	}
	
	public function _sendPacket($packetType, 
		$data = null, 
		$dataLength = 0) 
	{
		/* Prepend the packet header (packet type and size) */
		$packet = pack("vl", $packetType, $dataLength);
		$packet .= $data;

		/* Write the packet to the console */
		if (!fwrite($this->_socket, $packet, $dataLength + 6))
		{
			$this->_close();
			return false;
		}
		
		/* Read the answer from the console */ 
		if (!fread($this->_socket, 2))
		{
			$this->_close();
			return false;
		}
				
		return true;
	}

	public function _getTimestamp()
	{
		$a = localtime(time());

		/* Years are 1900-based as returned by localtime(). */
		$a[5] += 1900;

		/* Months are 0-based as returned by localtime(), but gmmktime()
		 * expects 1-based. */
		$a[4]++;       

		/* Convert localtime() result to unix timestamp (seconds since
		 * 1970). */
		$time = gmmktime(
			$a[2], /* Hour */
			$a[1], /* Minute */
			$a[0], /* Second */
			$a[4], /* Month */
			$a[3], /* Day */
			$a[5]  /* Year */
		);
			
		/* Convert unix timestamp to Delphi's TDateTime for the Console */
		return ($time / 86400) + 25569;
	}
	
	public function _getColor($rgb)
	{
		if ($rgb == (int) DEFAULTCOLOR)
		{
			/* Default transparent background color */
			return $rgb;
		}
		else 
		{
			/* We use RGB colors here in this library, but the Console
			 * expects a BGR value (Delphi's TColor). */			 
			$b = $rgb & 0xff;
			$g = ($rgb >> 8) & 0xff;
			$r = ($rgb >> 16) & 0xff;
			return $b << 16 | $g << 8 | $r;
		}
	}
	
	public function _getString($string)
	{
		if ($this->_isUtf8)
		{
			return $string;
		}
		else 
		{
			return utf8_encode($string);
		}
	}
	
	public function sendLogEntry($sessionName, 
		$title, 
		$messageType, 
		$viewerId, 
		$color = 0, 
		$data = null) 
	{
		if (!$this->_connected)
		{
			return false;
		}
				
		if (!$this->_enabled)
		{
			return false;
		}
		
		/* Encode strings in UTF-8 format if needed */
		$appName = $this->_getString($this->_appName);
		$sessionName =  $this->_getString($sessionName);
		$title = $this->_getString($title);
		$hostName = $this->_getString($this->_hostName);
		
		if ($data)
		{
			/* Add a UTF-8 BOM in order to let Console detect the
			 * data encoding */
			$data = "\xEF\xBB\xBF" . $this->_getString($data);
			$dataLength = strlen($data);
		}
		else
		{
			$dataLength = 0;
		}
		
		/* Get the string lengths */
		$appNameLength = strlen($appName);
		$sessionLength = strlen($sessionName);
		$titleLength = strlen($title);
		$hostNameLength = strlen($hostName);

		/* Calculate the size of the packet body */
		$length = 4 * 10 + 8 + $appNameLength + $sessionLength +
			$titleLength + $hostNameLength + $dataLength;

		/* Pack the log entry into a single byte stream */
		$logEntry = pack("lllllllLLdl",
			$messageType,
			$viewerId,
			$appNameLength,
			$sessionLength,
			$titleLength,
			$hostNameLength,
			$dataLength,
			getmypid(), 
			0, /* No thread ID */
			$this->_getTimestamp(), 
			$this->_getColor($color)
		);

		/* Append the strings and data and send the packet */
		$logEntry .= $this->_appName . $sessionName . $title . 
			$this->_hostName;
			
		if ($data)		
		{
			$logEntry .= $data;
		}
			
		return $this->_sendPacket(4, $logEntry, $length);
	}

	public function sendControlCommand($controlCommandType) 
	{
		if (!$this->_connected)
		{
			return false;
		}
				
		if (!$this->_enabled)
		{
			return false;
		}

		$controlCommand = pack("ll", $controlCommandType, 0);			
		return $this->_sendPacket(1, $controlCommand, 8);
	}

	public function sendWatch($name, $value, $watchType) 
	{
		if (!$this->_connected)
		{
			return false;
		}
				
		if (!$this->_enabled)
		{
			return false;
		}

		/* Encode strings in UTF-8 format if needed */
		$name = $this->_getString($name);
		$value = $this->_getString($value);

		/* Get the string lengths */
		$nameLength = strlen($name);
		$valueLength = strlen($value);

		/* Calculate the size of the packet body */
		$length = $nameLength + $valueLength + 20;

		/* Pack the watch into a single byte stream */
		$watch = pack("llld", 
			$nameLength, 
			$valueLength, 
			$watchType,
			$this->_getTimestamp()
		);
		
		/* Append the strings and send the packet */
		$watch .= $name . $value;
		return $this->_sendPacket(5, $watch, $length);
	}
}

class SmartInspectSession
{
	private $_name;
	private $_parent;
	private $_color;
	private $_checkpoints;
	private $_counters;

	public function __construct(&$_parent, $_name)
	{
		$this->_name = $_name;
		$this->_parent =& $_parent;
		$this->resetColor();
	}

	public function getName() 
	{
		return $this->_name;
	}

	public function setName($name) 
	{
		$this->_name = $name;
	}

	public function getColor() 
	{
		return $this->_color;
	}

	public function resetColor() 
	{
		$this->_color = (int) DEFAULTCOLOR;
	}

	public function setColor($rgb)
	{
		$this->_color = $rgb;
	}
	
	public function logSeparator() 
	{
		return $this->_parent->sendLogEntry(
			$this->_name, 
			null, 
			0, 
			-1, 
			$this->_color);
	}

	public function enterMethod($method) 
	{
		return $this->_parent->sendLogEntry(
			$this->_name, 
			$method, 
			1, 
			0, 
			$this->_color);
	}

	public function leaveMethod($method) 
	{
		return $this->_parent->sendLogEntry(
			$this->_name, 
			$method, 
			2,
			0,
			$this->_color);
	}

	public function logDebug($message)
	{
		return $this->_parent->sendLogEntry(
			$this->_name,
			$message,
			107,
			0,
			$this->_color);
	}

	public function logVerbose($message)
	{
		return $this->_parent->sendLogEntry(
			$this->_name,
			$message,
			108,
			0,
			$this->_color);
	}

	public function logMessage($message)
	{
		return $this->_parent->sendLogEntry(
			$this->_name,
			$message,
			100,
			0,
			$this->_color);
	}

	public function logWarning($message)
	{
		return $this->_parent->sendLogEntry(
			$this->_name,
			$message,
			101,
			0,
			$this->_color);
	}
	
	public function logError($message) 
	{
		return $this->_parent->sendLogEntry(
			$this->_name,
			$message,
			102,
			0,
			$this->_color);
	}

	public function logFatal($message)
	{
		return $this->_parent->sendLogEntry(
			$this->_name,
			$message,
			109,
			0,
			$this->_color);
	}

	public function logValue($name, $value)
	{		
		$value = print_r($value, true);
		return $this->_parent->sendLogEntry(
			$this->_name,
			"$name = $value",
			105,
			1,
			$this->_color,
			$value);
	}
	
	public function logConditional($expr, $message)
	{
		if ($expr)
		{
			return $this->_parent->sendLogEntry(
				$this->_name,
				$message,
				110,
				0,
				$this->_color);
		}
		
		return true;
	}
	
	public function logAssert($expr, $message)
	{
		if (!$expr)
		{
			return $this->_parent->sendLogEntry(
				$this->_name,
				$message,
				111,
				0,
				$this->_color);
		}
		
		return true;
	}

	public function clearAll() 
	{
		return $this->_parent->sendControlCommand(3);
	}

	public function watchString($name, $value)
	{
		return $this->_parent->sendWatch(
			$name, 
			$value, 
			1);
	}
	
	public function watchInt($name, $value)
	{
		return $this->_parent->sendWatch(
			$name, 
			"$value", /* Convert to string */
			2);
	}
	
	public function watchFloat($name, $value)
	{
		return $this->_parent->sendWatch(
			$name, 
			"$value", /* Convert to string */
			3);
	}
	
	public function watchBool($name, $value)
	{
		return $this->_parent->sendWatch(
			$name, 
			$value ? "true" : "false", 
			4);
	}
}
