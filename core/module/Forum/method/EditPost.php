<?php

final class Forum_EditPost extends GWF_Method
{
	/**
	 * @var GWF_ForumPost
	 */
	private $post;
	
	/**
	 * @var GWF_ForumThread
	 */
	private $thread;
	
	##############
	### Method ###
	##############
	public function isLoginRequired() { return true; }
	
	public function getHTAccess()
	{
		return 'RewriteRule ^forum/edit/post/([0-9]+)/ index.php?mo=Forum&me=EditPost&pid=$1'.PHP_EOL;
	}
	
	public function execute()
	{
		if (false !== ($error = $this->sanitize())) {
			return $error;
		}
		
		if (false !== (Common::getPost('preview'))) {
			return $this->onPreview();
		}
		
		if (false !== (Common::getPost('edit'))) {
			return $this->onEdit();
		}
		if (false !== (Common::getPost('delete'))) {
			return $this->onDelete();
		}
		
		return $this->templateEdit();
	}
	
	################
	### Sanitize ###
	################
	private function sanitize()
	{
		if (false === ($this->post = $this->_module->getCurrentPost())) {
			return $this->_module->error('err_post');
		}
		if (false === ($this->thread = $this->_module->getCurrentThread())) {
			return $this->_module->error('err_thread');
		}
		if (!$this->post->hasEditPermission()) {
			return GWF_HTML::err('ERR_NO_PERMISSION');
		}
		return false;
	}
	
	############
	### Form ###
	############
	public function validate_title(Module_Forum $module, $arg) { return $this->_module->validate_title($arg); }
	public function validate_message(Module_Forum $module, $arg) { return $this->_module->validate_message($arg); }
	public function getForm()
	{
		$p = $this->post;
		$buttons = array(
			'preview' => $this->_module->lang('btn_preview'),
			'edit' => $this->_module->lang('btn_edit'),
			'delete' => $this->_module->lang('th_delete'),
		);
		$data = array(
			'title' => array(GWF_Form::STRING, $p->getVar('post_title'), $this->_module->lang('th_title')),
			'message' => array(GWF_Form::MESSAGE, $p->getVar('post_message'), $this->_module->lang('th_message')),
			'smileys' => array(GWF_Form::CHECKBOX, false, $this->_module->lang('th_smileys')),
			'bbcode' => array(GWF_Form::CHECKBOX, false, $this->_module->lang('th_bbcode')),
			'unread' => array(GWF_Form::CHECKBOX, true, $this->_module->lang('th_unread_again')),
			'cmds' => array(GWF_Form::SUBMITS, $buttons,),
		);
		return new GWF_Form($this, $data);
	}
	
	################
	### Template ###
	################
	public function templateEdit()
	{
		$form = $this->getForm();
		$tVars = array(
			'form' => $form->templateY($this->_module->lang('ft_edit_post')),
		);
		return $this->_module->templatePHP('edit_post.php', $tVars);
	}
	
	###############
	### Preview ###
	###############
	public function onPreview()
	{
		$form = $this->getForm();
		
		$errors = $form->validate($this->_module);
		
//		$user = GWF_Session::getUser();
		$user = $this->post->getUser(true);
		$title = $form->getVar('title');
		$message = $form->getVar('message');
		
		$options = 0;
		$options |= Common::getPost('bbcode') === false ? 0 : GWF_ForumPost::DISABLE_BB;
		$options |= Common::getPost('smileys') === false ? 0 : GWF_ForumPost::DISABLE_SMILE;
		
		$tVars = array(
			'thread' => GWF_ForumThread::fakeThread($user, $title),
			'posts' => array(GWF_ForumPost::fakePost($user, $title, $message, $options, 0, 0, GWF_Time::getDate(GWF_Date::LEN_SECOND), true)),
			'pagemenu' => '', 
			'actions' => false,
			'title' => false,
			'reply' => true,
			'nav' => false,
			'term' => '',
			'page' => 0,
			'href_edit' => '',
		);
		$preview = $this->_module->templatePHP('show_thread.php', $tVars);
		
		
		return $errors.$preview.$this->templateEdit();
	}
	
	############
	### Edit ###
	############
	public function onEdit()
	{
		$p = $this->post;
		$form = $this->getForm();
		if (false !== ($error = $form->validate($this->_module))) {
			return $error.$this->templateEdit();
		}
		
		if (false === GWF_ForumPostHistory::pushPost($p)) {
			return GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
		}
		
		$user = GWF_Session::getUser();
		
		if (false === $p->saveVars(array(
			'post_title' => $form->getVar('title'),
			'post_message' => $form->getVar('message'),
			'post_euid' => $user->getVar('user_id'),
			'post_eusername' => $user->getVar('user_name'),
			'post_edate' => GWF_Time::getDate(GWF_Date::LEN_SECOND),
		
		))) { return GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__); }
		
		$p->saveOption(GWF_ForumPost::DISABLE_BB, isset($_POST['bbcode']));
		$p->saveOption(GWF_ForumPost::DISABLE_SMILE, isset($_POST['smileys']));
		
		if (isset($_POST['unread'])) {
			$t = $p->getThread();
			$t->markUnRead(GWF_Session::getUserID());
			$t->saveVar('thread_lastdate', GWF_Time::getDate(GWF_Date::LEN_SECOND));
			$p->saveOption(GWF_ForumPost::MAIL_OUT, true);
		}
		
		$a = GWF_HTML::display($p->getShowHREF());
		return $this->_module->message('msg_post_edited', array($a));
	}

	public function onDelete()
	{
		$p = $this->post;
		$form = $this->getForm();
		if (false !== ($error = $form->validate($this->_module))) {
			return $error.$this->templateEdit();
		}
		
		if (false === $p->deletePost()) {
			return GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__).$this->templateEdit();
		}
		
		$this->_module->cachePostcount();
		
		return $this->_module->message('msg_post_deleted');
	}
}

?>