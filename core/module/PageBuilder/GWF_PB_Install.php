<?php
final class GWF_PB_Install
{
	public static function onInstall(Module_PageBuilder $module, $dropTable)
	{
		return GWF_ModuleLoader::installVars($module, array(
			'ipp' => array('10', 'int', '1', '100'),
			'home_page' => array('0', 'int', '0', /*PHP_INT_MAX*/2147483647),
			'authors' => array('admin,moderator,publisher', 'text', '0', '1024'),
			'author_level' => array('0', 'int', '0', '10000000'),
			'locked_posting' => array(false, 'bool'),
		)).
		self::installDirs($module, $dropTable).
		self::protectDirs($module);
	}
	
	private static function installDirs(Module_PageBuilder $module, $dropTable)
	{
		$path = GWF_WWW_PATH.'dbimg/content';
		$path = $module->getContentPath();
		if (Common::isDir($path))
		{
			return '';
		}
		if (false === mkdir($path, GWF_CHMOD))
		{
			return GWF_HTML::err('ERR_WRITE_FILE', array($path));
		}
// 		if (false === chmod($path, GWF_CHMOD))
// 		{
// 			return GWF_HTML::err('ERR_WRITE_FILE', array($path));
// 		}
		return '';
	}

	private static function protectDirs(Module_PageBuilder $module)
	{
		$path = $module->getContentPath();
// 		if (false === GWF_HTAccess::protect404($path))
// 		{
// 			return GWF_HTML::err('ERR_WRITE_FILE', array($path));
// 		}
		$filename = $path.'/.htaccess';
		$data = "RewriteEngine On\nRewriteRule (.*) /index.php?mo=PageBuilder&me=ServeContent&filename=$1\n";
		if (!file_put_contents($filename, $data))
		{
			return GWF_HTML::err('ERR_WRITE_FILE', array($filename));
		}
		return '';
	}
}
?>
