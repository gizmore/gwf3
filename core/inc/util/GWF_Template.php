<?php
require_once 'GWF_TemplateWrappers.php';

/**
 * There are two types of templates.
 * php and smarty.
 * Smarty templates are usually faster and preferred.
 * There exist wrapper objects to call gwf stuff within smarty.
 * @todo Allow to switch designs on a per user basis.
 * @author gizmore, spaceone
 * @version 3.0
 * @since 1.0
 * @see GWF_TemplateWrappers
 */
final class GWF_Template
{
	public static function getDesign()
	{
		return GWF3::getDesign();
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
		return self::templatePHP(GWF_WWW_PATH."tpl/%DESIGN%/$file", $tVars);
	}

	public static function templatePHPModule(GWF_Module $module, $file, array $tVars)
	{
		$name = $module->getName();
		return self::templatePHP(GWF_CORE_PATH."module/$name/tpl/%DESIGN%/$file", $tVars, $module->getLang());
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
	protected static $_Smarty = NULL;
	public static function getSmarty()
	{
		if (self::$_Smarty === NULL) 
		{
			# Setup smarty config
			require_once GWF_SMARTY_PATH;
			$smarty = new Smarty();
			$smarty->setTemplateDir(GWF_SMARTY_TPL_DIR);
			$smarty->setCompileDir(GWF_SMARTY_COMPILE_DIR);
			$smarty->setCacheDir(GWF_SMARTY_CACHE_DIR);
			$smarty->setConfigDir(GWF_SMARTY_CONFIG_DIR);
			$smarty->addPluginsDir(GWF_CORE_PATH.'inc/smartyplugins');
//			if (GWF_SMARTY_PLUGINS_DIR) {
//				$smarty->addPluginsDir(GWF_SMARTY_PLUGINS_DIR);
//			}
			
			# Assign common template vars
//			$smarty->assign('db', gdo_db());
			$smarty->assign('gwf', GWF_SmartyUtil::instance());
			$smarty->assign('gwff', GWF_SmartyFile::instance());
			$smarty->assign('gwfl', GWF_SmartyHTMLLang::instance());
			$smarty->assign('gwmm', GWF_SmartyModuleMethod::instance());
			$smarty->assign('root', GWF_WEB_ROOT);
			$smarty->assign('core', GWF_CORE_PATH);
			$smarty->assign('iconset', GWF_ICON_SET);
			$smarty->assign('design', self::getDesign());
			self::$_Smarty = $smarty;
		}
		return self::$_Smarty;
	}

	public static function addMainTvars(array $tVars = array())
	{
		$smarty = self::getSmarty();
		
		foreach ($tVars as $k => $v)
		{
			$smarty->assign($k, $v);
		}
	}
	
	public static function templateRaw($file, $tVars=NULL)
	{
		return self::template(self::templatePath($file), $tVars, false);
	}

	public static function templateWC($file, $tVars=NULL)
	{
		return self::template(GWF_WWW_PATH.'tpl/wc4/'.$file, $tVars, false);
	}

	public static function templateMain($file, $tVars=NULL)
	{
		$path = self::templatePath(GWF_WWW_PATH.'tpl/%DESIGN%/'.$file);
		return self::template($path, $tVars, ($path ? true : false));
	}
	
	public static function templateModule(GWF_Module $module, $file, $tVars=NULL)
	{
		$name = $module->getName();
		if(false === ($path = self::templatePath(GWF_WWW_PATH.'tpl/module/{$name}/%DESIGN%/{$file}')))
			$path = self::templatePath(GWF_CORE_PATH."module/{$name}/tpl/%DESIGN%/{$file}");

		return self::template($path, $tVars, ($path ? true : false));
	}

	public static function templatePath($path)
	{
		$smarty = self::getSmarty();
		if($smarty->templateExists( $path1 = str_replace('%DESIGN%', self::getDesign(), $path) ))
			return $path1;
		elseif($smarty->templateExists( $path1 = str_replace('%DESIGN%', 'default', $path) ))
			return $path1;
		else
			return false;
	}

	public static function template($path, $tVars=NULL, $checked=true)
	{
		$smarty = self::getSmarty();
		if($checked || $smarty->templateExists($path))
		{
			$path2 = $path;
		} else {
			return self::pathError($path);
		}
		
		if (is_array($tVars))
		{
			foreach ($tVars as $k => $v)
			{
				$smarty->assign($k, $v);
			}
		}

		try
		{
			return $smarty->fetch($path2);
		}
		catch (Exception $e)
		{
			return 'SMARTY ERROR: TODO';
		}
		
	}
}
?>
