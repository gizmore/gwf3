<?php
/**
 * Often used stuff.
 * @author gizmore
 * @version 3.02
 * @since 1.0
 */
final class Common
{
	############
	### GPCS ###
	############
	public static function getGet($var, $default=false) { return true === isset($_GET[$var]) ? $_GET[$var] : $default; }
	public static function cmpGet($var, $cmp, $default=false) { return $cmp === self::getGet($var, $default) ? true : $default; }
	public static function getGetInt($var, $default=0) { return true === isset($_GET[$var]) && is_string($_GET[$var]) ? ((int)$_GET[$var]) : $default; }
	public static function getGetFloat($var, $default=0) { return true === isset($_GET[$var]) && is_string($_GET[$var]) ? ((float)$_GET[$var]) : $default; }
	public static function getGetString($var, $default='') { return true === isset($_GET[$var]) && is_string($_GET[$var]) ? $_GET[$var] : $default; }
	public static function getGetArray($var, $default=false) { return (true === isset($_GET[$var]) && is_array($_GET[$var])) ? $_GET[$var] : $default; }
	public static function displayGet($var, $default='') { return true === isset($_GET[$var]) ? htmlspecialchars($_GET[$var], ENT_QUOTES) : $default; }

	public static function getPost($var, $default=false) { return true === isset($_POST[$var]) ? ($_POST[$var]) : $default; }
	public static function cmpPost($var, $cmp, $default=false) { return $cmp === self::getPost($var, $default) ? true : $default; }
	public static function getPostInt($var, $default=0) { return true === isset($_POST[$var]) ? ((int)$_POST[$var]) : $default; }
	public static function getPostString($var, $default='') { return true === isset($_POST[$var]) ? (string)$_POST[$var] : $default; }
	public static function getPostArray($var, $default=false) { return (true === isset($_POST[$var]) && is_array($_POST[$var])) ? $_POST[$var] : $default; }
	public static function displayPost($var, $default='') { return true === isset($_POST[$var]) ? htmlspecialchars($_POST[$var], ENT_QUOTES) : $default; }

	public static function getRequest($var, $default=false) { return true === isset($_REQUEST[$var]) ? ($_REQUEST[$var]) : $default; }
	public static function cmpRequest($var, $cmp, $default=false) { return $cmp === self::getRequest($var, $default) ? true : $default; }
	public static function getRequestInt($var, $default=0) { return true === isset($_REQUEST[$var]) ? ((int)$_REQUEST[$var]) : $default; }
	public static function getRequestString($var, $default='') { return true === isset($_REQUEST[$var]) ? (string)$_REQUEST[$var] : $default; }
	public static function getRequestArray($var, $default=false) { return (true === isset($_REQUEST[$var]) && is_array($_REQUEST[$var])) ? $_REQUEST[$var] : $default; }

	public static function getCookie($var, $default=false) { return (true === isset($_COOKIE[$var]) ? $_COOKIE[$var] : $default); }
	public static function getCookieString($var, $default=false) { return isset($_COOKIE[$var]) ? (string)$_COOKIE[$var] : $default; }
	public static function cmpCookie($var, $cmp, $default=false) { return $cmp === self::getCookie($var, $default) ? true : $default; }
	public static function displayCookie($var, $default='') { return true === isset($_COOKIE[$var]) ? htmlspecialchars($_COOKIE[$var], ENT_QUOTES) : $default; }

	public static function getServer($var, $default=false) { return (true === isset($_SERVER[$var]) ? $_SERVER[$var] : $default); }
	public static function cmpServer($var, $cmp, $default=false) { return $cmp === self::getServer($var, $default) ? true : $default; }
	public static function displayServer($var, $default='') { return true === isset($_SERVER[$var]) ? htmlspecialchars($_SERVER[$var], ENT_QUOTES) : $default; }

	###############
	## CONSTANTS ##
	###############
	public static function getConst($var, $default=false) { return defined($var) ? constant($var) : $default; }
	public static function defineConst($var, $val) { if (!defined($var)) define($var, $val); return $val; }

	###########
	## DEBUG ##
	###########
	public static function var_dump($var) { header('Content-Type: text/plain; charset=UTF-8'); die(var_dump($var)); }

	###########
	### URL ###
	###########
	public static function getHost() { return true === isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : GWF_DOMAIN; }
	public static function getProtocol() { return (true === isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] !== 'off')) ? 'https' : 'http'; }
	public static function getAbsoluteURL($url, $root=true) { return sprintf('%s://%s%s%s', self::getProtocol(), self::getHost(), $root ? GWF_WEB_ROOT : '', $url); }
//	public static function getUnixPath($path) { return str_replace('\\', '/', $path); }
	public static function urlencodeSEO($string)
	{
		$ch = '_';
		$search = array( ' ', '<', '>', '"', "'", '/', '#', '?', '!', ':', ')', '(', '[', ']', ',', '+', '_', '@',	        '&',	       '%');
		$replace = array($ch, $ch, $ch, $ch, $ch, $ch, $ch, '',  '',  '',  '',  '',  '',  '',  '',  '',  $ch, $ch.'at'.$ch, $ch.'and'.$ch, $ch);
		$back = str_replace($search, $replace, $string);
		$back = preg_replace('/[^a-z0-9]/i', $ch, $back);
		$back = preg_replace('/'.$ch.'{2,}/', $ch, $back);
		$back = trim($back, $ch);
		return $back === '' ? '_title_' : $back;
	}

	/**
	 * Get the 2nd level domain.tld part of an url.
	 * @todo Move to a different file.
	 * @param string $url
	 * @return string|false
	 */
	public static function getDomain($url)
	{
		return preg_match('/([^\\.]+\\.[a-z]{2,3})([\\/:].*|$)/D', $url, $matches) ? $matches[1] : false;
	}
	
	public static function getHostname($url)
	{
		return Common::substrUntil(Common::substrFrom($url, '://', $url), '/');
	}

	/**
	 * @deprecated
	 */
	public static function get(array $array, $key, $default)
	{
		return true === isset($array[$key]) ? $array[$key] : $default;
	}

	#################
	### File Util ###
	#################
	public static function isDir($path) { return is_dir($path) && is_readable($path); }
	public static function isFile($path) { return is_file($path) && is_readable($path); }
	public static function unlink($path) { return is_file($path) && is_writeable($path) ? unlink($path) : false; }

	#################
	### Math Util ###
	#################
	/**
	 * Clamp a numeric value. NULL as min or max disables a check. $val should be an int or float. No conversion is done when something is in range.
	 * @param $val mixed string or int or float or double
	 * @param $min bool or numeric as above
	 * @param $max bool or numeric as above
	 * @return int|float
	 */
	public static function clamp($val, $min=NULL, $max=NULL)
	{
		if ($min !== NULL && $val < $min)
		{
			return $min;
		}
		if ($max !== NULL && $val > $max)
		{
			return $max;
		}
		return $val;
	}

	/**
	 * janklopper .AT. gmail dot.com 10-Nov-2004 02:26
	 * Since pow doesn't support decimal powers, you can use a different solution.
	 * Thanks to dOt for doing the math!
	 * @param float $a
	 * @param float $b
	 */
	public static function pow($a, $b)
	{
		return exp($b * log($a));
	}

	/**
	 * Test if a string is numeric. In addition to the php function is_numeric, this one can test on integer only.
	 * @param string $s
	 * @param boolean $allow_float
	 * @return true|false
	 */
	public static function isNumeric($s, $allow_float=false)
	{
		return $allow_float === true ? is_numeric($s) === true : preg_match('/^[-+]?\d+$/D', $s) === 1;
	}

	###################
	### String Util ###
	###################

	/**
	 * Return true if a string ends with another string.
	 * @param $str the string to test.
	 * @param $end the expected end of the string.
	 * @return boolean - true if $str ends with $end or false
	 * */
	public static function endsWith($str, $end)
	{
		return substr($str, -strlen($end)) === $end;		
	}

	/**
	 * Return true if a string starts with another string.
	 * @param $str the string to test.
	 * @param $start the expected start of the string.
	 * @return boolean - true if $str starts with $start or false
	 * */
	public static function startsWith($str, $start)
	{
		return substr($str, 0, strlen($start)) === $start;		
	}

	/**
	 * return a substring of string until a specified character sequence.
	 * @param $string  - the string to cut
	 * @param $until   - keep string until this sequence occurs
	 * @return the $string until $until occurs.
	 * @example substrUntil('AhhFooBar', 'Foo') returns 'Ahh'
	 * @example substrUntil('AhhFogBar', 'Foo') returns $default(='AhhFogBar')
	 * */
	public static function substrUntil($string, $until, $default=NULL, $reverse=false)
	{
		$spos = (true === $reverse) ? 'strrpos' : 'strpos';
		if (false === ($pos = $spos($string, $until)))
		{
			return $default === NULL ? $string : $default;
		}
		return substr($string, 0, $pos);
	}

	/**
	 * return a substring of string from a specified character sequence.
	 * @param $string  - string the string to work on
	 * @param $from	- string trim string until this sequence occurs
	 * @param $default - string [optional] the default return value if $from is not found. The default is an empty string.
	 * @return string the $string from $from.
	 * @example substrFrom('AhhFooBar', 'Foo') returns 'Bar'
	 * @example substrFrom('AhhFooBar', 'Fog') returns $default
	 * */
	public static function substrFrom($string, $from, $default="", $reverse=false)
	{
		$spos = (true === $reverse) ? 'strrpos' : 'strpos';
		$pos = $spos($string, $from);
		if ($pos === false)
		{
			return $default;
		}
		$len = strlen($from);
		return substr($string, $pos+$len);
	}

	/**
	 * Cut a message by length.
	 * Cut only at spaces, append a string as cutting replacement.
	 * @todo Move to GWF_String
	 * @param string $msg
	 * @param int $limit
	 * @param string $append
	 * @return string the cut string
	 */
	public static function stripMessage($msg, $limit, $append='...')
	{
		if (strlen($msg) <= $limit)
		{
			return $msg;
		}
		return (false === ($pos = strrpos($msg, ' ', -(strlen($msg)-$limit)))) ? $msg : substr($msg, 0, $pos).$append;
	}

	/**
	 * Return the first match of capturing regex.
	 * @todo Move to another file?
	 * @param string $pattern
	 * @param string $s
	 * @return string|false
	 */
	public static function regex($pattern, $s)
	{
		return preg_match($pattern, $s, $matches) ? $matches[1] : false;
	}
}
