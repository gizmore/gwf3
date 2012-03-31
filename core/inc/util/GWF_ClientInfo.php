<?php
/**
 * Some functions to get Infos like browser, OS, provider about the Surfer
 * @author spaceone
 * @version 1.2
 */
final class GWF_ClientInfo
{
	#################
	### Lang File ###
	#################
	private static $trans;
	public static function init() { self::$trans = new GWF_LangTrans(GWF_CORE_PATH.'lang/client/client'); }
	public static function &getLang() { return self::$trans; }
	public static function lang($key, $args=NULL)
	{
		if(false === isset(self::$trans))
		{
			self::init();
		}
		return self::$trans->lang($key, $args);
	}

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
		return true === isset($_SERVER['REMOTE_ADDR']) ? htmlspecialchars(getHostByAddr($_SERVER['REMOTE_ADDR'])) : $default;
	}
	public static function getUserAgent($default=false)
	{
		return true === isset($_SERVER['HTTP_USER_AGENT']) ? htmlspecialchars($_SERVER['HTTP_USER_AGENT']) : $default;
	}
	public static function getIPAddress($default='127.0.0.1')
	{
		return true === isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : $default;
	}
	public static function getReferer($default=false)
	{
		return true === isset($_SERVER['HTTP_REFERER']) ? htmlspecialchars($_SERVER['HTTP_REFERER']) : $default;
	}

	public static function getProvider()
	{
		static $detail;
		if(false === isset($detail))
		{
			$detail = self::getDetails(self::getHostname(), self::$_provider);
		}
		return $detail;
	}

	public static function getOperatingSystem()
	{
		static $detail;
		if(false === isset($detail))
		{
			$detail = self::getDetails(self::getUseragent(), self::$_system);
		}
		return $detail;
	}

	public static function getBrowser()
	{
		static $detail;
		if(false === isset($detail))
		{
			$detail = self::getDetails(self::getUseragent(), self::$_browser);
		}
		return $detail;
	}

	public static function getRenderingEngine() { return self::getDetails(self::getUseragent(), self::$_engines); }

	public static function getLanguageISO() { return substr(isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])?$_SERVER['HTTP_ACCEPT_LANGUAGE']:GWF_DEFAULT_LANG, 0, 2); }
	public static function getLanguage() { return GWF_Language::getByISO(self::getLanguageISO()); }
	public static function getLanguageID() { return (false !== ($lang = self::getLanguage())) ? $lang->getID() : 0; }
	public static function getCountryID() { return GWF_LangMap::getPrimaryCountryID(self::getLanguageID()); }
	public static function getCountry() { return GWF_Country::getByIDOrUnknown(self::getCountryID()); }
	public static function getCountryIDbyIP() { return GWF_IP2Country::detectCountryID(); }
	public static function getCountryByIP() { return GWF_IP2Country::detectCountry(); }

	public static function displayBrowser() { return self::lang(self::getBrowser()); }
	public static function displayOperatingSystem() { return self::lang(self::getOperatingSystem()); }
	public static function displayProvider() { return self::lang(self::getProvider()); }
	public static function displayLanguage() { return (false !== ($lang = self::getLanguage())) ? $lang->displayName() : 'unknown'; }
	public static function displayCountry() { return (false !== ($country = self::getCountry())) ? $country->displayName() : 'unknown'; }
	public static function displayCountryByIP() { return (false !== ($country = self::getCountryByIP())) ? $country->displayName() : 'unknown'; }

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
	public static function imgBrowser($path='client/') { return self::image( self::getBrowser(), $path ); }
	public static function imgOperatingSystem($path='client/') { return self::image( self::getOperatingSystem(), $path ); }
	public static function imgProvider($path='client/') { return self::image( self::getProvider(), $path ); }
	public static function imgCountry() { return GWF_Country::displayFlagS(self::getCountryID()); }
	public static function imgCountryByIP() { return GWF_Country::displayFlagS(self::getCountryIDbyIP()); }

	public static function cmpBrowser($cmp) { return $cmp === self::getBrowser(); }
	public static function cmpOperatingSystem($cmp) { return $cmp === self::getOperatingSystem(); }
	public static function cmpProvider($cmp) { return $cmp === self::getProvider(); }
	public static function cmpRenderingEngine($cmp) { return $cmp === self::getRenderingEngine(); }
	public static function cmpIPAddress($cmp) { return $cmp === self::getIPAddress(); }
}
