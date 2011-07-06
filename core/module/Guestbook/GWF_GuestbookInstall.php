<?php

final class GWF_GuestbookInstall
{
	public static function onInstall(Module_Guestbook $module, $dropTable)
	{
		return GWF_ModuleLoader::installVars($module, array(
			'gb_ipp' => array('10', 'int', '1', '512'),
			'gb_allow_url' => array('YES', 'bool'),
			'gb_allow_email' => array('YES', 'bool'),
			'gb_allow_guest' => array('YES', 'bool'),
			'gb_captcha' => array('YES', 'bool'),
			'gb_max_ulen' => array(GWF_User::USERNAME_LENGTH, 'int', '1', '61'),
			'gb_max_msglen' => array('1024', 'int', '128', '65535'),
			'gb_max_titlelen' => array('63', 'int', '16', '63'),
			'gb_max_descrlen' => array('255', 'int', '16', '1024'),
			'gb_level' => array('0', 'int', '0'),
			'gb_menu' => array('YES', 'bool'),
			'gb_submenu' => array('YES', 'bool'),
			'gb_nesting' => array('YES', 'bool'),
		)).
		self::onInstallDefaultGB($module, $dropTable);
	}
	private static function onInstallDefaultGB(Module_Guestbook $module, $dropTable)
	{
		if (false !== ($gb = GWF_Guestbook::getByID(1))) {
			return '';
		}
		
		$gb = new GWF_Guestbook(array(
			'gb_id' => 1,
			'gb_uid' => 0,
			'gb_title' => $module->lang('default_title'),
			'gb_descr' => $module->lang('default_descr'),
			'gb_date' => GWF_Time::getDate(GWF_Date::LEN_SECOND),
			'gb_options' => GWF_Guestbook::DEFAULT_OPTIONS,
		));
		
		if (false === $gb->insert()) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
		return '';
	}
	
}