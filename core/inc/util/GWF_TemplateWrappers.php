<?php
/**
 * Call a file within smarty like: {$gwff->dir_subdir_file(args)}
 * @example {$gwff->module_Forum_unread($user)}
 * @deprecated
 * find -type d -name tpl -exec grep -r \$gwff {} \;
 * @author gizmore
 * @version 3.0
 * @since 3.0
 */
final class GWF_SmartyFile
{
	/**
	 * Only files in GWF_CORE_PATH can be called
	 */
	private static $instance; public static function init() { self::$instance = new self(); } public static function instance() { return self::$instance; }
	public function __call($name, $args)
	{
		$path = GWF_CORE_PATH.str_replace('_', '/', $name).'.php';
		if (false === Common::isFile($path))
		{
			return GWF_HTML::err('ERR_FILE_NOT_FOUND', array(htmlspecialchars($path)));
		}
		require_once $path;
		if (false === function_exists($name))
		{
			return GWF_HTML::err('ERR_METHOD_MISSING', array(htmlspecialchars($name)));
		}
		return call_user_func($name, $args);
	}
} 
GWF_SmartyFile::init();


/**
 * Call a static core/inc/util function via smarty.
 * @example smartyhtml: {$gwf->Time()->getDate()}
 * @deprecated use {GWF_Foo::bar()}
 * find -type d -name tpl -exec grep -r '$gwf->' {} \;
 * @author gizmore
 */
final class GWF_SmartyUtil
{
	private static $instance; public static function init() { self::$instance = new self(); } public static function instance() { return self::$instance; }
	public function __call($name, $args)
	{
		$name = 'GWF_'.$name;
		if (false === class_exists($name)) {
			return GWF_HTML::err('ERR_CLASS_NOT_FOUND', array(htmlspecialchars($name)));
		}
		return new $name();
	}
}
GWF_SmartyUtil::init();


/**
 * Get a translation bit from the HTML base lang file.
 * @example {$gwfl->err_database(array(1, 'file'))}
 * @deprecated you can use {GWF_HTML::lang()}; only used in default/bb_codebar.tpl; you also could assign $lang :D lol omfg rofl
 * find -type d -name tpl -exec grep -r \$gwfl {} \;
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
			return GWF_HTML::error('ERR_GENERAL', array(__FILE__, __LINE__));
		}
		$me = Common::substrFrom($name, '_');
		if (false === ($module = GWF_Module::loadModuleDB($mo))) {
			return GWF_HTML::error('ERR_MODULE_MISSING', array(__FILE__, __LINE__));
		}
		return $module->execute($me);
	}
}
GWF_SmartyModuleMethod::init();