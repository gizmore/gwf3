<?php

final class Forum_EditBoard extends GWF_Method
{
	/**
	 * @var GWF_ForumBoard
	 */
	private $board;
	
	public function getUserGroups() { return GWF_Group::ADMIN; }
	
	public function getHTAccess(GWF_Module $module)
	{
		return 'RewriteRule ^forum/edit/board/([0-9]+)/[^/]+$ index.php?mo=Forum&me=EditBoard&bid=$1'.PHP_EOL;
	}
	
	public function execute(GWF_Module $module)
	{
		if (false !== ($error = $this->sanitize($module))) {
			return $error;
		}
		
		if (false !== (Common::getPost('delete_board'))) {
			return $this->onDeleteBoard($module);
		}
		if (false !== (Common::getPost('edit_board'))) {
			return $this->onEditBoard($module).$this->templateEditBoard($module);
		}
		
		return $this->templateEditBoard($module);
	}
	
	private function sanitize(Module_Forum $module)
	{
		if (false === ($this->board = $module->getCurrentBoard())) {
			return $module->error('err_board');
		}
		return false;
	}
	
	private function getForm(Module_Forum $module)
	{
		$buttons = array(
			'edit_board' => $module->lang('btn_edit_board'),
			'delete_board' => $module->lang('btn_rem_board'),
		);
		$data = array(
			'groupid' => array(GWF_Form::SELECT, $module->getGroupSelect($this->board->getGroupID()), $module->lang('th_groupid')),
			'title' => array(GWF_Form::STRING, $this->board->display('board_title'), $module->lang('th_title'), 48),
			'descr' => array(GWF_Form::STRING, $this->board->display('board_descr'), $module->lang('th_descr'), 48),
			'allow_threads' => array(GWF_Form::CHECKBOX, $this->board->isThreadAllowed(), $module->lang('th_thread_allowed')),
			'guest_view' => array(GWF_Form::CHECKBOX, $this->board->isGuestView(), $module->lang('th_guest_view')),
			'is_locked' => array(GWF_Form::CHECKBOX, $this->board->isLocked(), $module->lang('th_locked')),
			'guests' => array(GWF_Form::CHECKBOX, $this->board->isGuestPostAllowed(), $module->lang('th_guests')),
		);
		
//		if (!$this->board->isRoot()) {
//			$data['moveboard'] = array(GWF_Form::SELECT, $this->board->getBoardSelect(), $module->lang('th_move_board'), 0, 'GWF_ForumBoard');
//		} 
		$data['submit'] = array(GWF_Form::SUBMITS, $buttons, '');
		return new GWF_Form($this, $data);
	}

	private function templateEditBoard(Module_Forum $module)
	{
		$form = $this->getForm($module);
		$tVars = array(
			'form' => $form->templateY($module->lang('ft_edit_board')),
		);
		return $module->templatePHP('edit_board.php', $tVars);
	}

	private function onEditBoard(Module_Forum $module)
	{
		$form = $this->getForm($module);
		
		if (false !== ($error = $form->validate($module))) {
			return $error;
		}
		
		if (!$this->board->isRoot())
		{
			$bid = $this->board->getID();
			if ($bid !== ($newpid = (int)$form->getVar('moveboard'))) {
				if ($this->board->getParentID() !== $newpid) {
					if (false !== ($newparent = GWF_ForumBoard::getBoard($newpid))) {
						if (false === $this->board->move($newparent)) {
							return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
						}
					}
				}
			}
		}
		
		$this->board->saveVars(array(
			'board_gid' => $form->getVar('groupid'),
			'board_title' => $form->getVar('title'),
			'board_descr' => $form->getVar('descr'),
		));
		
//		if (!$this->board->isRoot())
//		{
			$this->board->saveOption(GWF_ForumBoard::ALLOW_THREADS, Common::getPost('allow_threads') !== false);
			$this->board->saveOption(GWF_ForumBoard::LOCKED, Common::getPost('is_locked') !== false);
			$this->board->saveOption(GWF_ForumBoard::GUEST_POSTS, Common::getPost('guests') !== false);
			$this->board->saveOption(GWF_ForumBoard::GUEST_VIEW, Common::getPost('guest_view') !== false);
//		}
		
		
		return $module->message('msg_edited_board', array($this->board->getShowBoardHREF()));
	}
	
	##################
	### Validators ###
	##################
	public function validate_title(Module_Forum $module, $arg) { return $module->validate_title($arg); }
	public function validate_descr(Module_Forum $module, $arg) { return $module->validate_descr($arg); }
	public function validate_groupid(Module_Forum $module, $arg) { return $module->validate_groupid($arg); }
	public function validate_moveboard(Module_Forum $module, $arg) { return $module->validate_parentid($arg); }
	
	##############
	### Delete ###
	##############
	public function onDeleteBoard(Module_Forum $module)
	{
		if (false === ($this->board->deleteBoard())) {
			return GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
		}
		
		return $module->message('msg_board_deleted');
	}
}

?>
