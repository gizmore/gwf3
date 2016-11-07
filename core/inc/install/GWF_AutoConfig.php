<?php
/**
 * 
 * @author gizmore
 */
final class GWF_AutoConfig
{
	public static function configure()
	{
		ini_set('display_errors', 1);
		error_reporting(0xffffffff);
		
		$self = substr($_SERVER['REQUEST_URI'], 0, strrpos($_SERVER['REQUEST_URI'], '/install/')+1);
		
		define('GWF_DOMAIN', $_SERVER['HTTP_HOST']);
		define('GWF_SITENAME', 'GWF');
		define('GWF_WEB_ROOT_NO_LANG', $self);
		define('GWF_LOG_BITS', 0xfff);
		
		define('GWF_DEFAULT_DOCTYPE', 'html5');
		define('GWF_DEFAULT_LANG', 'en');
		define('GWF_DEFAULT_MODULE', 'GWF');
		define('GWF_DEFAULT_METHOD', 'About');
		define('GWF_DEFAULT_DESIGN', 'default');
		define('GWF_ICON_SET', 'default');
		
		define('GWF_SMARTY_PATH', GWF_CORE_PATH.'inc/3p/smarty/Smarty.class.php');
		define('GWF_SMARTY_DIRS', GWF_PATH.'extra/temp/smarty/');
		
		define('GWF_LANG_ADMIN', 'en');
		define('GWF_SUPPORTED_LANGS', 'en;de;fr;it;pl;hu;es;bs;et;fi;ur;tr;sq;nl;ru;cs;sr;lv');

		define('GWF_ONLINE_TIMEOUT', 60);
		define('GWF_CRONJOB_BY_WEB', 0);
		define('GWF_USER_STACKTRACE', true);
		define('GWF_ERRORS_TO_SMARTY', true);

		define('GWF_SECRET_SALT', 'is_set_later');
		define('GWF_CHMOD', self::getCHMOD());
		define('GWF_DB_HOST', 'localhost');
		define('GWF_DB_USER', '');
		define('GWF_DB_PASSWORD', '');
		define('GWF_DB_DATABASE', 'GWF');
		define('GWF_DB_TYPE', 'mysqli');
		define('GWF_DB_ENGINE', 'myIsam');
		define('GWF_TABLE_PREFIX', 'gwf3_');

		define('GWF_SESS_NAME', 'GWF');
		define('GWF_SESS_LIFETIME', 14400);
		define('GWF_SESS_PER_USER', 1);
		
		define('GWF_IP_QUICK', 'hash_32_1');
		define('GWF_IP_EXACT', 'bin_32_128');
		
		#############
		### EMail ###
		#############
		define('GWF_DEBUG_EMAIL', 15);
		define('GWF_BOT_EMAIL', 'robot@'.$_SERVER['HTTP_HOST']);
		define('GWF_ADMIN_EMAIL', 'admin@'.$_SERVER['HTTP_HOST']);
		define('GWF_SUPPORT_EMAIL', 'support@'.$_SERVER['HTTP_HOST']);
		define('GWF_STAFF_EMAILS', '');
	}
	
	/**
	 * Determine if we should use 0700 or 0777 as chmod for logfiles.
	 * @return number
	 */
	private static function getCHMOD()
	{
		return 0700;

		# TODO: DOES NOT WORK :(
// 		$filename = 'protected/chmodtest.txt';
// 		if (!@touch($filename))
// 		{
// 			die('FATAL: Cannot probe for CHMOD mask in '.__CLASS__.'.');
// 		}
		
// 		if (false !== ($chmod = fileperms($filename)))
// 		{
// 			var_dump($chmod);
// 		}
		
// 		if (!@unlink($filename))
// 		{
// 			die('FATAL: Cannot unlink the CHMOD probe file in '.__CLASS__.'.');
// 		}
		
// 		if ($chmod === false)
// 		{
// 			die('FATAL: The CHMOD probe mysteriously failed in '.__CLASS__.'.');
// 		}
		
// 		return $chmod;
	}
}
?>
