<?php

final class Forum_AddPoll extends GWF_Method
{
	public function isLoginRequired() { return true; }
	
	public function getHTAccess(GWF_Module $module)
	{
		return 'RewriteRule ^thread_add_poll/(\d+)/[^/]+$ index.php?mo=Forum&me=AddPoll&tid=$1'.PHP_EOL;
	}
	
	private $thread;
	
	public function execute(GWF_Module $module)
	{
		if (false === ($mod_votes = GWF_Module::loadModuleDB('Votes'))) {
			return GWF_HTML::err('ERR_MODULE_MISSING', array('Votes'));
		}
		$mod_votes->onInclude();
		
		if (!($this->thread = GWF_ForumThread::getThread(Common::getGet('tid')))) {
			return $this->_module->error('err_thread');
		}
		
		$this->user = GWF_Session::getUser();
		
		if (!$this->thread->mayAddPoll($this->user)) {
			return GWF_HTML::err('ERR_NO_PERMISSION');
		}
		
		if (false !== Common::getPost('assign')) {
			return $this->onAssign($this->_module).$this->template($this->_module);
		}
		
		return $this->template($this->_module);
	}
	
	private function template()
	{
		$form = $this->getForm($this->_module);
		$tVars = array(
			'may_add_poll' => Module_Votes::mayAddPoll($this->user),
			'href_add' => Module_Votes::hrefAddPoll(),
			'form' => $form->templateY($this->_module->lang('ft_add_poll')),
		);
		return $this->_module->templatePHP('add_poll.php', $tVars);
	}
	
	private function getForm()
	{
		$data = array(
			'pollid' => array(GWF_Form::SELECT, $this->getPollSelect($this->_module), $this->_module->lang('th_thread_pollid')),
			'assign' => array(GWF_Form::SUBMIT, $this->_module->lang('btn_assign')),
		);
		return new GWF_Form($this, $data);
	}

	private function getPollSelect()
	{
		if (false === ($mv = GWF_Module::getModule('Votes'))) {
			return GWF_HTML::lang('ERR_MODULE_MISSING', array('Votes'));
		}
		$uid = GWF_Session::getUserID();
		
		if (false === $polltable = GDO::table('GWF_VoteMulti')) {
			return GWF_HTML::lang('ERR_MODULE_MISSING', array('Votes'));
		}
		
		$polls = $polltable->selectAll('vm_id, vm_title', "vm_uid=$uid", 'vm_title ASC', NULL, -1, -1, GDO::ARRAY_N);
		
		$data = array(
			array('0', $this->_module->lang('sel_poll')),
		);
		
		
		foreach ($polls as $poll)
		{
			$data[] = $poll;
//			$data[] = $poll;array($poll[0], $poll->getVar('vm_title'), );
		}
		
		return GWF_Select::display('pollid', $data, Common::getPostString('pollid', '0'));
	}
	
	/**
	 * @var GWF_VoteMulti
	 */
	private $poll = NULL;
	public function validate_pollid(Module_Forum $m, $arg)
	{
		if (false === ($p = GWF_VoteMulti::getByID($arg))) {
			return $m->lang('err_poll');
		}
		if ($p->getUserID() !== $this->user->getID()) {
			return $m->lang('err_poll');
		}
		return false;
	}
	
	private function onAssign()
	{
		$form = $this->getForm($this->_module);
		if (false !== ($errors = $form->validate($this->_module))) {
			return $errors;
		}
		
		if (false === $this->thread->saveVar('thread_pollid', $form->getVar('pollid'))) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		return $this->_module->message('msg_poll_assigned');
	}
}
?>
