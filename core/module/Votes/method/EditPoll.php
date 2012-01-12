<?php
final class Votes_EditPoll extends GWF_Method
{
	public function isLoginRequired() { return true; }
	
	public function execute(GWF_Module $module)
	{
		if (false === ($poll = GWF_VoteMulti::getByID(Common::getGet('vmid')))) {
			return $this->_module->error('err_poll');
		}
		
		$user = GWF_Session::getUser();
		if (!$poll->mayEdit($user)) {
			return GWF_HTML::err('ERR_NO_PERMISSION');
		}
		
		if (false !== Common::getPost('edit')) {
			return $this->onEdit($this->_module, $poll, $user).$this->templateEdit($this->_module, $poll, $user);
		}
		
		return $this->templateEdit($this->_module, $poll, $user);
	}
	
	private function templateEdit(Module_Votes $module, GWF_VoteMulti $poll, GWF_User $user)
	{
		$form = $this->getForm($this->_module, $poll, $user);
		$tVars = array(
			'form' => $form->templateY($this->_module->lang('ft_edit')),
		);
		return $this->_module->template('edit_poll.tpl', $tVars);
	}
	
	private function getForm(Module_Votes $module, GWF_VoteMulti $poll, GWF_User $user)
	{
		$data = array();
		$data['title'] = array(GWF_Form::STRING, $poll->getVar('vm_title'), $this->_module->lang('th_title'));
		$data['guest'] = array(GWF_Form::CHECKBOX, $poll->isGuestVoteAllowed(), $this->_module->lang('th_guests'));
		$data['multi'] = array(GWF_Form::CHECKBOX, $poll->isMultipleChoice(), $this->_module->lang('th_multi'));
		$data['enabled'] = array(GWF_Form::CHECKBOX, $poll->isEnabled(), $this->_module->lang('th_enabled'));
		if (Module_Votes::mayAddGlobalPoll(GWF_Session::getUser())) {
			$data['public'] = array(GWF_Form::CHECKBOX, $poll->isGlobal(), $this->_module->lang('th_vm_public'));
		}
		
		$data['view'] = array(GWF_Form::SELECT, GWF_VoteMulti::getViewSelect($this->_module, 'view', $poll->getViewFlag()), $this->_module->lang('th_mvview'));
		$data['gid'] = array(GWF_Form::SELECT, GWF_GroupSelect::single('gid', $poll->getGroupID(), true, true), $this->_module->lang('th_vm_gid'));
		$data['level'] = array(GWF_Form::INT, $poll->getLevel(), $this->_module->lang('th_vm_level'));
		
		$data['edit'] = array(GWF_Form::SUBMIT, $this->_module->lang('btn_edit'));
		
		return new GWF_Form($this, $data);
	}
	
	public function validate_view(Module_Votes $m, $arg) { return GWF_VoteMulti::isValidViewFlag($arg) ? false : $m->lang('err_multiview'); }
	public function validate_gid(Module_Votes $m, $arg) { return GWF_Validator::validateGroupID($m, 'gid', $arg, false, true); }
	public function validate_level(Module_Votes $m, $arg) { return GWF_Validator::validateInt($m, 'level', $arg, 0, PHP_INT_MAX, '0'); }
	public function validate_title(Module_Votes $m, $arg) { return GWF_Validator::validateString($m, 'title', $arg, $m->cfgMinTitleLen(), $m->cfgMaxTitleLen(), false); }
	public function onEdit(Module_Votes $module, GWF_VoteMulti $poll, GWF_User $user)
	{
		$form = $this->getForm($this->_module, $poll, $user);
		if (false !== ($errors = $form->validate($this->_module))) {
			return $errors;
		}
		
		$global = isset($_POST['public']);
		if ($global && !Module_Votes::mayAddGlobalPoll($user)) {
			return $this->_module->error('err_global_poll');
		}
		
		$options = 0;
		$options |= $global ? 0 : GWF_VoteMulti::INTERNAL_VOTE;
		$options |= isset($_POST['enabled']) ? GWF_VoteMulti::ENABLED : 0;
		$options |= isset($_POST['guest']) ? GWF_VoteMulti::GUEST_VOTES : 0;
		$options |= isset($_POST['multi']) ? GWF_VoteMulti::MULTIPLE_CHOICE: 0;
		$options |= $form->getVar('view');
		
		if (false === $poll->saveVars(array(
			'vm_title' => $form->getVar('title'),
			'vm_gid' => $form->getVar('gid'),
			'vm_level' => $form->getVar('level'),
			'vm_options' => $options,
		))) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}

		return $this->_module->message('msg_poll_edit');
	}
	
	
}
?>
