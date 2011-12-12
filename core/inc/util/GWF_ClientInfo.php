<?php
/**
 * Some functions to get Infos like browser, OS, provider about the Surfer
 * @author spaceone
 * @version 1.1
 */
final class GWF_ClientInfo
{
        #################
        ### Lang File ###
        #################
	private static $trans;
        public static function init() { self::$trans = new GWF_LangTrans(GWF_CORE_PATH.'lang/client/client'); }
        public static function &getLang() { return self::$trans; }
        public static function lang($key, $args=NULL) { return self::$trans->lang($key, $args); }

	public static $_provider = array(
		'alicedsl.de',
		'aol.com',
		'einsundeins.de',
		'pools.arcor-ip.net',
		't-dialin.net',
		't-ipconnect.de',
		'vodafone.de',
		'd1-online.com',
		'superkabel.de',
		'ewe-ip-backbone.de',
		'pppool.de',
		'hosteurope.de',
		'kabelbw.de',
		'ish.de',
		'unitymediagroup.de',
		'mediaways.net',
		'mnet-online.de',
		'netcologne.de',
		'osnanet.de',
		'qsc.de',
		'sat-kabel-online.de',
		'versanet.de',
		'viaginterkom.de',
	);
	
	public static $_system = array(
		# windows
		'NT 4.0',
		'NT 5.0',
		'NT 5.1',
		'NT 6.0',
		'NT 6.1',
		'NT',
		'ubuntu',
		# linux
		'suse',
		'debian',
		'gentoo',
		'mint',
		'archlinux',
		'fedora',
		'backtrack',
		'linux',
		# other OS's
		'unix',
		'jvm',
		'freebsd',
		'bsd',
		'mac os',
		'solaris',
		'sunos',
		'irix',
		'amiga os',
		'openvms',
		'beos',
		'symbian OS',
		'palm os',
		'playstation',
		'os/2',
		'RISK OS',
		'Nintendo',
		'HP-UX',
		'AIX',
		'Plan 9',
		'RIM OS',
		'QNX',
		'MorphOS',
		'NetWare',
		'SCO',
		'SkyOS',
		'iPhone OS',
		'Haiku OS',
		'DangerOS',
		'Syllable',
	);

	public static $_browser = array(
		# Firefox
		'Firefox/2',
		'Firefox/3',
		'Firefox/4',
		'Firefox/5',
		'Firefox/6',
		'Firefox/7',
		'Firefox/8',
		'Firefox',
		# Internet Explorer
		'MSIE 9',
		'MSIE 8',
		'MSIE 7',
		'MSIE 6',
		'MSIE 5',
		'MSIE',
		# other Browser
		'opera',
		'chromium',
		'chrome',
		'safari',
		'lynx',
		'links',
		'konqueror',
		'mozilla',
		'w3m',
		'seamonkey',
	);

	public static $_engines = array(
		'Gecko', // Mozilla, Firefox
		'WebKit', // Safari, Chromium, Google-Chrome
		'Presto', // Opera
		'Trident', // MS, IE
		'KHTML',
		'Tasman',
		'Robin',
		'Links',
		'Lynx',
	);

	/**
	* Case-insensitive search for $string in $context
	*/
	public static function getDetails($string, array $context, $default='unknown')
	{
		# string could be false
		if( !$string ) return $default;

		foreach($context as $substr)
		{
			if(stristr( strtolower($string), strtolower($substr) ))
			{
				return $substr;
			}
		}
		return $default;
	}

	public static function getHostname($default=false)
	{
		return isset($_SERVER['REMOTE_ADDR']) ? htmlspecialchars(getHostByAddr($_SERVER['REMOTE_ADDR'])) : $default;
	}
	public static function getUserAgent($default=false)
	{
		return isset($_SERVER['HTTP_USER_AGENT']) ? htmlspecialchars($_SERVER['HTTP_USER_AGENT']) : $default;
	}
	public static function getIPAddress($default='127.0.0.1')
	{
		return isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : $default;
	}
	public static function getReferer($default=false)
	{
		return isset($_SERVER['HTTP_REFERER']) ? htmlspecialchars($_SERVER['HTTP_REFERER']) : $default;
	}

	public static function getProvider($cmp=NULL)
	{
		static $detail;
		if(!isset($detail))
		{
			$detail = self::getDetails(self::getHostname(), self::$_provider);
		}
		return $cmp === NULL ? $detail : $cmp === $detail;
	}

	public static function getOperatingSystem($cmp=NULL)
	{
		static $detail;
		if(!isset($detail))
		{
			$detail = self::getDetails(self::getUseragent(), self::$_system);
		}
		return $cmp === NULL ? $detail : $cmp === $detail;
	}

	public static function getBrowser($cmp=NULL)
	{
		static $detail;
		if(!isset($detail))
		{
			$detail = self::getDetails(self::getUseragent(), self::$_browser);
		}
		return $cmp === NULL ? $detail : $cmp === $detail;
	}

	public static function getRenderingEngine($cmp=NULL)
	{
		$detail = self::getDetails(self::getUseragent(), self::$_engines);
		return $cmp === NULL ? $detail : $cmp === $detail;
	}

	public static function displayBrowser()
	{
		$browser = self::getBrowser();
		return self::lang($browser);
	}
	public static function displayOperatingSystem()
	{
		$os = self::getOperatingSystem();
		return self::lang($os);
	}
	public static function displayProvider()
	{
		$provider = self::getProvider();
		return self::lang($provider);
	}

	public static function validateImgPath($path)
	{
//		return strtolower( str_replace(' ', '', str_replace('/', '', $path)) );
		return str_replace(' ', '', str_replace('/', '', $path));
	}

	/**
	* Returns an HTML Imagestring
	* @param $path = GWF_WEB_ROOT/img/GWF_ICON_SET/{$path}/$name.png
	*/
	public static function image($name, $path='client/', $check=true)
	{
		$path = sprintf('img/%s/%s.png', GWF_ICON_SET, $path . self::validateImgPath($name));
		return ( !$check || is_file(GWF_WWW_PATH.$path) ) ? sprintf('<img src="%s" title="%s" alt="%s" class="gwf_icon">', GWF_WEB_ROOT.$path, self::lang($name), self::lang($name)) : '';
	}
	public static function imgBrowser($path='client/')
	{
		return self::image( self::getBrowser(), $path );
	}
	public static function imgOperatingSystem($path='client/')
	{
		return self::image( self::getOperatingSystem(), $path );
	}
	public static function imgProvider($path='client/')
	{
		return self::image( self::getProvider(), $path );
	}

}
