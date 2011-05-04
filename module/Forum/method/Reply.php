<?php

final class Forum_Reply extends GWF_Method
{
	/**
	 * @var GWF_ForumThread
	 */
	private $thread;
	
	/**
	 * @var GWF_ForumPost
	 */
	private $post;
	
	private $replyThread = false;
	private $quoted = false;
	
	##############
	### Method ###
	##############
	public function getHTAccess(GWF_Module $module)
	{
		return
			'RewriteRule ^forum/quote/post/([0-9]+)/[^/]+$ index.php?mo=Forum&me=Reply&pid=$1&quote=yes'.PHP_EOL.
			'RewriteRule ^forum/reply/to/post/([0-9]+)/[^/]+$ index.php?mo=Forum&me=Reply&pid=$1'.PHP_EOL.
			'RewriteRule ^forum/reply/to/thread/([0-9]+)/[^/]+$ index.php?mo=Forum&me=Reply&tid=$1'.PHP_EOL;
	}
	
	public function execute(GWF_Module $module)
	{
		if (false !== ($error = $this->sanitize($module))) {
			return $error;
		}
		
		if (false !== (Common::getPost('submit_preview'))) {
			return $this->onPreview($module);
		}
		
		if (false !== (Common::getPost('submit_reply'))) {
			return $this->onReply($module);
		}
		
		return $this->templateLastPosts($module).$this->templateReply($module);
	}
	
	################
	### Sanitize ###
	################
	private function sanitize(Module_Forum $module)
	{
		$this->quoted = Common::getGet('quote') !== false;
		
		if (false === ($pid = Common::getGet('pid'))) {
			if (false === ($this->thread = $module->getCurrentThread())) {
				return $module->error('err_post');
			}
			if (false === ($this->post = $this->thread->getLastPost())) {
//				return $module->error('err_post');
			}
			$this->replyThread = true;
		}
		elseif (false === ($this->post = $module->getCurrentPost())) {
			return $module->error('err_post');
		}
		else {
			if (false === ($this->thread = $this->post->getThread())) {
				return $module->error('err_post');
			}
		}
		
		# Check Permission
		$user = GWF_Session::getUser();
		if (!$this->thread->hasReplyPermission($user, $module)) {
			$a = GWF_HTML::display($this->post->getShowHREF());
			return $module->error('err_reply_perm', array($a));
		}
		
		if (false !== ($last_post = $this->thread->getLastPost()))
		{
			if ($last_post->getPosterID() === GWF_Session::getUserID()) {
				if (!$module->cfgDoublePost())
				{
					$a = GWF_HTML::display($this->post->getShowHREF());
					return $module->error('err_better_edit', array($a));
				}
			}
		}
		
		return false;
	}
	
	############
	### Form ###
	############
	private function getForm(Module_Forum $module)
	{
		$msg = $this->quoted === true ? $this->getQuotedMessage() : '';
		$buttons = array(
			'submit_reply' => $module->lang('btn_reply'),
			'submit_preview' => $module->lang('btn_preview'),
		);
		$data = array(
			'title' => array(GWF_Form::STRING, $this->getReplyTitle(), $module->lang('th_title')),
			'message' => array(GWF_Form::MESSAGE, $msg, $module->lang('th_message')),
			'smileys' => array(GWF_Form::CHECKBOX, false, $module->lang('th_smileys')),
			'bbcode' => array(GWF_Form::CHECKBOX, false, $module->lang('th_bbcode')),
//			'guest_view' => array(GWF_Form::CHECKBOX, $this->thread->isGuestView(), $module->lang('th_guest_view')),
			'submit' => array(GWF_Form::SUBMITS, $buttons, ''),
		);
		return new GWF_Form($this, $data);
	}
	
	private function getReplyTitle()
	{
		$title = $this->replyThread === true ? $this->thread->getVar('thread_title') : $this->post->getVar('post_title');
		if (!Common::startsWith($title, 'RE: '))
		{
			$title = 'RE: '.$title;
		}
		return $title;
		#return GWF_HTML::display($title);
	}
	
	private function getQuotedMessage()
	{
		$msg = $this->post->getVar('post_message');
		$uname = $this->post->getUser()->displayUsername();
		$date = $this->post->getVar('post_date'); # displayPostDate();
		return sprintf('[quote=%s date=%s]%s[/quote]', $uname, $date, PHP_EOL.$msg.PHP_EOL).PHP_EOL;
	}
	
	################
	### Template ###
	################
	private function templateReply(Module_Forum $module, $preview=false)
	{
		$form = $this->getForm($module);
		
		$url = Common::getCurrentURL();
		if (!Common::endsWith($url, '#form')) {
			$url .= '#form';
		}
		
		$tVars = array(
			'form' => $form->templateY($module->lang('ft_reply'), $url),
			'preview' => $preview,
		);
		return $module->templatePHP('reply.php', $tVars);
	}
	
	private function templateLastPosts(Module_Forum $module)
	{
		$tVars = array(
			'thread' => $this->thread,
			'posts' => $this->getLastPosts($module->getLastPostsReply()),
			'pagemenu' => '',
			'actions' => false,
			'title' => true,
			'reply' => true,
			'nav' => false,
			'can_vote' => false,
			'can_thank' => false,
			'term' => array(),
		);
		return $module->templatePHP('show_thread.php', $tVars);
	}
	
	private function getLastPosts($count)
	{
		$tid = $this->thread->getID();
		return array_reverse(GDO::table('GWF_ForumPost')->selectObjects('*', "post_tid=$tid", "post_date DESC", $count));
	}
	
	###############
	### Preview ###
	###############
	private function onPreview(Module_Forum $module)
	{
		$form = $this->getForm($module);
		$error = $form->validate($module);

		$user = GWF_Session::getUser();
		$title = $form->getVar('title');
		$message = $form->getVar('message');

		$options = 0;
		$options |= Common::getPost('bbcode') === false ? 0 : GWF_ForumPost::DISABLE_BB;
		$options |= Common::getPost('smileys') === false ? 0 : GWF_ForumPost::DISABLE_SMILE;
		
		$tVars = array(
			'thread' => GWF_ForumThread::fakeThread($user, $title),
			'posts' => array(GWF_ForumPost::fakePost($user, $title, $message, $options, 0, 0, true, true)),
			'pagemenu' => '', 
			'actions' => false,
			'title' => false,
			'reply' => true,
			'nav' => false,
			'can_vote' => false,
			'can_thank' => false,
			'term' => '',
		);
		
		return $error.
			$this->templateLastPosts($module).
			'<a name="form"></a>'.
			$module->templatePHP('show_thread.php', $tVars).
			$this->templateReply($module, true);
	}
	
	#############
	### Reply ###
	#############
	private function onReply(Module_Forum $module)
	{
		$form = $this->getForm($module);
		if (false !== ($error = $form->validate($module))) {
			return $error.$this->templateReply($module);
		}
		
		# Gather vars
		$user = GWF_Session::getUser();
		$is_mod = $user === false && $module->isGuestPostModerated();
		
		$title = $form->getVar('title');
		$message = $form->getVar('message');
		$options = 0;
		$options |= Common::getPost('bbcode') === false ? 0 : GWF_ForumPost::DISABLE_BB;
		$options |= Common::getPost('smileys') === false ? 0 : GWF_ForumPost::DISABLE_SMILE;
		$options |= $is_mod ? GWF_ForumPost::IN_MODERATION : 0;
//		$options |= Common::getPost('guest_view') === false ? 0 : $this->thread->isGuestView();
		$options |= $this->thread->isGuestView() ? GWF_ForumPost::GUEST_VIEW : 0;
		
		$threadid = $this->thread->getID();
		$groupid = $this->thread->getGroupID();
		
		# Post it
		$post = GWF_ForumPost::fakePost($user, $title, $message, $options, $threadid, $groupid);
		if (false === ($post->insert())) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		
		if (!$is_mod)
		{
			if (false === $post->onApprove($module)) {
				return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
			}
//			$this->thread->increase('thread_postcount', 1); # Increase cache :/
			
			$module->cachePostcount();
			
			return $module->message('msg_posted', array($post->getThread()->getLastPageHREF()));
		}
		else
		{
			GWF_ForumSubscription::sendModeratePost($module, $post);
			return $module->message('msg_posted_mod', array($this->thread->getLastPageHREF()));
		}
	}
	
	##################
	### Validators ###
	##################
	public function validate_title(Module_Forum $module, $arg) { return $module->validate_title($arg); }
	public function validate_message(Module_Forum $module, $arg) { return $module->validate_message($arg); }
	
}

?>