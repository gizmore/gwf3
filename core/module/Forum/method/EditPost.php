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
	
	public function getHTAccess(GWF_Module $module)
	{
		return 'RewriteRule ^forum/edit/post/([0-9]+)/ index.php?mo=Forum&me=EditPost&pid=$1'.PHP_EOL;
	}
	
	public function execute(GWF_Module $module)
	{
		if (false !== ($error = $this->sanitize($module))) {
			return $error;
		}
		
		if (false !== (Common::getPost('preview'))) {
			return $this->onPreview($module);
		}
		
		if (false !== (Common::getPost('edit'))) {
			return $this->onEdit($module);
		}
		if (false !== (Common::getPost('delete'))) {
			return $this->onDelete($module);
		}
		
		return $this->templateEdit($module);
	}
	
	################
	### Sanitize ###
	################
	private function sanitize(Module_Forum $module)
	{
		if (false === ($this->post = $module->getCurrentPost())) {
			return $module->error('err_post');
		}
		if (false === ($this->thread = $module->getCurrentThread())) {
			return $module->error('err_thread');
		}
		if (!$this->post->hasEditPermission()) {
			return GWF_HTML::err('ERR_NO_PERMISSION');
		}
		return false;
	}
	
	############
	### Form ###
	############
	public function validate_title(Module_Forum $module, $arg) { return $module->validate_title($arg); }
	public function validate_message(Module_Forum $module, $arg) { return $module->validate_message($arg); }
	public function getForm(Module_Forum $module)
	{
		$p = $this->post;
		$buttons = array(
			'preview' => $module->lang('btn_preview'),
			'edit' => $module->lang('btn_edit'),
			'delete' => $module->lang('th_delete'),
		);
		$data = array(
			'title' => array(GWF_Form::STRING, $p->getVar('post_title'), $module->lang('th_title')),
			'message' => array(GWF_Form::MESSAGE, $p->getVar('post_message'), $module->lang('th_message')),
			'smileys' => array(GWF_Form::CHECKBOX, false, $module->lang('th_smileys')),
			'bbcode' => array(GWF_Form::CHECKBOX, false, $module->lang('th_bbcode')),
			'unread' => array(GWF_Form::CHECKBOX, true, $module->lang('th_unread_again')),
			'cmds' => array(GWF_Form::SUBMITS, $buttons,),
		);
		return new GWF_Form($this, $data);
	}
	
	################
	### Template ###
	################
	public function templateEdit(Module_Forum $module)
	{
		$form = $this->getForm($module);
		$tVars = array(
			'form' => $form->templateY($module->lang('ft_edit_post')),
		);
		return $module->templatePHP('edit_post.php', $tVars);
	}
	
	###############
	### Preview ###
	###############
	public function onPreview(Module_Forum $module)
	{
		$form = $this->getForm($module);
		
		$errors = $form->validate($module);
		
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
		$preview = $module->templatePHP('show_thread.php', $tVars);
		
		
		return $errors.$preview.$this->templateEdit($module);
	}
	
	############
	### Edit ###
	############
	public function onEdit(Module_Forum $module)
	{
		$p = $this->post;
		$form = $this->getForm($module);
		if (false !== ($error = $form->validate($module))) {
			return $error.$this->templateEdit($module);
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
		return $module->message('msg_post_edited', $a);
	}

	public function onDelete(Module_Forum $module)
	{
		$p = $this->post;
		$form = $this->getForm($module);
		if (false !== ($error = $form->validate($module))) {
			return $error.$this->templateEdit($module);
		}
		
		if (false === $p->deletePost()) {
			return GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__).$this->templateEdit($module);
		}
		
		$module->cachePostcount();
		
		return $module->message('msg_post_deleted');
	}
}

?>