<?php
require_once 'inc/util/GWF_TemplateWrappers.php';

/**
 * There are two types of templates.
 * php and smarty.
 * Smarty templates are usually faster and preferred.
 * There exist wrapper objects to call gwf stuff within smarty.
 * @todo Allow to switch designs on a per user basis.
 * @author gizmore
 * @version 3.0
 * @since 1.0
 * @see GWF_TemplateWrappers
 */
final class GWF_Template
{
	private static function getDesign()
	{
		return GWF_DEFAULT_DESIGN;
	}
	
	private static function getPath($path)
	{
		$path1 = str_replace('%DESIGN%', self::getDesign(), $path);
		if (file_exists($path1)) {
			return $path1;
		}
		$path1 = str_replace('%DESIGN%', 'default', $path);
		if (file_exists($path1)) {
			return $path1;
		}
		return false;
	}
	
	####################
	### PHP Template ###
	####################
	public static function templatePHPMain($file, $tVars=NULL)
	{
		return self::templatePHP("tpl/%DESIGN%/$file", $tVars);
	}

	public static function templatePHPModule(GWF_Module $module, $file, array $tVars)
	{
		$name = $module->getName();
		return self::templatePHP("module/$name/tpl/%DESIGN%/$file", $tVars, $module->getLang());
	}
	
	private static function templatePHP($path, $tVars=NULL, $tLang=NULL)
	{
		if (false === ($path2 = self::getPath($path))) {
			return self::pathError($path);
		}
		ob_start();
		include $path2;
		$back = ob_get_contents();
		ob_end_clean();
		return $back;
	}
	
	private static function pathError($path)
	{
		return GWF_HTML::err('ERR_FILE_NOT_FOUND', array(htmlspecialchars(str_replace('%DESIGN%', 'default', $path))));
	}
	
	#######################
	### Smarty Template ###
	#######################
	public static function getSmarty()
	{
		static $smarty;
//		if (!isset($smarty))
		{
			require_once GWF_SMARTY_PATH;
			$smarty = new Smarty();
			$smarty->setTemplateDir('temp/smarty_cache/tpl');
			$smarty->setCompileDir('temp/smarty_cache/tplc');
			$smarty->setCacheDir('temp/smarty_cache/cache');
			$smarty->setConfigDir('temp/smarty_cache/cfg');
//			$smarty->assign('db', gdo_db());
			$smarty->assign('gwf', GWF_SmartyUtil::instance());
			$smarty->assign('gwff', GWF_SmartyFile::instance());
			$smarty->assign('gwfl', GWF_SmartyHTMLLang::instance());
			$smarty->assign('gwmm', GWF_SmartyModuleMethod::instance());
			$smarty->assign('root', GWF_WEB_ROOT);
//			$smarty->assign('user', GWF_User::getStaticOrGuest());
		}
		return $smarty;
	}
	
	public static function templateMain($file, $tVars=NULL)
	{
		return self::template("tpl/%DESIGN%/$file", $tVars);
	}
	
	public static function templateModule(GWF_Module $module, $file, $tVars=NULL)
	{
		$name = $module->getName();
		return self::template("module/$name/tpl/%DESIGN%/$file", $tVars);
	}
	
	public static function template($path, $tVars=NULL)
	{
		if (false === ($path2 = self::getPath($path))) {
			return self::pathError($path);
		}
		$smarty = self::getSmarty();
		
		if (is_array($tVars))
		{
			foreach ($tVars as $k => $v)
			{
				$smarty->assign($k, $v);
			}
		}
		
		ob_start();
		$smarty->display($path2);
		$back = ob_get_contents();
		ob_end_clean();
		return $back;
	}
}
?>