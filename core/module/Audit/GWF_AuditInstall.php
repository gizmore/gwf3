<?php
final class GWF_AuditInstall
{
	public static function onInstall(Module_Audit $module, $dropTable)
	{
		return GWF_ModuleLoader::installVars($module, array(
			'logfile' => array(Module_Audit::DEFAULT_LOGFILE, 'text'),
		)).
		self::createGroups($module, $dropTable).
		self::createDirs($module, $dropTable);
	}
	
	private static function createGroups(Module_Audit $module, $dropTable)
	{
		$table = GDO::table('GWF_Group');
		$groups = array('live', 'auditor', 'sysmin', 'poweruser');
		foreach ($groups as $group)
		{
			if (false !== GWF_Group::getByName($group))
			{
				continue;
			}
			if (false === $table->insertAssoc(array(
				'group_name' => $group,
				'group_lang' => 1,
				'group_date' => GWF_Time::getDate(),
			)))
			{
				return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
			}
		}
		return '';
	}

	private static function createDirs(Module_Audit $module, $dropTable)
	{
		$dirname = GWF_WWW_PATH.'dbimg';
		if (false === GWF_File::createDir($dirname))
		{
			return GWF_HTML::err('ERR_WRITE_FILE', array($dirname));
		}
		$dirname = GWF_WWW_PATH.'dbimg/sudosh';
		if (false === GWF_File::createDir($dirname))
		{
			return GWF_HTML::err('ERR_WRITE_FILE', array($dirname));
		}
		if (false === GWF_HTAccess::protect($dirname))
		{
			return GWF_HTML::err('ERR_WRITE_FILE', array($dirname.'.htaccess'));
		}
		return '';
	}
}
?>