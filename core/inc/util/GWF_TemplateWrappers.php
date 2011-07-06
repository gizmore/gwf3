<?php
/**
 * Call a file within smarty like: {$gwff->dir_subdir_file(args)}
 * @example {$gwff->module_Forum_unread($user)}
 * @author gizmore
 * @version 3.0
 * @since 3.0
 */
final class GWF_SmartyFile
{
	private static $instance; public static function init() { self::$instance = new self(); } public static function instance() { return self::$instance; }
	public function __call($name, $args)
	{
		$path = 'core/'.str_replace('_', '/', $name).'.php';
		if (Common::isFile($path))
		{
			require_once $path;
			if (function_exists($name))
			{
				echo call_user_func($name, $args);
			}
			else { echo GWF_HTML::err('ERR_METHOD_MISSING', array(htmlspecialchars($name))); }
		} else { echo GWF_HTML::err('ERR_FILE_NOT_FOUND', array(htmlspecialchars($path))); }
	}
} 
GWF_SmartyFile::init();



/**
 * Call a static core/inc/util function via smarty.
 * @example smartyhtml: {$gwf->Time()->getDate()}
 * @author gizmore
 */
final class GWF_SmartyUtil
{
	private static $instance; public static function init() { self::$instance = new self(); } public static function instance() { return self::$instance; }
	public function __call($name, $args)
	{
		$name = 'GWF_'.$name;
		if (!class_exists($name)) {
			echo GWF_HTML::err('ERR_CLASS_NOT_FOUND', array(htmlspecialchars($name)));
			return;
		}
		return new $name();
	}
}
GWF_SmartyUtil::init();


/**
 * Get a translation bit from the HTML base lang file.
 * @example {$gwfl->err_database(array(1, 'file'))}
 * @author gizmore
 */
final class GWF_SmartyHTMLLang
{
	private static $instance; public static function init() { self::$instance = new self(); } public static function instance() { return self::$instance; }
	public function __call($name, $args) { return GWF_HTML::lang($name, $args); }
}
GWF_SmartyHTMLLang::init();



/**
 * Execute a module method.
 * @author gizmore
 */
final class GWF_SmartyModuleMethod
{
	private static $instance; public static function init() { self::$instance = new self(); } public static function instance() { return self::$instance; }
	public function __call($name, $args)
	{
		if (false === ($mo = Common::substrUntil($name, '_'))) {
			echo GWF_HTML::error('ERR_GENERAL', array(__FILE__, __LINE__));
			return;
		}
		$me = Common::substrFrom($name, '_');
		if (false === ($module = GWF_Module::loadModuleDB($mo))) {
			echo GWF_HTML::error('ERR_MODULE_MISSING', array(__FILE__, __LINE__));
			return;
		}
		echo $module->execute($me);
	}
}
GWF_SmartyModuleMethod::init();

?>
