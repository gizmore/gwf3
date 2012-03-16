<?php
final class GWF_LogInstall
{
	public static function install(Module_Log $module, $dropTables)
	{
		return GWF_ModuleLoader::installVars($module, array(
			'log_member_ips' => array(true, 'bool'),
		));
	}
}
?>