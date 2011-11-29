<?php
/**
 * Description of GWF_NaviInstall
 *
 * @author spaceone
 */
class GWF_NaviInstall
{
	public static function onInstall(Module_Navigation $module, $dropTable) 
	{
		return GWF_ModuleLoader::installVars($module, array(
			'lockedPM' => array('0', 'bool'),
		));
		// GWF_ModuleLoader::installPageMenu
	}
}
