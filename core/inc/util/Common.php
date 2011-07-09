<?php
/**
 * Often used stuff.
 * @author gizmore
 * @version 3.01
 * @since 1.0
 */
final class Common
{
	###########
	### GPC ###
	###########
	public static function getGet($var, $default=false) { return isset($_GET[$var]) ? $_GET[$var] : $default; }
	public static function cmpGet($var, $cmp, $default=false) { return $cmp === self::getGet($var, $default) ? true : $default; }
	public static function getGetInt($var, $default=0) { return isset($_GET[$var]) ? intval($_GET[$var],10) : $default; }
	public static function getGetString($var, $default='') { return (isset($_GET[$var]) ? (string)$_GET[$var] : $default); }
	public static function getGetArray($var, $default=false) { return (isset($_GET[$var]) && is_array($_GET[$var])) ? $_GET[$var] : $default; }
	public static function displayGet($var, $default='') { return isset($_GET[$var]) ? htmlspecialchars($_GET[$var], ENT_QUOTES) : $default; }
	
	public static function getPost($var, $default=false) { return isset($_POST[$var]) ? ($_POST[$var]) : $default; }
	public static function cmpPost($var, $cmp, $default=false) { return $cmp === self::getPost($var, $default) ? true : $default; }
	public static function getPostInt($var, $default=0) { return isset($_POST[$var]) ? intval($_POST[$var],10) : $default; }
	public static function getPostString($var, $default='') { return (isset($_POST[$var]) ? (string)$_POST[$var] : $default); }
	public static function getPostArray($var, $default=false) { return (isset($_POST[$var]) && is_array($_POST[$var])) ? $_POST[$var] : $default; }
	public static function displayPost($var, $default='') { return isset($_POST[$var]) ? htmlspecialchars($_POST[$var], ENT_QUOTES) : $default; }
	
	public static function getRequest($var, $default=false) { return isset($_REQUEST[$var]) ? ($_REQUEST[$var]) : $default; }
	public static function cmpRequest($var, $cmp, $default=false) { return $cmp === self::getRequest($var, $default) ? true : $default; }
	public static function getRequestInt($var, $default=0) { return isset($_REQUEST[$var]) ? intval($_REQUEST[$var],10) : $default; }
	public static function getRequestString($var, $default='') { return isset($_REQUEST[$var]) ? (string)$_REQUEST[$var] : $default; }
	public static function getRequestArray($var, $default=false) { return (isset($_REQUEST[$var]) && is_array($_REQUEST[$var])) ? $_REQUEST[$var] : $default; }
	
	public static function getCookie($var, $default=NULL) { return (isset($_COOKIE[$var]) ? (string)$_COOKIE[$var] : $default); }
	public static function cmpCookie($var, $cmp, $default=false) { return $cmp === self::getCookie($var, $default) ? true : $default; }
	public static function displayCookie($var, $default='') { return isset($_COOKIE[$var]) ? htmlspecialchars($_COOKIE[$var], ENT_QUOTES) : $default; }
	
	###########
	### URL ###
	###########
	public static function getHost() { return isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : GWF_DOMAIN; }
	public static function getProtocol() { return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']!=='off') ? 'https' : 'http';  }
	public static function getAbsoluteURL($url, $with_root=true) { $root = $with_root ? GWF_WEB_ROOT : ''; return sprintf('%s://%s%s%s', self::getProtocol(), self::getHost(), $root, $url); }
	public static function getCurrentURL() { return $_SERVER['REQUEST_URI']; }
	public static function getRelativeURL($url) { return self::WEB_ROOT.$url; }
	public static function getAbsolutePath($file) { return self::SERVER_PATH.'/'.$file; }
	public static function getRelativePath($file) { return $file; }
//	public static function getUnixPath($path) { return str_replace('\\', '/', $path); }
	public static function urlencodeSEO($string)
	{
		static $search = array( ' ', '<', '>', '"', "'", '/', '#', '?', '!', ':', ')', '(', '[', ']', ',', '+', '-', '@',    '&',     '%');
		static $replace = array('_', '_', '_', '_', '_', '_', '_', '',  '',  '',  '',  '',  '',  '',  '',  '',  '_', '_at_', '_and_', '_');
		$back = str_replace($search, $replace, $string);
		return $back === '' ? '_Title_' : $back;
	}
	
	/**
	 * Get the domain.tld part of an url. (Not only TLD)
	 * @param string $url
	 * @return string|false
	 */
	public static function getTLD($url)
	{
		return preg_match('/([^\\.]+\\.[a-z]{2,3})([\\/:].*|$)/', $url, $matches) ? $matches[1] : false;
	}
	
	##############
	### Random ###
	##############
	const TOKEN_LEN = 16;
	const ALPHAUP = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	const ALPHALOW = 'abcdefghijklmnopqrstuvwxyz';
	const HEXLOWER = 'abcdef0123456789';
	const HEXUPPER = 'ABCDEF0123456789';
	const ALPHANUMLOW = 'abcdefghijklmnopqrstuvwxyz0123456789';
	const ALPHANUMUPLOW = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
	const ALPHANUMUPLOWSPECIAL = '!"\'_.,%&/()=<>;:#+-*~@abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
	/**
	 * Generate a randomkey from a charset. A bit slow but should be random.
	 * @param $len int
	 * @param $alpha string or true
	 * @return string
	 */
	public static function randomKey($len=self::TOKEN_LEN, $alpha=self::ALPHANUMUPLOW)
	{
		$alphalen = strlen($alpha) - 1;
		$key = '';
		for($i = 0; $i < $len; $i++)
		{
			$key .= $alpha[rand(0, $alphalen)];
		}
		return $key;
	}
	
	##################
	### Array Util ###
	##################
	/**
	 * Recursive implode. Code taken from php.net. Original code by: kromped@yahoo.com
	 * @param string $glue
	 * @param array $pieces
	 * @return string
	 */
	public static function implode($glue, $pieces)
	{
		foreach($pieces as $r_pieces)
		{
			if (is_array($r_pieces)) {
				$retVal[] = self::implode($glue, $r_pieces);
			}
			else {
				$retVal[] = $r_pieces;
			}
		}
		return implode($glue, $retVal);
	}
	
	/**
	 * Implode an array like humans would do:
	 * Example: 1, 2, 3 and last
	 * @param array $array
	 * @return string
	 */
	public static function implodeHuman(array $array)
	{
		static $and = NULL;
		$cnt = count($array);
		if ($cnt <= 0) {
			return '';
		}
		elseif ($cnt === 1) {
			return $array[0];
		}
		if ($and === NULL) { $and = GWF_HTML::lang('and'); }
		$last = array_pop($array);
		return implode(', ', $array)." $and $last";
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
	
	###################
	### String Util ###
	###################
	/**
	 * UTF8 strlen.
	 * @param string $str
	 * @return int
	 */
	public static function strlen($str)
	{
		return mb_strlen($str, 'utf8');
	}
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
	 * @example substrUntil('FooBar', 'Bar') returns 'Foo'
	 * @example substrUntil('FooBag', 'Bar') returns 'FooBag'
	 * */
	public static function substrUntil($string, $until, $default=NULL)
	{
		if (false === ($pos = strpos($string, $until)))
		{
			return $default === NULL ? $string : $default;
		}
		return substr($string, 0, $pos);
	}
	
	/**
	 * return a substring of string from a specified character sequence.
	 * @param $string  - string the string to work on
	 * @param $from    - string trim string until this sequence occurs
	 * @param $default - string [optional] the default return value if $from is not found. The default is an empty string.
	 * @return string the $string from $from.
	 * @example substrFrom('AhhFooBar', 'Foo') returns 'Bar'
	 * @example substrFrom('AhhFooBar', 'Fog') returns $default
	 * */
	public static function substrFrom($string, $from, $default="")
	{
		$pos = strpos($string, $from);
		if ($pos === false) {
			return $default;
		}
		$len = strlen($from);
		return substr($string, $pos+$len);
	}
	
	/**
	 * Cut a message by length.
	 * Cut only at spaces, append a string as cutting replacement.
	 * @param string $msg
	 * @param int $limit
	 * @param string $append
	 * @return string the cut string
	 */
	public static function stripMessage($msg, $limit, $append='...')
	{
		if (strlen($msg)<=$limit)
		{
			return $msg;
		}
		return (false === ($pos = strrpos($msg, ' ', -(strlen($msg)-$limit)))) ? $msg : substr($msg, 0, $pos).$append;
	}
	
	/**
	 * Return the first match of capturing regex. Not safe. Do not use it!
	 * @param string $pattern
	 * @param string $s
	 * @return string|false
	 */
	public static function regex($pattern, $s)
	{
		if (preg_match($pattern, $s, $matches))
		{
			return $matches[1];
		}
		return false;
	}
}
?>
