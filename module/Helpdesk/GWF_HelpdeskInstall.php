<?php
final class GWF_HelpdeskInstall
{
	public static function onInstall(Module_Helpdesk $module, $dropTables)
	{
		return GWF_ModuleLoader::installVars($module, array(
			'maxlen_title' => array('255', 'int', '8', '512'),
			'maxlen_message' => array('2048', 'int', '255', '65565'),
		));
	}
}
?>