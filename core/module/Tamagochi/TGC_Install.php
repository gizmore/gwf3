<?php
final class TGC_Install
{
	public static function onInstall(Module_Tamagochi $module, $dropTable)
	{
		return GWF_ModuleLoader::installVars($module, array(
				'maps_api_key' => array('', 'text', '0', '128'),
		));
	}	
}