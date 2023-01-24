<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

/**
 * Str
 *
 * String related functions and routines for operating on strings.
 * Expects UTF-8 encoded strings and is completely UTF-8 aware. This
 * class replaces and extends the built-in PHP string functions.
 *
 * Note: needs support for mbstring PHP extension and UTF-8 package
 * (vendors/utf8). Availability is automatically checked at the end
 * of this file.
 */
final class str
{
	public static function is_valid($s)
	{
		return utf8_is_valid($s);
	}

	public static function ends_with($s, $test)
	{
		if ($test === null)
		{
			return false;
		}
		
		$len = str::len($test);
		return $len ? str::sub($s, -$len) === $test : true;
	}

	public static function starts_with($s, $test)
	{
		if ($test === null)
		{
			return false;
		}

		return str::sub($s, 0, str::len($test)) === $test;
	}
	
	public static function is_empty($s, $trim = true)
	{
		if ($s === null || $s === '')
		{
			return true;
		}
		
		if ($trim)
		{
			return str::trim($s) === '';
		}
		else 
		{
			return false;
		}
	}
	
	public static function sub($s, $start, $len = false)
	{
		return utf8_substr($s, $start, $len);
	}
	
	public static function slash($s)
	{
		if ($s === null || $s === '')
		{
			return '/';
		}
		
		$len = str::len($s);
		if (str::sub($s, $len - 1) != '/')
		{
			$s .= '/';
		}
		
		return $s;
	}
	
	public static function len($s)
	{
		return utf8_strlen($s);
	}

	public static function contains($s, $search)
	{
		return self::pos($s, $search) !== false;
	}
	
	public static function pos($s, $search, $offset = false)
	{
		if ($s === null || $search === null)
		{
			return false;
		}
		
		if ($search === '')
		{
			if ($offset)
			{
				return str::len($s) > $offset ? $offset : false;
			}
			else 
			{
				return 0;
			}
		}
		
		return utf8_strpos($s, $search, $offset);
	}
	
	public static function rpos($s, $search, $offset = false)
	{
		if ($s === null || $search === null)
		{
			return false;
		}
		
		if ($search === '')
		{
			$len = str::len($s);
			
			if ($offset)
			{
				return $len >= $offset ? $len : false;
			}
			else 
			{
				return $len;
			}
		}

		if ($s === '')
		{
			return false;
		}

		return utf8_strrpos($s, $search, $offset);
	}
	
	public static function to_lower($s)
	{
		return utf8_strtolower($s);
	}

	public static function to_upper($s)
	{
		return utf8_strtoupper($s);
	}
	
	public static function replace($s, $search, $replace)
	{
		// "This works because every complete character sequence in a
		// UTF-8 string is unique (cannot be mistaken as part of a
		// longer sequence)."
		// http://www.phpwact.org/php/i18n/utf-8#str_replace
		return str_replace($search, $replace, $s);
	}
	
	public static function trim($s)
	{
		return trim($s);
	}

	public static function ltrim($s)
	{
		return ltrim($s);
	}

	public static function rtrim($s)
	{
		return rtrim($s);
	}
	
	public static function split($s, $sep)
	{
		if ($sep === null || $sep === '')
		{
			return false;
		}

		// "This works because every complete character sequence in a
		// UTF-8 string is unique (cannot be mistaken as part of a
		// longer sequence)."
		// http://www.phpwact.org/php/i18n/utf-8#explode
		return explode($sep, $s);
	}

	public static function split_lines($s)
	{
		return preg_split('/(\r\n)|\r|\n/u', self::trim($s));
	}
	
	public static function join($arr, $sep)
	{
		return implode($sep, $arr);
	}

	public static function join_lines($arr)
	{
		return self::join($arr, "\n");
	}
	
	public static function repeat($s, $multiplier)
	{
		if ($s === null || !$multiplier)
		{
			return '';
		}
		
		switch ($multiplier)
		{
			case 1:
				return $s;
			case 2:
				return $s . $s;
			case 3:
				return $s . $s . $s;
		}
		
		$r = '';
		
		for ($i = 0; $i < $multiplier; $i++)
		{
			$r .= $s;
		}
		
		return $r;
	}
	
	public static function format($format)
	{
		$args = func_get_args();
		$format = array_shift($args);
		return str::formatv($format, $args);
	}
		
	public static function formatv($format, $args)
	{
		$result = '';

		// This function makes sure to use forward-only replacements.
		// I.e., it is not vulnerable to the following left-to-right
		// replacement issue:
		//
		// $format: '{0} {1}'
		// $args: ['{1}', 'foo']
		// -> 'foo foo'
		//
		// Instead, this function correctly returns '{1} foo'.

		$ix = '';
		$in_brackets = false;
		$len = strlen($format); // byte count, revisit for PHP6!

		$i = 0;
		while ($i < $len)
		{
			$c = $format[$i];

			if ($c == '{')
			{
				// A new placeholder starts. We first get the string
				// between the opening and closing brackets. This may
				// be a simple numeric placeholder or a more complex
				// plural/singular replacement pattern.
				
				$open = 0;
				$between = '';
				$is_numeric = true;
				$is_valid = true;

				$j = $i;
				while ($j < $len && $is_valid)
				{
					$d = $format[$j];

					if ($d == '{')
					{
						$open++;
						if ($open == 1)
						{
							$j++;
							continue;
						}
					}
					elseif ($d == '}')
					{
						$open--;
						if (!$open)
						{
							break;
						}
					}
					elseif ($is_numeric)
					{
						$n = ord($d);
						if ($n < 48 || $n > 57)
						{
							$is_numeric = false;

							// If the first character after the opening
							// bracket is not a number, we do not deal
							// with a placeholder.
							if ($j == $i + 1)
							{
								$is_valid = false;
							}
						}
					}

					$between .= $d;

					if ($is_valid)
					{
						$j++;
					}
				}

				if ($open > 0)
				{
					// If the brackets are not closed, we also do not
					// deal with a valid placeholder.
					$is_valid = false;
				}

				if ($is_valid)
				{
					if ($is_numeric)
					{
						// A simple numeric replacement such as {0}
						$ix = (int) $between;
						if (isset($args[$ix]))
						{
							$result .= $args[$ix];
						}
					}
					elseif (preg_match(
						'/(\d+)\?\{(.*?)\}:\{(.*?)\}/u',
						$between,
						$matches))
					{
						// A complex plural/singular pattern such as
						// {0?{Foos}:{Foo}}					
						$ix = (int) $matches[1];
						if (isset($args[$ix]))
						{
							$arg = $args[$ix];
							if ($arg == 1)
							{
								$result .= $matches[3];
							}
							else 
							{
								$result .= $matches[2];
							}
						}
					}
					else 
					{
						// No match, just appended to the output	
						$result .= '{' . $between . '}';
					}
				}
				else 
				{
					$result .= '{' . $between;
				}

				$i = $j;
			}
			else
			{
				$result .= $c;
			}

			$i++;
		}
		
		return $result;
	}

	public static function formatn($format, $vars)
	{
		if (!$vars)
		{
			return $format;
		}

		$t = array();
		foreach ($vars as $key => $value)
		{
			$t['%{' . $key . '}'] = $value;
		}
		
		return self::replace($format, array_keys($t), array_values($t));
	}
	
	public static function formatl($items, $format, $separator = ' ')
	{
		if (!$items)
		{			
			return '';
		}
		
		if (is_string($items))
		{
			if (str::is_empty($items))
			{
				return '';
			}
			else 
			{
				$items = preg_split('/,+/u', $items);
			}
		}
		
		$result = '';
		
		foreach ($items as $i)
		{
			$i = self::trim($i);
			
			if ($i === '')
			{
				continue;
			}

			if ($result)
			{
				$result .= $separator;
			}
			
			$result .= self::format($format, $i);
		}
		
		return $result;
	}
	
	public static function shorten($str, $max_length = 20)
	{
		$length = self::len($str);
		
		if ($length <= $max_length)
		{
			return $str;
		}
		
		if ($max_length <= 2)
		{
			return self::sub($str, 0, $max_length);
		}
		
		if (($max_length & 1) == 0)
		{
			$prefix_length = $max_length / 2;
			$suffix_length = $max_length / 2;
		}
		else
		{
			$prefix_length = ($max_length + 1) / 2;
			$suffix_length = ($max_length - 1) / 2;	
		}

		return self::sub($str, 0, $prefix_length - 1) . '..' .
			self::sub($str, $length - ($suffix_length - 1));
	}
	
	public static function equal($s, $t)
	{
		if ($s === null)
		{
			return $s === $t;
		}
		
		if ($t === null)
		{
			return false;
		}
		
		return ((string) $s) == ((string) $t);
	}

	public static function equal_slow($s, $t)
	{
		if ($s === null)
		{
			return $s === $t;
		}
		
		if ($t === null)
		{
			return false;
		}

		$s = (string) $s;
		$t = (string) $t;

		$s_len = strlen($s); // sic! Byte comparison used here
		if ($s_len != strlen($t))
		{
			return false;
		}

		$status = 0;
		for ($i = 0; $i < $s_len; $i++)
		{
			$status |= ord($s[$i]) ^ ord($t[$i]);
		}

		return $status == 0;
	}

	public static function get_encodings()
	{
		static $whitelist = array(
			'UTF-8' => 'UTF-8',
			'Windows-1252' => 'Windows-1252 (Latin)',
			'Windows-1251' => 'Windows-1251 (Cyrillic)',
			'ASCII' => 'ASCII',
			'UTF-7' => 'UTF-7',
			'UTF-16' => 'UTF-16',
			'UTF-16BE' => 'UTF-16BE',
			'UTF-16LE' => 'UTF-16LE (Windows Unicode)',
			'UTF-32' => 'UTF-32',
			'UTF-32BE' => 'UTF-32BE',
			'UTF-32LE' => 'UTF-32LE',
			'UCS-2' => 'UCS-2',
			'UCS-2BE' => 'UCS-2BE',
			'UCS-2LE' => 'UCS-2LE',
			'UCS-4' => 'UCS-4',
			'UCS-4BE' => 'UCS-4BE',
			'UCS-4LE' => 'UCS-4LE',
			'ISO-8859-1' => 'ISO-8859-1',
			'ISO-8859-2' => 'ISO-8859-2',
			'ISO-8859-3' => 'ISO-8859-3',
			'ISO-8859-4' => 'ISO-8859-4',
			'ISO-8859-5' => 'ISO-8859-5',
			'ISO-8859-6' => 'ISO-8859-6',
			'ISO-8859-7' => 'ISO-8859-7',
			'ISO-8859-8' => 'ISO-8859-8',
			'ISO-8859-9' => 'ISO-8859-9',
			'ISO-8859-10' => 'ISO-8859-10',
			'ISO-8859-13' => 'ISO-8859-13',
			'ISO-8859-14' => 'ISO-8859-14',
			'ISO-8859-15' => 'ISO-8859-15'
		);

		$available = array_flip(mb_list_encodings());
		
		$encodings = array();
		foreach ($whitelist as $key => $name)
		{
			if (isset($available[$key]))
			{
				$encodings[$key] = $name;
			}
		}

		return $encodings;
	}

	public static function has_encoding($encoding)
	{
		$encodings = self::get_encodings();
		return isset($encodings[$encoding]);
	}

	public static function convert($s, $from_encoding, 
		$to_encoding = 'UTF-8')
	{
		return mb_convert_encoding($s, $to_encoding, $from_encoding);
	}
}

// The following code is taken and modified from the UTF-8 for PHP
// library (see http://sourceforge.net/projects/phputf8/).

/**
 * We require the mbstring extension to be present as we are
 * using the mbstring core implementation of the UTF-8 library.
 */
if (!extension_loaded('mbstring'))
{
	errors::show(
		'The mbstring PHP extension is not installed',
		'The mbstring extension needs to be installed on your
		webserver. Please activate this extension in your PHP.ini
		in order to run this application.'
	);
}

/**
 * If string overloading is active, it will break many of the
 * native implementations. mbstring.func_overload must be set
 * to 0, 1 or 4 in php.ini (string overloading disabled).
 */
if (ini_get('mbstring.func_overload') & MB_OVERLOAD_STRING) 
{
	errors::show(
		'The mbstring PHP extension uses function overloading',
		'The mbstring extension has function overloading enabled with
		your PHP configuration (PHP.ini option mbstring.func_overload).
		Please deactivate function overloading in order to run this
		application.'
	);
}

/**
 * Set the internal encoding for the mbstring library to UTF-8. 
 * This will make mbstring expect the UTF-8 encoding for strings
 * and return UTF-8 encoded strings.
 */
mb_internal_encoding('UTF-8');

/**
 * Here we check whether PCRE has been compiled with UTF-8 support.
 * This is a requirement to run this application.
 */
if (!preg_match('/^.{1}$/u', "\xc3\xb1"))
{
	errors::show(
		'The PCRE extension has no UTF-8 support',
		'The PCRE extension of your PHP environment has no support
		for UTF-8. Please install a UTF-8 enabled version of PCRE
		in order to run this application.'
	);
}

/**
 * Load the native mbstring implementation of the core UTF-8 functions.
 */
require_once VENPATH . 'utf8/core.php';
