<?php
/**
 * Some functions to get Infos like browser, OS, provider about the Surfer
 * @author spaceone
 * @version 1.0
 */
final class GWF_SF_SurferInfos { 

	private static $PROVIDER = array(
		array('Unknown', 'Unknown', 'unknown'),
		array('alicedsl.de' ,'Alice', 'alice'),
		array('aol.com' ,'AOL', 'aol'),
		array('einsundeins.de' ,'1&1', '1und1'),
		array('pools.arcor-ip.net' ,'Arcor', 'arcor'),
		array('t-dialin.net' ,'Telekom', 'telekom'),
		array('t-ipconnect.de' ,'Telekom', 'telekom'),
		array('vodafone.de' ,'Vodafone', 'vodafone'),
		array('d1-online.com' ,'T-Mobile', 'telekom'),
		array('superkabel.de' ,'Kabel Deutschland', 'kabeldeu'),
		array('ewe-ip-backbone.de' ,'EWE TEL', 'ewetel'),
		array('pppool.de' ,'Freenet', 'freenet'),
		array('hosteurope.de' ,'Host Europe', 'hosteurope'),
		array('kabelbw.de' ,'Kabel BW', 'kabelbw'),
		array('ish.de' ,'Unitymedia', 'unitymedia'),
		array('mediaways.net' ,'Telefonica', 'telefonica'),
		array('mnet-online.de' ,'M-net', 'mnet'),
		array('netcologne.de' ,'NetCologne', 'netcologne'),
		array('osnanet.de' ,'osnatel', 'osnatel'),
		array('qsc.de' ,'QSC', 'qsc'),
		array('sat-kabel-online.de' ,'Sat-Kabel', 'satkabel'),
		array('versanet.de' ,'Versatel', 'versatel'),
		array('viaginterkom.de' ,'ViagInterkom', 'viaginterkom'),		
	);
	
	private static $SYSTEM = array(
		array('Unknown', 'Unknown', 'unknown'),
		array("Windows 95", 'Windows 95', 'win95'),
		array("Windows 98", 'Windows 98', 'win98'),
		array("NT 4.0", 'Windows NT', 'winnt'),
		array("NT 5.0", 'Windows 2000', 'win2k'),
		array("NT 5.1", 'Windows XP', 'winxp'),
		array("NT 6.0", 'Windows Vista', 'winvista'),
		array("NT 6.1", 'Windows 7', 'win7'),
		'Windows',
		array("Ubuntu", 'Ubuntu', 'ubuntu'),
		array("Suse", 'OpenSuse', 'suse'),
		array("Debian", 'Debian', 'debian'),
		array("Gentoo", 'Gentoo', 'gentoo'),
		array("Mint", 'Linux Mint', 'mint'),
		array("Arch", 'Archlinux', 'arch'),
		'Linux',
		'Unix',
		'JVM',
		'FreeBSD',
		'BSD',
		'Mac OS',
		'Solaris',
		'SunOS',
		'IRIX',
		'Amiga OS',
		'OpenVMS',
		'BeOS',
		'Symbian OS',
		'Palm OS',
		'PlayStation Portable',
		'OS/2',
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
	private static $BROWSER = array(
		array('Unknown', 'Unknown', 'unknown'),
		array('MSIE 9.0', 'Internet Explorer 9', 'ie9'),
		array('MSIE 8.0', 'Internet Explorer 8', 'ie8'),
		array('MSIE 7.0', 'Internet Explorer 7', 'ie7'),
		array('MSIE 6.0', 'Internet Explorer 6', 'ie6'),
		array('MSIE 5.0', 'Internet Explorer 5', 'ie5'),
		array('MSIE 5.5', 'Internet Explorer 5.5', 'ie5'),
		array('MSIE', 'Internet Explorer', 'ie'),
		array('Opera', 'Opera', 'opera'),
		array("Firefox", 'Firefox', 'firefox'),
		array("Safari", 'Safari', 'safari'),
		array("Lynx", 'Lynx', 'lynx'),
		array("WebTV", 'WebTV', 'webtv'),
		array("Konqueror", 'Konqueror', 'konqueror'),
		array('Mozilla', 'Mozilla', 'mozilla'),
		array('w3m', 'w3m', 'w3m'),
	);

	public static function get_hostname($default = false) {
		return isset($_SERVER['REMOTE_ADDR']) ? htmlspecialchars(getHostByAddr($_SERVER['REMOTE_ADDR'])) : $default;
	}
	public static function get_useragent($default = false) {
	//	if(SF_HackingAttemp::SERVER_manipulation($_SERVER['HTTP_USER_AGENT'])) return $default;
		return isset($_SERVER['HTTP_USER_AGENT']) ? htmlspecialchars($_SERVER['HTTP_USER_AGENT']) : $default;
	}
	public static function get_ipaddress($default = '127.0.0.1') {
		return isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : $default;
	}
	public static function get_referer($default = false) {
	//	if(SF_HackingAttemp::SERVER_manipulation($_SERVER['HTTP_REFERER'])) return $default;
		return isset($_SERVER['HTTP_REFERER']) ? htmlspecialchars($_SERVER['HTTP_REFERER']) : $default;
	}
	//public static function get_forwarder() { return GWF_IP6::forwarder(); }
	public static function get_details($search, $subj, $type = 1) {

		if( !$search ) return $default;

		foreach($subj as $detail) {
			if(is_array($detail)) {
				if(strstr($search, $detail[0])) {
					return $detail[$type];
				}	
			} elseif(strstr($search, $detail)) {
				return $detail;
			}
		}
		return $subj[0][$type];
	
	}
	public static function get_provider($type = 1) { return self::get_details(self::get_hostname(), self::$PROVIDER, $type); }
	public static function get_operatingsystem($type = 1) { return self::get_details(self::get_useragent(), self::$SYSTEM, $type); }
	public static function get_browser($type = 1) { return self::get_details(self::get_useragent(), self::$BROWSER, $type);}

	// public static function save_referer() { return;	}

}

?>
