<?php
final class Baim_Install
{
	public static function onInstall(Module_BAIM $module, $dropTable)
	{
		return self::createTempDir();
	}
	
	private static function createTempDir()
	{
		if (Common::isDir('temp/baim')) {
			return '';
		}
		if (false === mkdir('temp/baim', GWF_CHMOD)) {
			return GWF_HTML::err('ERR_WRITE_FILE', array( 'temp/baim'));
		}
		return '';
	}
}
?>