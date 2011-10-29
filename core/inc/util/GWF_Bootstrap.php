<?php
/**
 * Bootstrap PHP ini modes.
 * Remove magic quotes.
 * Unregister globals.
 * @author Gizmore
 * Usage: Just include this file :)
 */
final class GWF_Bootstrap
{
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
		if (get_magic_quotes_gpc() > 0) {
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
//			if (is_array($_REQUEST)) foreach(array_keys($_REQUEST) as $v) unset($$v);
//			if (is_array($_SESSION)) foreach(array_keys($_SESSION) as $v) unset($$v);
//			if (is_array($_SERVER)) foreach(array_keys($_SERVER) as $v) unset($$v);
//			unset($v);
//		}
//	}
	
	/**
	 * @author gizmore
	 * Get the maximum upload size limit from php.ini as integer
	 * @return int number of bytes
	 */
//	public static function iniGetMaxUploadBytes()
//	{
//		$ini = trim(ini_get('post_max_size'));
//		$last = strtolower(substr($ini, -1));
//		$ini = (int) $ini;
//		switch($last)
//		{
//			case 'g': $ini *= 1024;
//			case 'm': $ini *= 1024;
//			case 'k': $ini *= 1024;
//		}
//		return $ini;
//	}
}

#$_SESSION = array(); # anti register_globals for session

GWF_Bootstrap::unmagicquote(); # anti magic quotes

//GWF_Bootstrap::unregisterGlobals(); # anti globals


# PHPv5.1 compatibility.
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
?>
