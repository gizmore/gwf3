<?php
final class GWF_InstallGWF
{
	public static function onInstall(Module_GWF $module, $dropTables)
	{
		return GWF_ModuleLoader::installVars($module, array(
//			'Design' => array(GWF_Template::getDesign(), 'text'),
			# Fancy Config
			'FancyIndex' => array('NO', 'bool'),
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
			# Error Config
			'log' => array('404,403', 'text'),
			'mail' => array('404,403', 'text'),
			# Captcha Config
			'CaptchaBGColor' => array('FFFFFF', 'text'),
			'CaptchaFont' => array(GWF_PATH.'extra/font/teen.ttf', 'text'),
			'CaptchaWidth' => array('210', 'int'),
			'CaptchaHeight' => array('42', 'int'),
			# Security
			'allow_all_requests' => array('NO', 'bool'),
			'blacklist' => array('me=ShowError;favicon.ico[^$]', 'text'),
		));
	}
}
?>
