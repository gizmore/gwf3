<?php
/**
 * Create a user guestbook.
 * @author gizmore
 */
final class WeChall_CreateGB extends GWF_Method
{
	public function isLoginRequired() { return true; }
	
	public function execute(GWF_Module $module)
	{
		if (false === ($mod_gb = GWF_Module::getModule('Guestbook'))) {
			return GWF_HTML::err('ERR_MODULE_MISSING', 'Guestbook');
		}
		$mod_gb->onInclude();

		$user = GWF_Session::getUser();
		$mod_gb instanceof Module_Guestbook;
		if (!($mod_gb->canCreateGuestbook($user))) {
			return $module->error('err_create_gb');
		}
		
		if (false !== ($gb = $mod_gb->getGuestbook($user->getID()))) {
			GWF_Website::redirect($gb->hrefEdit());
			return '';
//			return $module->error('err_have_gb');
		}
		
		$options = GWF_Guestbook::DEFAULT_OPTIONS;
		$gb = new GWF_Guestbook(array(
			'gb_uid' => $user->getID(),
			'gb_title' => $user->getVar('user_name').'s Guestbook',
			'gb_descr' => $user->getVar('user_name').'s Guestbook',
			'gb_date' => GWF_Time::getDate(GWF_Date::LEN_SECOND),
			'gb_options' => $options,
		));
		
		if (false === $gb->insert()) {
			return GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
		}
		
		return $module->message('msg_created_gb', GWF_WEB_ROOT.'guestbook/edit/'.$gb->getID());
	}
}

?>