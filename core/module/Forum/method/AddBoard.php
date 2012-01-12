<?php

final class Forum_AddBoard extends GWF_Method
{
	/**
	 * @var GWF_ForumBoard
	 */
	private $board = false;

	public function getUserGroups() { return GWF_Group::ADMIN; }
	
	public function getHTAccess()
	{
		return 'RewriteRule ^forum/add/board/([0-9]+)/[^/]+ index.php?mo=Forum&me=AddBoard&bid=$1'.PHP_EOL;
	}
	
	public function execute()
	{
		if (false !== ($error = $this->sanitize($this->_module))) {
			return $error;
		}
		
		if (false !== Common::getPost('add_board')) {
			return $this->onAddBoard($this->_module);
		}
		
		return $this->templateAddBoard($this->_module);
	}
	
	private function sanitize()
	{
		$table = GDO::table('GWF_ForumBoard');
		if (false === ($this->board = $table->getRow($this->_module->getBoardID()))) {
			return $this->_module->error('err_parent');
		}
		return false;
	}
	
	private function getForm()
	{
		$parent = $this->_module->getCurrentBoard();
		
		$data = array(
			'parentid' => array(GWF_Form::HIDDEN, $parent->getID()),
			'groupid' => array(GWF_Form::SELECT, $this->_module->getGroupSelect($this->board->getGroupID()), $this->_module->lang('th_groupid')),
			'title' => array(GWF_Form::STRING, '', $this->_module->lang('th_board_title')),
			'descr' => array(GWF_Form::STRING, '', $this->_module->lang('th_board_descr')),
			'allow_threads' => array(GWF_Form::CHECKBOX, true, $this->_module->lang('th_thread_allowed')),
			'is_locked' => array(GWF_Form::CHECKBOX, false, $this->_module->lang('th_locked')),
			'guest_view' => array(GWF_Form::CHECKBOX, $parent->isGuestView(), $this->_module->lang('th_guest_view')),
			'guests' => array(GWF_Form::CHECKBOX, $this->board->isGuestPostAllowed(), $this->_module->lang('th_guests')),
			'add_board' => array(GWF_Form::SUBMIT, $this->_module->lang('btn_add_board')),
		);
		return new GWF_Form($this, $data);
	}
	
	private function templateAddBoard()
	{
		$form = $this->getForm($this->_module);
		$tVars = array(
			'form' => $form->templateY($this->_module->lang('ft_add_board')),
		);
		return $this->_module->templatePHP('add_board.php', $tVars);
	}
	
	##################
	### Validators ###
	##################
	public function validate_parentid(Module_Forum $module, $arg) { return $this->_module->validate_parentid($arg); }
	public function validate_groupid(Module_Forum $module, $arg) { return $this->_module->validate_groupid($arg); }
	public function validate_title(Module_Forum $module, $arg) { return $this->_module->validate_title($arg); }
	public function validate_descr(Module_Forum $module, $arg) { return $this->_module->validate_descr($arg); }
	
	#################
	### Add Board ###
	#################
	private function onAddBoard()
	{
		$form = $this->getForm($this->_module);
		if (false !== ($error = $form->validate($this->_module))) {
			return $error.$this->templateAddBoard($this->_module);
		}
		
		$title = $form->getVar('title');
		$descr = $form->getVar('descr');
		$parentid = $form->getVar('parentid');
		$groupid = $form->getVar('groupid');

		$options = 0;
		$options |= Common::getPost('allow_threads') === false ? 0 : GWF_ForumBoard::ALLOW_THREADS;
		$options |= Common::getPost('is_locked') === false ? 0 : GWF_ForumBoard::LOCKED;
		$options |= Common::getPost('guests') === false ? 0 : GWF_ForumBoard::GUEST_POSTS;
		$options |= Common::getPost('guest_view') === false ? 0 : GWF_ForumBoard::GUEST_VIEW;
		
		if (false === ($board = GWF_ForumBoard::createBoard($title, $descr, $parentid, $options, $groupid))) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}

		return $this->_module->message('msg_board_added', array($board->getParent()->getShowBoardHREF()));
	}
}
