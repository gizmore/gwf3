<?php
final class GWF_Install
{
	const SPIDER_FILE = 'modules/GWF/spider.dat';
	
	public static function onInstall(Module_GWF $module, $dropTable)
	{
		return GWF_ModuleLoader::installVars($module, array(
			'pagecount_on' => array('YES', 'bool'),
			'userrec' => array('YES', 'bool'),
			'userrecc' => array(0, 'script'),
			'userrecd' => array('00000000000000', 'script'),
		));
	}
}
?>