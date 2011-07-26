<?php
final class Baim_Install
{
	public static function onInstall(Module_BAIM $module, $dropTable)
	{
		return self::createTempDir();
	}
	
	private static function createTempDir()
	{
		if (Common::isDir(GWF_PATH.'extra/temp/baim')) {
			return '';
		}
		if (false === mkdir(GWF_PATH.'extra/temp/baim', GWF_CHMOD)) {
			return GWF_HTML::err('ERR_WRITE_FILE', array(GWF_PATH.'extra/temp/baim'));
		}
		return '';
	}
}
?>