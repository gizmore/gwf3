<?php
final class TGC_Install
{
	public static function onInstall(Module_Profile $module, $dropTable)
	{
		return GWF_ModuleLoader::installVars($module, array(
				'maps_api_key' => array('', 'text', '0', '128'),
				'max_avatars' => array('3', 'int', '0'),
				'max_avatar_size' => array('2048', 'int', '0', '65535'),
		));
	}	
}