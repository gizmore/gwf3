<?php
final class GWF_PB_Install
{
	public static function onInstall(Module_PageBuilder $module, $dropTable)
	{
		return GWF_ModuleLoader::installVars($module, array(
		)).
		self::installDirs($module, $dropTable);
	}
	
	private static function installDirs(Module_PageBuilder $module, $dropTable)
	{
		$path = 'dbimg/image';
		if (Common::isDir($path)) {
			return '';
		}
		if (false === mkdir($path)) {
			return GWF_HTML::err('ERR_WRITE_FILE', array($path));
		}
		if (false === chmod($path, GWF_CHMOD)) {
			return GWF_HTML::err('ERR_WRITE_FILE', array($path));
		}
		return '';
	}
}
?>