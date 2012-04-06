<?php

final class GWF_PMInstall
{
	public static function install(Module_PM $module, $dropTable)
	{
		return GWF_ModuleLoader::installVars($module, array(
			'pm_re' => array('RE: ', 'text', '1', '64'),
			'pm_limit' => array('6', 'int', '-1', '100'),
			'pm_limit_timeout' => array('18 hours', 'time', '0', GWF_Time::ONE_WEEK),
			'pm_maxfolders' => array('50', 'int', '0', '256'),
			'pm_for_guests' => array(true, 'bool'),
			'pm_captcha' => array(true, 'bool'),
			'pm_causes_mail' => array(true, 'bool'),
			'pm_mail_sender' => array(GWF_BOT_EMAIL, 'text', '8', 255),
			'pm_bot_uid' => array('0', 'int', '0', '2199999999'),
			'pm_per_page' => array('25', 'int', 1, 255),
			'pm_sent' => array('0', 'script'),
			'pm_welcome' => array(true, 'bool'),
			'pm_sig_len' => array('255', 'int', 0, '65535'),
			'pm_msg_len' => array('2048', 'int', 1, '65535'),
			'pm_fname_len' => array(GWF_User::USERNAME_LENGTH+4, 'int', GWF_User::USERNAME_LENGTH, '96'),
			'pm_title_len' => array('64', 'int', 1, '1024'),
			'pm_delete' => array(true, 'bool'),
			'pm_own_bot' => array(false, 'bool'),
			'pm_limit_per_level' => array('0', 'int', 0, 1000000),
		)).
		self::installFolders($module).
		self::installPMBotID($module).
		self::fixDatabase($module);
	}
	
	private static function installFolders(Module_PM $module)
	{
		$folders = new GWF_PMFolder(false);
		if ($folders->countRows() === 0)
		{
			$folder = GWF_PMFolder::fakeFolder(0, 'INBOX');
			if (false === $folder->insert()) {
				return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
			}
			$folder = GWF_PMFolder::fakeFolder(0, 'OUTBOX');
			if (false === $folder->insert()) {
				return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
			}
		}
		return '';
	}
	
	private static function installPMBotID(Module_PM $module)
	{
		if (false !== ($user = $module->cfgBotUser())) {
			return '';
		}
		
		if ($module->cfgOwnBot()) {
			return self::installPMBot($module);
		}
		else {
			self::installAdminAsPMBot($module);
		}
		
	}
	
	private static function installAdminAsPMBot(Module_PM $module)
	{
		if (false === ($admin = GDO::table('GWF_UserGroup')->selectFirst('ug_userid', 'group_name="admin"', 'ug_userid ASC', array('group')))) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		if (false === GWF_ModuleLoader::saveModuleVar($module, 'pm_bot_uid', $admin['ug_userid'])) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		return '';
	}
	
	private static function installPMBot(Module_PM $module)
	{
		$user = new GWF_User(array(
			'user_name' => '_GWF_PM_BOT_',
			'user_password' => 'x',#GWF_Password::hashPasswordS(GWF_Random::randomKey(16)),
			'user_regdate' => GWF_Time::getDate(GWF_Date::LEN_SECOND),
			'user_regip' => GWF_IP6::getIP(GWF_IP_EXACT, '127.0.0.1'),
			'user_email' => GWF_BOT_EMAIL,
			'user_birthdate' => GWF_Time::getDate(GWF_Time::LEN_DAY),
			'user_countryid' => 0,
			'user_langid' => 0,
			'user_options' => GWF_User::BOT,
			'user_lastactivity' => time(),
		));
		if (false === ($user->insert())) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
		if (false === GWF_ModuleLoader::saveModuleVar($module, 'pm_bot_uid', $user->getID())) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
		return '';
	}
	
	private static function fixDatabase(Module_PM $module)
	{
		return '';
	}
}

?>