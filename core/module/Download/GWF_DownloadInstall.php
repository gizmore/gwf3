<?php
final class GWF_DownloadInstall
{
	public static function install(Module_Download $module, $dropTable)
	{
		return
			GWF_ModuleLoader::installVars($module, array(
				'anon_upload' => array(false, 'bool'),
				'anon_downld' => array(true, 'bool'),
				'user_upload' => array(true, 'bool'),
				'dl_descr_min' => array('0', 'int', 0, 16),
				'dl_descr_max' => array('512', 'int', 16, 65535),
				'dl_ipp' => array('50', 'int', 1, 512),
				'dl_minvote' => array('1', 'int', 0, 3),
				'dl_maxvote' => array('5', 'int', 3, 100),
				'dl_gvotes' => array(false, 'bool'),
				'dl_gcaptcha' => array(true, 'bool'),
				'dl_moderators' => array('moderator', 'text', 0, 63),
				'dl_moderated' => array(true, 'bool'),
				'dl_min_level' => array('0', 'int', 0, 1000000),
			)).
			self::dropVotes($module, $dropTable).
			self::installDlDirs($module, $dropTable);
	}
	
	private static function dropVotes($module, $dropTable)
	{
		if ($dropTable)
		{
			if (false === GDO::table('GWF_VoteScore')->deleteWhere("vs_name LIKE 'dl_%'"))
			{
				return GWF_HTML::err('ERR_WRITE_FILE', array( $dir));
			}
		}
		return '';
	}
	
	private static function installDlDirs($module, $dropTable)
	{
		$dir = 'dbimg/dl';
		
		if (is_dir($dir))
		{
			if (false === GWF_HTAccess::protect($dir))
			{
				return GWF_HTML::err('ERR_WRITE_FILE', array( $dir.'/.htaccess'));
			}
			else
			{
				return '';
			}
		}
		
		if (false === mkdir($dir) || false === chmod($dir, GWF_CHMOD))
		{
			return GWF_HTML::err('ERR_WRITE_FILE', array( $dir));
		}

		if (false === GWF_HTAccess::protect($dir))
		{
			return GWF_HTML::err('ERR_WRITE_FILE', array( $dir.'/.htaccess'));
		}
		
		return '';
	}
}
?>