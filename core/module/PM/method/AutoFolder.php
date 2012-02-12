<?php

final class PM_AutoFolder extends GWF_Method
{
	public function execute()
	{
		if (false !== ($token = Common::getGet('token'))) {
			return $this->autoFolderB($token, Common::getGet('pmid'), Common::getGet('uid'));
		}

		if (!GWF_User::isLoggedIn()) {
			return GWF_HTML::err('ERR_LOGIN_REQUIRED');
		}
		
		if (false !== ($pmid = Common::getGet('pmid'))) {
			return $this->autoFolder($pmid);
		}

	}
	
	public function autoFolder($pmid)
	{
		if (false === ($user = GWF_Session::getUser())) {
			return GWF_HTML::err('ERR_LOGIN_REQUIRED');
		}
		if (false === ($pm = GWF_PM::getByID($pmid))) {
			return $this->module->error('err_pm');
		}
		return $this->autoFolderB($pm->getHashcode(), $pm->getID(), $user->getID());
	}

	/**
	 * Call me by EMail.
	 * @param string $token
	 * @param string $pmid
	 * @param string $uid
	 * @return string html
	 */
	public function autoFolderB($token, $pmid, $uid)
	{
		if (false === ($pm = GWF_PM::getByID($pmid))) {
			return $this->module->error('err_pm');
		}
		
		if ($token !== ($pm->getHashcode())) {
			return $this->module->error('err_pm');
		}
		
		if (false === ($user = GWF_User::getByID($uid))) {
			return GWF_HTML::err('ERR_UNKNOWN_USER');
		}
		
		if (!$pm->canRead($user)) {
			return $this->module->error('err_pm');
		}
		
		if (false === ($pmo = GWF_PMOptions::getPMOptions($user))) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
		if (false === $pm->markRead($user, true)) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
		if (0 >= ($peak = $pmo->getAutoFolderValue())) {
			return $this->module->message('msg_auto_folder_off');
		}
		
		if (false === ($other_user = $pm->getOtherUser($user))) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
		$uid1 = $user->getID();
		$uid2 = $other_user->getID();
		$to_del = GWF_PM::OTHER_DELETED;
		$from_del = GWF_PM::OWNER_DELETED;
		# count pm from and to user.
		$conditions = "(pm_to=$uid1 AND pm_from=$uid2 AND pm_options&$to_del=0) OR (pm_to=$uid2 AND pm_from=$uid1 AND pm_options&$from_del=0)";
		$count = GDO::table('GWF_PM')->countRows($conditions);
		
		if ($count < $peak) {
			return $this->module->message('msg_auto_folder_none', array($count));
		}
		
		$foldername = $other_user->getVar('user_name');
		$back = '';
		if (false === ($folder = GWF_PMFolder::getByName($foldername, $user))) {
			$folder = GWF_PMFolder::fakeFolder($user->getID(), $foldername);
			if (false === ($folder->insert())) {
				return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
			}
			$back .= $this->module->message('msg_auto_folder_created', array($other_user->displayUsername()));
		}
		
		$pms = GDO::table('GWF_PM')->selectObjects('*', $conditions);
		
		$moved = 0;
		foreach ($pms as $pm)
		{
			if (false !== $pm->move($user, $folder))
			{
				$moved++;
			}
		}
		
		return $back.$this->module->message('msg_auto_folder_moved', array($moved, $other_user->displayUsername()));
	}
}

?>