<?php
/**
 * Bootstrap PHP ini modes.
 * Remove magic quotes.
 * Unregister globals.
 * Some backwards compatibility with php5.2/5.1
 * @author Gizmore
 */
final class GWF_Bootstrap
{
	public static function init()
	{
		# anti magic quotes
		self::unmagicquote();

		# anti register globals
//		self::unregisterGlobals();
	}

	/**
	 * Unmagicquote a variable.
	 * This will recursively unmagicquote arrays and only touch strings.
	 * @param $var Mixed
	 * @return stripslashed $var
	 * */
	public static function unmagicquoteTypesafe($var)
	{
		if (is_string($var)) { return stripslashes($var); }
		elseif (is_array($var)) { return array_map(array(__CLASS__, 'unmagicquoteTypesafe'), $var); }
		return $var;
	}

	/**
	 * UnMagicquote GetPostCookie.
	 * Call me once please. 
	 * */
	public static function unmagicquote()
	{
		# anti magic_quotes_gpc
		if (get_magic_quotes_gpc() > 0)
		{
			$callback = array(__CLASS__, 'unmagicquoteTypesafe');
			$_GET = array_map($callback, $_GET);
			$_POST = array_map($callback, $_POST);
			$_REQUEST = array_map($callback, $_REQUEST);
			$_COOKIE = array_map($callback, $_COOKIE);
		}
		# now you should have raw input/output
		# have fun # Gizmore ---
	}

	/**
	 * Unregister globals.
	 * @return void
	 */
//	public static function unregisterGlobals()
//	{
//		if (ini_get('register_globals') == 1)
//		{
// 			$_SESSION = array();
//			if (is_array($_REQUEST)) foreach(array_keys($_REQUEST) as $v) unset($$v);
//			if (is_array($_SESSION)) foreach(array_keys($_SESSION) as $v) unset($$v);
//			if (is_array($_SERVER)) foreach(array_keys($_SERVER) as $v) unset($$v);
//		}
//	}
}



###
### PHPv5.1 compatibility.
###
if (!function_exists('inet_pton'))
{
	function inet_pton($ip)
	{
		# ipv4
		if (strpos($ip, '.') !== FALSE) {
			return pack('N',ip2long($ip));
		}
		# ipv6
		elseif (strpos($ip, ':') !== FALSE) {
			$ip = explode(':', $ip);
			$res = str_pad('', (4*(8-count($ip))), '0000', STR_PAD_LEFT);
			foreach ($ip as $seg) {
				$res .= str_pad($seg, 4, '0', STR_PAD_LEFT);
			}
			return pack('H'.strlen($res), $res);
		}
		return false;
	}
}

