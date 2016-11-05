<?php
require_once 'GWF_TemplateWrappers.php';

/**
 * There are two types of templates.
 * php and smarty.
 * Smarty templates are usually faster and preferred.
 * There exist wrapper objects to call gwf stuff within smarty.
 * @todo Allow to switch designs on a per user basis.
 * @author gizmore
 * @author spaceone
 * @version 3.0
 * @since 1.0
 * @see GWF_TemplateWrappers
 */
final class GWF_Template
{
	protected static $_smarty = NULL;

	public static function getDesign() { return GWF3::getDesign(); }
	private static function pathError($path) { return GWF_HTML::err('ERR_FILE_NOT_FOUND', array( htmlspecialchars(str_replace('%DESIGN%', 'default', $path)) )); }

	public static function templatePHPMain($file, $tVars=NULL) { return self::templatePHP(GWF_WWW_PATH.'tpl/%DESIGN%/'.$file, $tVars); }
	public static function templateMain($file, $tVars=NULL) { return self::template(GWF_WWW_PATH.'tpl/%DESIGN%/'.$file, $tVars); }
	public static function templatePHPRaw($file, $tVars=NULL) { return self::templatePHP($file, $tVars); }
	
	/**
	 * Get the Smarty instance and create if not exists
	 * @return Smarty
	 */
	public static function getSmarty()
	{
		if (self::$_smarty === NULL) 
		{
			# Setup smarty config
			require_once GWF_SMARTY_PATH;
			$smarty = new Smarty();
			$smarty->setTemplateDir(GWF_WWW_PATH.'tpl/');
			$dir = rtrim(GWF_SMARTY_DIRS, '/').'/';
			$smarty->setCompileDir($dir.'tplc');
			$smarty->setCacheDir($dir.'cache');
			$smarty->setConfigDir($dir.'cfg');
			$smarty->addPluginsDir(GWF_CORE_PATH.'inc/smartyplugins');

			# Assign common template vars
//			$smarty->assign('db', gdo_db());
			$smarty->assign('gwff', GWF_SmartyFile::instance());
			$smarty->assign('gwmm', GWF_SmartyModuleMethod::instance());
			$smarty->assign('root', GWF_WEB_ROOT);
			$smarty->assign('core', GWF_CORE_PATH);
			$smarty->assign('iconset', GWF_ICON_SET);
			$smarty->assign('mo', Common::getGetString('mo'));
			$smarty->assign('me', Common::getGetString('me'));
			$smarty->assign('design', self::getDesign());
			self::$_smarty = $smarty;
		}
		return self::$_smarty;
	}

	/**
	 * Get Smarty template output
	 * @return string
	 */
	public static function template($path, $tVars=NULL)
	{
		$smarty = self::getSmarty();
		if(false === ($path2 = self::getPathSmarty($path)))
		{
			return self::pathError($path);
		}
		
		if (true === is_array($tVars))
		{
			foreach ($tVars as $k => $v)
			{
				$smarty->assign($k, $v);
			}
		}

		try { return $smarty->fetch($path2); }
		catch (SmartyException $e)
		{
			$msg = $e->getMessage();
			if (GWF_DEBUG_EMAIL & 2)
			{
				$msg .= $e->getTraceAsString();
				self::sendErrorMail($path, $msg);
			}
			return str_replace("\n", "<br>\n", $msg);
		}
	}

	private static function sendErrorMail($path, $msg)
	{
		return GWF_Mail::sendDebugMail(': Smarty Error: '.$path, GWF_Debug::backtrace($msg, false));
	}

	/**
	 * Get a PHP Template output
	 * @param $path path to template file
	 * @return string
	 */
	private static function templatePHP($path, $tVars=NULL)
	{
		if (false === ($path2 = self::getPath($path)))
		{
			return self::pathError($path);
		}

		$tLang = isset($tVars['lang']) === true ? $tVars['lang'] : NULL;

		ob_start();
		include $path2;
		$back = ob_get_contents();
		ob_end_clean();
		return $back;
	}

	/**
	 * Add template Variables to the Smarty instance
	 * @return NULL 
	 */
	public static function addMainTvars(array $tVars=array())
	{
		$smarty = self::getSmarty();

		foreach ($tVars as $k => $v)
		{
			$smarty->assign($k, $v);
		}
	}

	/**
	 * Get the Path for the GWF Design if the file exists 
	 * @param string $path templatepath
	 * @return string|false
	 */
	private static function getPath($path)
	{
		$path1 = str_replace('%DESIGN%', self::getDesign(), $path);
		if (true === file_exists($path1))
		{
			return $path1;
		}
		$path1 = str_replace('%DESIGN%', 'default', $path);
		if (true === file_exists($path1))
		{
			return $path1;
		}
		return false;
	}

	/**
	 * Get the template Path if Smarty template exists
	 * TPL_DIR will be checked, too
	 * @param string $path templatepath or file
	 * @return string|false
	 */
	public static function getPathSmarty($path)
	{
		$smarty = self::getSmarty();
		if(true === $smarty->templateExists( $path1 = str_replace('%DESIGN%', self::getDesign(), $path) ))
		{
			return $path1;
		}
		elseif(true === $smarty->templateExists( $path1 = str_replace('%DESIGN%', 'default', $path) ))
		{
			return $path1;
		}
		return false;
	}
}

