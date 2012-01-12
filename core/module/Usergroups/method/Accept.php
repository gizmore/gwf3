<?php

final class Usergroups_Accept extends GWF_Method
{
	public function execute(GWF_Module $module)
	{
		if (false !== ($token = Common::getGet('token'))) {
			$back = $this->acceptByToken($this->_module, $token);
		}
		
		if (!GWF_User::isLoggedIn()) {
			return GWF_HTML::err('ERR_LOGIN_REQUIRED');
		}
		
		return $back;
	}
	
	private function acceptByToken(Module_Usergroups $module, $token)
	{
		$uid = (int) Common::getGet('uid');
		$gid = (int) Common::getGet('gid');
		if (false === ($group = GWF_Group::getByID($gid))) {
			return GWF_HTML::err('ERR_UNKNOWN_GROUP');
		}
		if (false === ($request = GWF_UsergroupsInvite::getRequestRow($uid, $gid))) {
			return GWF_HTML::err('ERR_NO_PERMISSION');
		}
		if (false === ($user = GWF_User::getByID($uid))) {
			return GWF_HTML::err('ERR_UNKNOWN_USER');
		}
		if ($token !== $request->getHashcode()) {
			return GWF_HTML::err('ERR_GENERAL', array( __FILE__, __LINE__));
		}
		
		if (false === GWF_UserGroup::addToGroup($uid, $gid))
		{
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
		return $this->_module->message('msg_joined', array($group->getName()));
		
	}
}

?>