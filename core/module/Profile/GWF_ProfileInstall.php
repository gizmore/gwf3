<?php
final class GWF_ProfileInstall
{
	public static function onInstall(Module_Profile $module, $dropTable)
	{
		return GWF_ModuleLoader::installVars($module, array(
			'prof_hide' => array(true, 'bool'),
			'prof_max_about' => array('512', 'int', '16', '4096'),
			'prof_level_gb' => array('0', 'int', '0'),
			'min_pois' => array('0', 'int', '0', '100'),
			'max_pois' => array('10', 'int', '0', '100'),
			'pnt_pois' => array('0', 'int', '0'),
			'pnt_add_pois' => array('0', 'int', '0'),
			'pnt_show_pois' => array('0', 'int', '0'),
			'maps_api_key' => array('', 'text', '0', '32'),
		));
	}
}
