<?php
final class Comments_Edit extends GWF_Method
{
	private $comment;
	private $comments;
	
	public function execute()
	{
		if (false !== ($error = $this->sanitize($this->_module))) {
			return $error;
		}
		
		$back = '';
		
		if (isset($_POST['editcmt']))
		{
			$back = $this->onEditComment($this->_module);
		}
		elseif (isset($_POST['editcmts']))
		{
			$back = $this->onEditComments($this->_module);
		}
		
		return $back . $this->templateEdit($this->_module);
	}
	
	public function sanitize()
	{
		if (false === ($c = GWF_Comment::getByID(Common::getGetString('cmt_id'))))
		{
			return $this->_module->error('err_comment');
		}
		
		if (false === ($c2 = $c->getComments()))
		{
			return $this->_module->error('err_comments');
		}
		
		if (false === $c2->canModerate(GWF_Session::getUser()))
		{
			return GWF_HTML::err('ERR_NO_PERMISSION');
		}
		
		$this->comment = $c;
		$this->comments = $c2;
		
		return false;
	}
	
	public function templateEdit()
	{
		$formComment = $this->formComment($this->_module);
		$formComments = $this->formComments($this->_module);
		
		$tVars = array(
			'form_cmt' => $formComment->templateY($this->_module->lang('ft_edit_cmt')),
			'form_cmts' => $formComments->templateY($this->_module->lang('ft_edit_cmts')),
		);
		
		return $this->_module->template('edit.tpl', $tVars);
	}
	
	public function formComment()
	{
		$c = $this->comment;
		
		$buttons = array('editcmt' => $this->_module->lang('btn_edit'));
		
		$data = array(
			'message' => array(GWF_Form::MESSAGE, $this->comment->getVar('cmt_message'), $this->_module->lang('th_message')),
			'btns' => array(GWF_Form::SUBMITS, $buttons),
		);
		return new GWF_Form($this, $data);
	}

	public function formComments()
	{
		$buttons = array('editcmts' => $this->_module->lang('btn_edit'));
		$data = array(
			'btns' => array(GWF_Form::SUBMITS, $buttons),
		);
		return new GWF_Form($this, $data);
	}
	
	public function validate_message($m, $arg) { return GWF_Validator::validateString($m, 'message', $arg, 8, $m->cfgMaxMsgLen(), false); }
	
	public function onEditComment()
	{
		$formComment = $this->formComment($this->_module);
		if (false !== ($error = $formComment->validate($this->_module)))
		{
			return $error;
		}
		
		if (false === $this->comment->saveVars(array(
			'cmt_message' => $formComment->getVar('message'),
		)))
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		return $this->_module->message('msg_edited');
	}

	public function onEditComments()
	{
		$formComments = $this->formComments($this->_module);
		if (false !== ($error = $formComments->validate($this->_module)))
		{
			return $error;
		}
		return $this->_module->message('msg_edited');
	}
}
?>