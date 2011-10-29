<?php
final class GWF_Install
{
	public static function onInstall(Module_GWF $module, $dropTables)
	{
		return GWF_ModuleLoader::installVars($module, array(
//			'Design' => array(GWF_Template::getDesign(), 'text'),
			# Fancy Config
			'FancyIndex' => array('YES', 'bool'),
			'NameWidth' => array('25', 'int'),
			'DescrWidth' => array('80', 'int'),
			'IconWidth' => array('16', 'int'),
			'IconHeight' => array('16', 'int'),
			'HTMLTable' => array('NO', 'bool'),
			'IgnoreClient' => array('NO', 'bool'),
			'FoldersFirst' => array('YES', 'bool'),
			'IgnoreCase' => array('YES', 'bool'),
			'SuppressHTMLPreamble' => array('YES', 'bool'),
			'ScanHTMLTitles' => array('YES', 'bool'),
			'SuppressDescription' => array('YES', 'bool'),
			'SuppressRules' => array('YES', 'bool'),
			'log_404' => array('YES', 'bool'),
			'mail_404' => array('YES', 'bool'),
		));
	}
}
?>