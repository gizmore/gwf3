<?php
final class GWF_ProfileInstall
{
	public static function onInstall(Module_Profile $module, $dropTable)
	{
		return GWF_ModuleLoader::installVars($module, array(
			'prof_hide' => array(true, 'bool'),
			'prof_max_about' => array('512', 'int', '16', '4096'),
			'prof_level_gb' => array('0', 'int', '0'),
		));
	}
}
?>