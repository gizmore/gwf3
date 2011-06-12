<?php
final class GWF_HeartInstall
{
	public static function onInstall(Module_Heart $module, $dropTables)
	{
		return GWF_ModuleLoader::installVars($module, array(
			'hb_pagecount' => array('0', 'script'),
			'hb_userrecord' => array('0', 'script'),
			'hb_recorddate' => array('00000000000000', 'script'),
		));
	}
}
?>