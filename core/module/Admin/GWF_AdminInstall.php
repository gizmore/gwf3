<?php
final class GWF_AdminInstall
{
	public static function onInstall(Module_Admin $module, $dropTables)
	{
		return GWF_ModuleLoader::installVars($module, array(
			'users_per_page' => array('50', 'int', '1', '500'),
			'super_hash' => array('', 'script'),
			'super_time' => array('10 minutes', 'time', 30, 7200),
			'install_webspiders' => array('NO', 'bool'),
			'hide_web_spiders' => array('NO', 'bool'),
//			'log_ip_guest' => array('YES', 'bool'),
//			'log_ip_member' => array('YES', 'bool'),
		)).
		self::installCoreClasses($module).
		self::installWebspiders($module, $dropTables);
	}
	
	private static function installCoreClasses(Module_Admin $module)
	{
		require_once GWF_CORE_PATH.'inc/install/GWF_InstallFunctions.php';
		foreach(install_get_core_tables() as $classname)
		{
			if (false === GDO::table($classname)->createTable(false))
			{
				return GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
			}
		}
		return '';
	}
	
	
//	const SPIDER_FILE = 'spider.dat';
	private static function installWebspiders(Module_Admin $module, $dropTables)
	{
		$back = '';
		require_once GWF_CORE_PATH.'module/Admin/GWF_AdminWebSpiders.php';
		if ($module->cfgInstallSpiders())
		{
			$back .= GWF_AdminWebSpiders::install($module, $dropTables);
			GWF_ModuleLoader::saveModuleVar($module, 'install_webspiders', 'NO');
		}
		
		$back .= GWF_AdminWebSpiders::installHide($module, $module->cfgHideSpiders());

		return $back;
	}
	
}
?>