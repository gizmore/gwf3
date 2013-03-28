<?php

final class Forum_EditBoard extends GWF_Method
{
	/**
	 * @var GWF_ForumBoard
	 */
	private $board;
	
	public function getUserGroups() { return GWF_Group::ADMIN; }
	
	public function getHTAccess()
	{
		return 'RewriteRule ^forum/edit/board/([0-9]+)/[^/]+$ index.php?mo=Forum&me=EditBoard&bid=$1'.PHP_EOL;
	}
	
	public function execute()
	{
		if (false !== ($error = $this->sanitize())) {
			return $error;
		}
		
		if (false !== (Common::getPost('delete_board'))) {
			return $this->onDeleteBoard();
		}
		if (false !== (Common::getPost('edit_board'))) {
			return $this->onEditBoard().$this->templateEditBoard();
		}
		
		return $this->templateEditBoard();
	}
	
	private function sanitize()
	{
		if (false === ($this->board = $this->module->getCurrentBoard())) {
			return $this->module->error('err_board');
		}
		return false;
	}
	
	private function getForm()
	{
		$buttons = array(
			'edit_board' => $this->module->lang('btn_edit_board'),
			'delete_board' => $this->module->lang('btn_rem_board'),
		);
		$data = array(
			'groupid' => array(GWF_Form::SELECT, $this->module->getGroupSelect($this->board->getGroupID()), $this->module->lang('th_groupid')),
			'title' => array(GWF_Form::STRING, $this->board->display('board_title'), $this->module->lang('th_title')),
			'descr' => array(GWF_Form::STRING, $this->board->display('board_descr'), $this->module->lang('th_descr')),
			'allow_threads' => array(GWF_Form::CHECKBOX, $this->board->isThreadAllowed(), $this->module->lang('th_thread_allowed')),
			'guest_view' => array(GWF_Form::CHECKBOX, $this->board->isGuestView(), $this->module->lang('th_guest_view')),
			'is_locked' => array(GWF_Form::CHECKBOX, $this->board->isLocked(), $this->module->lang('th_locked')),
			'guests' => array(GWF_Form::CHECKBOX, $this->board->isGuestPostAllowed(), $this->module->lang('th_guests')),
			'invisible' => array(GWF_Form::CHECKBOX, $this->board->isInvisible(), $this->module->lang('th_invisible')),				
		);
		
//		if (!$this->board->isRoot()) {
//			$data['moveboard'] = array(GWF_Form::SELECT, $this->board->getBoardSelect(), $this->module->lang('th_move_board'), 0, 'GWF_ForumBoard');
//		} 
		$data['submit'] = array(GWF_Form::SUBMITS, $buttons, '');
		return new GWF_Form($this, $data);
	}

	private function templateEditBoard()
	{
		$form = $this->getForm();
		$tVars = array(
			'form' => $form->templateY($this->module->lang('ft_edit_board')),
		);
		return $this->module->templatePHP('edit_board.php', $tVars);
	}

	private function onEditBoard()
	{
		$form = $this->getForm();
		
		if (false !== ($error = $form->validate($this->module))) {
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

		# Options
		$this->board->saveOption(GWF_ForumBoard::ALLOW_THREADS, Common::getPost('allow_threads') !== false);
		$this->board->saveOption(GWF_ForumBoard::LOCKED, Common::getPost('is_locked') !== false);
		$this->board->saveOption(GWF_ForumBoard::GUEST_POSTS, Common::getPost('guests') !== false);
		$this->board->saveOption(GWF_ForumBoard::GUEST_VIEW, Common::getPost('guest_view') !== false);
		if (!$this->board->isRoot())
		{
			$this->board->saveOption(GWF_ForumBoard::INVISIBLE, Common::getPost('invisible') !== false);
		}
			
		return $this->module->message('msg_edited_board', array($this->board->getShowBoardHREF()));
	}
	
	##################
	### Validators ###
	##################
	public function validate_title(Module_Forum $module, $arg) { return $this->module->validate_title($arg); }
	public function validate_descr(Module_Forum $module, $arg) { return $this->module->validate_descr($arg); }
	public function validate_groupid(Module_Forum $module, $arg) { return $this->module->validate_groupid($arg); }
	public function validate_moveboard(Module_Forum $module, $arg) { return $this->module->validate_parentid($arg); }
	
	##############
	### Delete ###
	##############
	public function onDeleteBoard()
	{
		if (false === ($this->board->deleteBoard())) {
			return GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
		}
		
		return $this->module->message('msg_board_deleted');
	}
}

?>
