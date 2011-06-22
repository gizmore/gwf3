<?php
final class Comments_Edit extends GWF_Method
{
	private $comment;
	private $comments;
	
	public function execute(GWF_Module $module)
	{
		if (false !== ($error = $this->sanitize($module))) {
			return $error;
		}
		
		return $this->templateEdit($module);
	}
	
	public function sanitize(Module_Comments $module)
	{
		if (false === ($c = GWF_Comment::getByID(Common::getGetString('cmt_id'))))
		{
			return $module->error('err_comment');
		}
		
		if (false === ($c2 = $c->getComments()))
		{
			return $module->error('err_comments');
		}
		
		if (false === $c2->canModerate(GWF_Session::getUser()))
		{
			return GWF_HTML::err('ERR_NO_PERMISSION');
		}
		
		$this->comment = $c;
		$this->comments = $c2;
		
		return false;
	}
	
	public function templateEdit(Module_Comments $module)
	{
		$formComment = $this->formComment($module);
		$formComments = $this->formComments($module);
		
		$tVars = array(
			'form_cmt' => $formComment->templateY($module->lang('ft_edit_cmt')),
			'form_cmts' => $formComments->templateY($module->lang('ft_edit_cmts')),
		);
		
		return $module->template('edit.tpl', $tVars);
	}
	
	public function formComment(Module_Comments $module)
	{
		$c = $this->comment;
		
		
		
		$data = array(
			'message' => array(GWF_Form::MESSAGE, $this->comment->getVar('cmt_message')),
			'btns' => array(GWF_Form::SUBMITS, $buttons),
		);
		return new GWF_Form($this, $data);
	}

	public function formComments(Module_Comments $module)
	{
		$data = array(
		);
		return new GWF_Form($this, $data);
	}
}
?>