<?php

final class Usergroups_Create extends GWF_Method
{
	public function isLoginRequired() { return true; }
	
	public function execute()
	{
		$user = GWF_Session::getUser();
		
//		if (false !== ($group = $this->module->getGroup($user))) {
//			return GWF_Website::redirect($this->module->hrefEdit());
//		}
		
		if (!$this->module->canCreateGroup($user)) {
			return $this->module->error('err_perm');
		}
		
//		if ($this->module->hasGroup($user)) {
//			return $this->module->error('err_group_exists');
//		}
		
		if (false !== Common::getPost('create')) {
			return $this->onCreate().$this->module->requestMethodB('ShowGroups');
		}
		return $this->templateCreate();
	}
	
	private function templateCreate()
	{
		
		$form = $this->formCreate();
		$tVars = array(
			'form' => $form->templateY($this->module->lang('ft_create')),
		);
		return $this->module->templatePHP('create.php', $tVars);
	}
	
	private function formCreate()
	{
		$data = array(
			'name' => array(GWF_Form::STRING, '', $this->module->lang('th_name')),
			'join' => array(GWF_Form::SELECT, $this->module->selectJoinType(Common::getPost('join')), $this->module->lang('th_join')),
			'view' => array(GWF_Form::SELECT, $this->module->selectViewType(Common::getPost('view')), $this->module->lang('th_view')),
			'create' => array(GWF_Form::SUBMIT, $this->module->lang('btn_create')),
		);
		return new GWF_Form($this, $data);
	}

	public function validate_name(Module_Usergroups $module, $arg) { return $this->module->validate_name($arg); }
	public function validate_join(Module_Usergroups $module, $arg) { return $this->module->validate_join($arg); }
	public function validate_view(Module_Usergroups $module, $arg) { return $this->module->validate_view($arg); }
	private function onCreate()
	{
		$form = $this->formCreate();
		if (false !== ($errors = $form->validate($this->module))) {
			return $errors.$this->templateCreate();
		}
		
		$user = GWF_Session::getUser();
		
		$groupname = $form->getVar('name');
		
		$options = 0;
		$options |= intval(Common::getPost('join', 0));
		$options |= intval(Common::getPost('view', 0));
		
		$group = new GWF_Group(array(
			'group_id' => 0,
			'group_name' => $groupname,
			'group_options' => $options,
			'group_lang' => $user->getLangID(),
			'group_country' => $user->getCountryID(),
			'group_founder' => $user->getID(),
			'group_memberc' => 0,
			'group_bid' => 0,
			'group_date' => GWF_Time::getDate(GWF_Date::LEN_SECOND),
		));
		
		if (false === $group->insert()) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
		if (false === GWF_UserGroup::addToGroup($user->getID(), $group->getID(), GWF_UserGroup::LEADER))
		{
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
		if (false !== ($error = $this->createBoard($group))) {
			return $error;
		}
		
		return $this->module->message('msg_created');
	}
	
	private function createBoard(GWF_Group $group)
	{
		$name = $group->getName();
		
		$pid = $this->module->getForumBoard()->getID();
//		$pid = Common::clamp($this->module->cfgBID(), 1);
		
		if (false === GWF_ForumBoard::getByID($pid)) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
		$groupid = $group->getID();
		$options = GWF_ForumBoard::ALLOW_THREADS;
		if (false === ($board = GWF_ForumBoard::createBoard('Usergroup: '.$name, 'Board for the '.$name.' group', $pid, $options, $groupid))) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
		if (false === $group->saveVar('group_bid', $board->getID())) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
		if (false !== ($error = $this->module->adjustFlags($group))) {
			return $error;
		}
		
		return false;
	}
	
}

?>