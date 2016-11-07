<?php
define('GWF_DEBUG_TIME_START', microtime(true));
define('GWF_CORE_VERSION', '4.00-2016.Nov.7');

# Easy autoconfig and removed from installer.
if (!defined('GWF_LANG_ADMIN')) define('GWF_LANG_ADMIN', 'en');
if (!defined('GWF_ERRORS_TO_SMARTY')) define('GWF_ERRORS_TO_SMARTY', true);
if (!defined('GWF_ICON_SET')) define('GWF_ICON_SET', 'default');
if (!defined('GWF_SMARTY_PATH')) define('GWF_SMARTY_PATH', GWF_CORE_PATH.'inc/3p/smarty/Smarty.class.php');
if (!defined('GWF_SMARTY_DIRS')) define('GWF_SMARTY_DIRS', GWF_PATH.'extra/temp/smarty/');
if (!defined('GWF_SUPPORTED_LANGS')) define('GWF_SUPPORTED_LANGS', 'en;de;fr;it;pl;hu;es;bs;et;fi;ur;tr;sq;nl;ru;cs;sr;lv');

/**
 * Mini GWF3 loader.
 * @author gizmore
 */
class GWF3
{
	public function __construct($basepath=NULL, array $config=array())
	{
		self::init($basepath);
		self::onDefineWebRoot();
		GWF_Language::initEnglish();
		GWF_Website::init(false);
	}
	
	public static function init($basepath=NULL)
	{
		define('GWF_PATH', dirname(__FILE__).'/');
		$basepath = $basepath === NULL ? GWF_PATH.'www' : $basepath;
		define('GWF_WWW_PATH', $basepath.'/');
		define('GWF_CORE_PATH', GWF_PATH.'core/');
		
		# Require the Database
		require_once GWF_CORE_PATH.'inc/GDO/GDO.php';

		# Require the util
		require_once GWF_CORE_PATH.'inc/util/Common.php';
		
		# The GWF autoloader
		spl_autoload_register(array(__CLASS__,'onAutoloadClass'));
	}
	
	public static function onAutoloadClass($classname, $prefix='GWF_')
	{
		if (substr($classname, 0, 4) === $prefix)
		{
			require_once GWF_CORE_PATH.'inc/util/'.$classname.'.php';
		}
	}
	
	public static function getDesign()
	{
		return GWF_DEFAULT_DESIGN;
	}
	
	public static function getMo()
	{
		return Common::getGetString('mo', GWF_DEFAULT_MODULE);
	}
	
	public static function getMe()
	{
		return Common::getGetString('me', GWF_DEFAULT_METHOD);
	}
	
	public static function onDefineWebRoot() 
	{
		# Web Root
		$root = GWF_WEB_ROOT_NO_LANG;
		if (isset($_SERVER['REQUEST_URI'])) # Non CLI?
		{
			if (preg_match('#^'.GWF_WEB_ROOT_NO_LANG.'([a-z]{2})/#', $_SERVER['REQUEST_URI'], $matches)) # Match lang from url.
			{
				if (strpos(';'.GWF_SUPPORTED_LANGS.';', $matches[1]) !== false)
				{
					$root .= $matches[1].'/'; # web_root is lang extended
				}
			}
		}
		// User can decide for his instance?
		define('GWF_WEB_ROOT', $root);
	}
}
