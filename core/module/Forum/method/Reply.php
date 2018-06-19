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
	public function getHTAccess()
	{
		return
			'RewriteRule ^forum/quote/post/([0-9]+)/[^/]+$ index.php?mo=Forum&me=Reply&pid=$1&quote=yes'.PHP_EOL.
			'RewriteRule ^forum/reply/to/post/([0-9]+)/[^/]+$ index.php?mo=Forum&me=Reply&pid=$1'.PHP_EOL.
			'RewriteRule ^forum/reply/to/thread/([0-9]+)/[^/]+$ index.php?mo=Forum&me=Reply&tid=$1'.PHP_EOL;
	}
	
	public function execute()
	{
		if (false !== ($error = $this->sanitize())) {
			return $error;
		}
		
		if (false !== (Common::getPost('submit_preview'))) {
			return $this->onPreview();
		}
		
		if (false !== (Common::getPost('submit_reply'))) {
			return $this->onReply();
		}
		
		return $this->templateLastPosts().$this->templateReply();
	}
	
	################
	### Sanitize ###
	################
	private function sanitize()
	{
		$this->quoted = Common::getGet('quote') !== false;
		
		if (false === ($pid = Common::getGet('pid'))) {
			if (false === ($this->thread = $this->module->getCurrentThread())) {
				return $this->module->error('err_post');
			}
			if (false === ($this->post = $this->thread->getLastPost())) {
//				return $this->module->error('err_post');
			}
			$this->replyThread = true;
		}
		elseif (false === ($this->post = $this->module->getCurrentPost())) {
			return $this->module->error('err_post');
		}
		else {
			if (false === ($this->thread = $this->post->getThread())) {
				return $this->module->error('err_post');
			}
		}
		
		# Check Permission
		$user = GWF_Session::getUser();
		if (!$this->thread->hasReplyPermission($user, $this->module)) {
			if ($this->post !== false)
			{
				$a = GWF_HTML::display($this->post->getShowHREF());
			} else {
				$a = GWF_HTML::display($this->thread->getLastPageHREF());
			}
			return $this->module->error('err_reply_perm', array($a));
		}
		
		if (false !== ($last_post = $this->thread->getLastPost()))
		{
			if ($last_post->getPosterID() === GWF_Session::getUserID()) {
				if (!$this->module->cfgDoublePost())
				{
					$a = GWF_HTML::display($this->post->getShowHREF());
					return $this->module->error('err_better_edit', array($a));
				}
			}
		}
		
		return false;
	}
	
	############
	### Form ###
	############
	private function getForm()
	{
		$msg = $this->quoted === true ? $this->getQuotedMessage() : '';
		$buttons = array(
			'submit_reply' => $this->module->lang('btn_reply'),
			'submit_preview' => $this->module->lang('btn_preview'),
		);
		$data = array(
			'title' => array(GWF_Form::STRING, $this->getReplyTitle(), $this->module->lang('th_title')),
			'message' => array(GWF_Form::MESSAGE, $msg, $this->module->lang('th_message')),
			'smileys' => array(GWF_Form::CHECKBOX, false, $this->module->lang('th_smileys')),
			'bbcode' => array(GWF_Form::CHECKBOX, false, $this->module->lang('th_bbcode')),
//			'guest_view' => array(GWF_Form::CHECKBOX, $this->thread->isGuestView(), $this->module->lang('th_guest_view')),
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
	private function templateReply($preview=false)
	{
		$form = $this->getForm();

		$url = $_SERVER['REQUEST_URI'].'#form';
		
		$tVars = array(
			'form' => $form->templateY($this->module->lang('ft_reply'), $url),
			'preview' => $preview,
		);
		return $this->module->templatePHP('reply.php', $tVars);
	}
	
	private function templateLastPosts()
	{
		$tVars = array(
			'thread' => $this->thread,
			'posts' => $this->thread->getLastVisiblePosts(),
			'pagemenu' => '',
			'actions' => false,
			'title' => true,
			'reply' => true,
			'nav' => false,
			'can_vote' => false,
			'can_thank' => false,
			'term' => array(),
		);
		return $this->module->templatePHP('show_thread.php', $tVars);
	}
	
	###############
	### Preview ###
	###############
	private function onPreview()
	{
		$form = $this->getForm();
		$error = $form->validate($this->module);

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
			$this->templateLastPosts().
			'<a name="form"></a>'.
			$this->module->templatePHP('show_thread.php', $tVars).
			$this->templateReply(true);
	}
	
	#############
	### Reply ###
	#############
	private function onReply()
	{
		$form = $this->getForm();
		if (false !== ($error = $form->validate($this->module))) {
			return $error.$this->templateReply();
		}
		
		# Gather vars
		$user = GWF_Session::getUser();
		$is_mod = $user === false && $this->module->isGuestPostModerated();
		
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
			if (false === $post->onApprove($this->module)) {
				return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
			}
//			$this->thread->increase('thread_postcount', 1); # Increase cache :/
			
			$this->module->cachePostcount();
			
			return $this->module->message('msg_posted', array($post->getThread()->getLastPageHREF()));
		}
		else
		{
			GWF_ForumSubscription::sendModeratePost($this->module, $post);
			return $this->module->message('msg_posted_mod', array($this->thread->getLastPageHREF()));
		}
	}
	
	##################
	### Validators ###
	##################
	public function validate_title(Module_Forum $module, $arg) { return $this->module->validate_title($arg); }
	public function validate_message(Module_Forum $module, $arg) { return $this->module->validate_message($arg); }
	
}

?>
