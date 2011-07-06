<?php
final class GWF_DownloadInstall
{
	public static function install(Module_Download $module, $dropTable)
	{
		return
			GWF_ModuleLoader::installVars($module, array(
				'anon_upload' => array('NO', 'bool'),
				'anon_downld' => array('YES', 'bool'),
				'user_upload' => array('YES', 'bool'),
				'dl_descr_min' => array('0', 'int', 0, 16),
				'dl_descr_max' => array('512', 'int', 16, 65535),
				'dl_ipp' => array('50', 'int', 1, 512),
				'dl_minvote' => array('1', 'int', 0, 3),
				'dl_maxvote' => array('5', 'int', 3, 100),
				'dl_gvotes' => array('NO', 'bool'),
				'dl_gcaptcha' => array('YES', 'bool'),
			)).
			self::installDlDirs($module, $dropTable);
	}
	
	private static function installDlDirs($module, $dropTable)
	{
		$dir = 'dbimg/dl';
		if (is_dir($dir))
		{
			if (false === GWF_HTAccess::protect($dir)) {
				return GWF_HTML::err('ERR_WRITE_FILE', array( $dir.'/.htaccess'));
			}
			else {
				return '';
			}
		}
		
		if (false === mkdir($dir) || false === chmod($dir, GWF_CHMOD)) {
			return GWF_HTML::err('ERR_WRITE_FILE', array( $dir));
		}

		if (false === GWF_HTAccess::protect($dir)) {
			return GWF_HTML::err('ERR_WRITE_FILE', array( $dir.'/.htaccess'));
		}
		
		return '';
	}
	
//	private static function installDLHTAccess()
//	{
//		$filename = 'dbimg/dl/.htaccess';
//		if (false === file_put_contents($filename, self::getDLHTAccess())) {
//			return GWF_HTML::err('ERR_WRITE_FILE', array( $filename));
//		}
//		return '';
//	}
//
//	private static function getDLHTAccess()
//	{
//		return
//			'<Limit GET POST PUT DELETE CONNECT>'.PHP_EOL.
//				'order deny,allow'.PHP_EOL.
//				'deny from all'.PHP_EOL.
//			'</Limit>'.PHP_EOL;
//	}
	
}
?>