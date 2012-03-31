<?php
/**
* Get Information about the Server
* @author spaceone
*/
final class GWF_ServerInfo
{
	public static function getHost() { return Common::getServer('HTTP_HOST', GWF_DOMAIN); }
	public static function getIPAddress() { return Common::getServer('SERVER_ADDR', '127.0.0.1'); }
	public static function getSoftware() { return Common::getServer('SERVER_SOFTWARE', 'PHP'); }
	/** This will give the OS where PHP was compiled on! */
	public static function getOperatingSystem() { return PHP_OS; }

	public static function isHTTPS() { return 'off' !== Common::getServer('HTTPS', 'off'); }
	public static function isApache() { return 'Apache' === Common::getSoftware(); }
	public static function isApacheAPI() { return PHP_SAPI === 'apache2handler'; }
	public static function isLinux() { return 'Linux' === PHP_OS; }
	public static function isFreeBSD() { return 'FreeBSD' === PHP_OS; }
	public static function isWindows() { return 'WIN' === strtoupper(substr(PHP_OS, 0, 3)); }

	/**
	 * Overwrite missing $_SERVER variables
	 * @todo rename
	 */
	public static function onCLI()
	{
		$server = array();
		$server['HTTP_HOST'] = 'localhost';
//		$server['HTTP_USER_AGENT'] = 'Mozilla/5.0 (X11; Linux i686; rv:8.0) Gecko/20100101 Firefox/8.0';
		$server['HTTP_ACCEPT'] = 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8';
		$server['HTTP_ACCEPT_LANGUAGE'] = 'en-us,en;q=0.5';
		$server['HTTP_ACCEPT_ENCODING'] = 'gzip, deflate';
		$server['HTTP_ACCEPT_CHARSET'] = 'ISO-8859-1,utf-8;q=0.7,*;q=0.7';
		$server['HTTP_CONNECTION'] = 'keep-alive';
//		$server['HTTP_COOKIE'] = '';
		$server['HTTP_PRAGMA'] = 'no-cache';
		$server['HTTP_CACHE_CONTROL'] = 'no-cache';
		$server['PATH'] = '/usr/local/bin:/usr/bin:/bin';
		$server['SERVER_SIGNATURE'] = '';
		$server['SERVER_SOFTWARE'] = 'PHP';
		$server['SERVER_NAME'] = GWF_DOMAIN;
		$server['SERVER_ADDR'] = '127.0.0.1';
		$server['SERVER_PORT'] = '80';
		$server['REMOTE_ADDR'] = '127.0.0.1';
		$server['DOCUMENT_ROOT'] = GWF_PATH;
		$server['SERVER_ADMIN'] = GWF_ADMIN_EMAIL;
		$server['SCRIPT_FILENAME'] = GWF_WWW_PATH.'index.php';
//		$server['REMOTE_PORT'] = '63411';
		$server['GATEWAY_INTERFACE'] = 'CGI/1.1';
		$server['SERVER_PROTOCOL'] = 'HTTP/1.1';
		$server['REQUEST_METHOD'] = 'GET';
//		$server['QUERY_STRING'] = '';
		$server['REQUEST_URI'] = sprintf(GWF_WEB_ROOT.'index.php?mo=%s&me=%s', GWF_DEFAULT_MODULE, GWF_DEFAULT_METHOD);
		$server['SCRIPT_NAME'] = GWF_WEB_ROOT.'index.php';
		$server['PHP_SELF'] = GWF_WEB_ROOT.'index.php';
//		$server['REQUEST_TIME'] = '1323296068';

		foreach($server as $key => $val)
		{
			if(false === isset($_SERVER[$key]))
			{
				$_SERVER[$key] = $val;
			}
		}

	}
}
