<?php
final class Baim_Install
{
	public static function onInstall(Module_BAIM $module, $dropTable)
	{
		return self::createTempDir();
	}
	
	private static function createTempDir()
	{
		if (Common::isDir('extra/temp/baim')) {
			return '';
		}
		if (false === mkdir('extra/temp/baim', GWF_CHMOD)) {
			return GWF_HTML::err('ERR_WRITE_FILE', array( 'extra/temp/baim'));
		}
		return '';
	}
}
?>