<?php

final class Usergroups_Join extends GWF_Method
{
	public function isLoginRequired() { return true; }
	
	public function execute()
	{
		if (false !== ($gid = Common::getGet('deny'))) {
			return $this->onRefuse($gid);
		}
		if (false !== ($gid = Common::getGet('gid'))) {
			return $this->onJoin($gid);
		}
		return '';
	}
	
	private function onRefuse($gid)
	{
		if (false === ($group = GWF_Group::getByID($gid))) {
			return $this->_module->error('err_unk_group');
		}
		
		$userid = GWF_Session::getUserID();
		
		if (false === ($row = GWF_UsergroupsInvite::getInviteRow($userid, $group->getID()))) {
			return $this->_module->error('err_not_invited');
		}
		
		if (false === $row->deny()) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
		return $this->_module->message('msg_refused', array($group->display('group_name')));
	}
	
	private function onJoin($gid)
	{
		if (false === ($group = GWF_Group::getByID($gid))) {
			return $this->_module->error('err_unk_group');
		}
		
		if ($group->getFounderID() === 0) {
			return $this->_module->error('err_no_join');
		}
		
		$user = GWF_Session::getUser();
		if ($user->isInGroupName($group->getName()))
		{
			return $this->_module->error('err_join_twice');
		}
		
		
		switch($group->getJoinMode())
		{
			case GWF_Group::FREE:
				return $this->onQuickJoin($group, $user);
			case GWF_Group::MODERATE:
				return $this->onRequestJoin($group, $user);
			case GWF_Group::INVITE:
				return $this->onInviteJoin($group, $user);
			default:
				return $this->_module->error('err_no_join');
		}
	}
	
	private function onQuickJoin(GWF_Group $group, GWF_User $user)
	{
		if (false === GWF_UserGroup::addToGroup($user->getID(), $group->getID()))
		{
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
		return $this->_module->message('msg_joined', array($group->getName()));
	}
		
	private function onRequestJoin(GWF_Group $group, GWF_User $user)
	{
		$userid = $user->getID();
		$groupid = $group->getID();
		
		if (false !== ($request = GWF_UsergroupsInvite::getInviteRow($userid, $groupid))) {
			return $this->_module->error('err_request_twice');
		}
		
		if (false === GWF_UsergroupsInvite::request($userid, $groupid)) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
		if (false === ($request = GWF_UsergroupsInvite::getRequestRow($userid, $groupid))) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
		if (false === $this->onRequestMail($group, $user, $request)) {
			return GWF_HTML::err('ERR_MAIL_SENT');
		}
		
		return $this->_module->message('msg_requested', array($group->getName()));
	}
	
	private function onRequestMail(GWF_Group $group, GWF_User $user, GWF_UsergroupsInvite $request)
	{
		if (false === ($leader = $group->getFounder())) {
			return false;
		}
		if ('' === ($email = $leader->getValidMail())) {
			return false;
		}
		
		$userid = $user->getID();
		$groupid = $group->getID();
		$token = $request->getHashcode();
		$link = Common::getAbsoluteURL('index.php?mo=Usergroups&me=Accept&uid='.$userid.'&gid='.$groupid.'&token='.$token);
		$link = GWF_HTML::anchor($link, $link);
		
		$mail = new GWF_Mail();
		$mail->setSender(GWF_BOT_EMAIL);
		$mail->setReceiver($email);
		$mail->setSubject($this->_module->lang('mail_subj_req', array( $user->displayUsername()), $group->display('group_name')));
		$mail->setBody($this->_module->lang('mail_body_req', array( $leader->displayUsername()), $user->displayUsername(), $group->display('group_name'), $link));
		
		return $mail->sendToUser($leader);
	}
	
	private function onInviteJoin(GWF_Group $group, GWF_User $user)
	{
		if (false === ($invite = GWF_UsergroupsInvite::getInviteRow($user->getID(), $group->getID()))) {
			return $this->_module->error('err_not_invited');
		}
		if ($invite->getVar('ugi_type') !== 'invite') {
			return $this->_module->error('err_not_invited');
		}
		
		if (false === $invite->delete()) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
		return $this->onQuickJoin($group, $user);
	}
}
?>