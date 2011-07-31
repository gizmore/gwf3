<?php
define('GWF_DEBUG_TIME_START', microtime(true));
define('GWF_CORE_VERSION', '3.02-2011.JUL.14');

/**
 * Mini GWF3 loader.
 * @author gizmore
 */
class GWF3
{
	public static function init()
	{
		define('GWF_PATH', __DIR__.'/');
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
}
?>