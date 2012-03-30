<?php
define('GWF_DEBUG_TIME_START', microtime(true));
define('GWF_CORE_VERSION', '3.04-2012.Apr.1');

/**
 * Mini GWF3 loader.
 * @author gizmore
 */
class GWF3
{
	public static function init($basepath)
	{
		define('GWF_PATH', dirname(__FILE__).'/');
		define('GWF_WWW_PATH', $basepath);
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
?>