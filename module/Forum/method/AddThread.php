<?php

final class Forum_AddThread extends GWF_Method
{
	/**
	 * @var GWF_ForumBoard
	 */
	private $board = false;
	
	
	public function getHTAccess(GWF_Module $module)
	{
		return 'RewriteRule ^forum/add/thread/([0-9]+)/[^/]+$ index.php?mo=Forum&me=AddThread&bid=$1'.PHP_EOL;
	}
	
	public function execute(GWF_Module $module)
	{
		if (false !== ($error = $this->sanitize($module))) {
			return $error;
		}
		
		if (false !== (Common::getPost('preview'))) {
			return $this->onPreview($module);
		}
		
		if (false !== (Common::getPost('add_thread'))) {
			return $this->onAddThread($module);
		}
		
		return $this->templateAddThread($module);
	}
	
	private function sanitize(Module_Forum $module)
	{
		if (false !== ($error = $module->isNewThreadAllowed())) {
			return $error;
		}
		
		$this->board = $module->getCurrentBoard();
		
		return false;
	}
	
	private function getForm(Module_Forum $module)
	{
		$buttons = array(
			'add_thread' => $module->lang('btn_add_thread'),
			'preview' => $module->lang('btn_preview'),
		);
		$b = $this->board;
		$data = array(
			'title' => array(GWF_Form::STRING, '', $module->lang('th_title')),
			'message' => array(GWF_Form::MESSAGE, '', $module->lang('th_message')),
			'smileys' => array(GWF_Form::CHECKBOX, false, $module->lang('th_smileys')),
//			'guest_view' => array(GWF_Form::CHECKBOX, $b->isGuestView(), $module->lang('th_guest_view')),
			'bbcode' => array(GWF_Form::CHECKBOX, false, $module->lang('th_bbcode')),
			'submit' => array(GWF_Form::SUBMITS, $buttons, ''),
		);
		return new GWF_Form($this, $data);
	}
	
	private function templateAddThread(Module_Forum $module, $nav=true)
	{
		$form = $this->getForm($module);
		$tVars = array(
			'nav' => $nav,
			'form' => $form->templateY($module->lang('ft_add_thread')),
		);
		return $module->templatePHP('add_thread.php', $tVars);
	}
	
	##################
	### Validators ###
	##################
	public function validate_title(Module_Forum $module, $arg) { return $module->validate_title($arg); }
	public function validate_message(Module_Forum $module, $arg) { return $module->validate_message($arg); }
	
	###############
	### Preview ###
	###############
	private function onPreview(Module_Forum $module)
	{
		$user = GWF_Session::getUser();
		
		$form = $this->getForm($module);
		
		$errors = $form->validate($module);
		
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
			'title' => true,
			'nav' => true,
			'term' => '',
		);
		
		return $errors.$module->templatePHP('show_thread.php', $tVars).$this->templateAddThread($module, false);
	}
	
	private function onAddThread(Module_Forum $module)
	{
		$form = $this->getForm($module);
		
		if (false !== ($error = $form->validate($module))) {
			return $error.$this->templateAddThread($module);
		}
		
		$user = GWF_Session::getUser();
		$is_mod = $user === false && $module->isGuestPostModerated();
		
		$title = $form->getVar('title');
		$message = $form->getVar('message');
		$bid = $this->board->getID();
		$gid = $this->board->getGroupID();
		$options = 0;
		$options |= $is_mod === false ? 0 : GWF_ForumThread::IN_MODERATION;
		$options |= $this->board->isGuestView() ? GWF_ForumThread::GUEST_VIEW : 0;
//		$options |= Common::getPost('guest_view') === false ? 0 : GWF_ForumThread::GUEST_VIEW;
		
		$thread = GWF_ForumThread::fakeThread($user, $title, $bid, $gid, 1, $options);
		if (false === ($thread->insert())) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}

		$tid = $thread->getID();
		$gid = $thread->getGroupID();
		$options = 0;
		$options |= Common::getPost('bbcode') === false ? 0 : GWF_ForumPost::DISABLE_BB;
		$options |= Common::getPost('smileys') === false ? 0 : GWF_ForumPost::DISABLE_SMILE;
		$options |= $is_mod === false ? 0 : GWF_ForumPost::IN_MODERATION;
		$options |= $this->board->isGuestView() ? GWF_ForumPost::GUEST_VIEW : 0;
		
		$post = GWF_ForumPost::fakePost($user, $title, $message, $options, $tid, $gid);
		if (false === ($post->insert())) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		if (!$is_mod)
		{
			$thread->onApprove();
//			$module->cachePostcoun();
			return $module->message('msg_posted', array($thread->getLastPageHREF()));
		}
		else
		{
			GWF_ForumSubscription::sendModerateThread($module, $thread, $message);
			return $module->message('msg_posted_mod', array($this->board->getShowBoardHREF()));
		}
	}
}

?>