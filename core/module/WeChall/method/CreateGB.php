<?php
/**
 * Create a user guestbook.
 * @author gizmore
 */
final class WeChall_CreateGB extends GWF_Method
{
	public function isLoginRequired() { return true; }
	
	public function execute()
	{
		if (false === ($mod_gb = GWF_Module::loadModuleDB('Guestbook', true)))
		{
			return GWF_HTML::err('ERR_MODULE_MISSING', array('Guestbook'));
		} $mod_gb instanceof Module_Guestbook;
		
		$user = GWF_Session::getUser();
		if (!($mod_gb->canCreateGuestbook($user))) {
			return $this->_module->error('err_create_gb');
		}
		
		if (false !== ($gb = $mod_gb->getGuestbook($user->getID()))) {
			GWF_Website::redirect($gb->hrefEdit());
			return '';
//			return $this->_module->error('err_have_gb');
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
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		return $this->_module->message('msg_created_gb', array(GWF_WEB_ROOT.'guestbook/edit/'.$gb->getID()));
	}
}

?>