<?php
/**
 * Sub/-Unsubscribe from forum threads.  
 * @author gizmore
 * @version 3.0
 * @since 2.0
 */
final class Forum_Subscribe extends GWF_Method
{
	public function getHTAccess(GWF_Module $module)
	{
		$c = COMMON::TOKEN_LEN;
		return
			'RewriteRule ^forum/subscribe/to/([0-9]+)/[^/]+$ index.php?mo=Forum&me=Subscribe&tid=$1&sub=me'.PHP_EOL.
			'RewriteRule ^forum/unsubscribe/from/([0-9]+)/[^/]+$ index.php?mo=Forum&me=Subscribe&tid=$1&unsub=me'.PHP_EOL.
			'RewriteRule ^forum/unsubscribe/([0-9]+)/([0-9a-f]{'.$c.'})/from/([0-9]+)/[^/]+$ index.php?mo=Forum&me=Subscribe&uid=$1&ext_thread=$2&tid=$3'.PHP_EOL.
			'RewriteRule ^forum/unsubscribe/([0-9]+)/([0-9a-f]{'.$c.'})/from/all$ index.php?mo=Forum&me=Subscribe&uid=$1&ext_all=$2'.PHP_EOL;
	}
	
	/**
	 * @var GWF_ForumThread
	 */
	private $thread;
	
	public function execute(GWF_Module $module)
	{
		# Not sane ext_all
		if (false !== ($token = Common::getGet('ext_all'))) {
			return $this->onUnSubscribeExtAll($module, $token);
		}
		
		# Sanitize
		if (false !== ($error = $this->sanitize($module))) {
			return $error;
		}
		
		# Sane guest: ext_thread
		if (false !== ($token = Common::getGet('ext_thread'))) {
			return $this->onUnSubscribeExtThread($module, $token);
		}
		
		# Login Below here
		if (!GWF_Session::isLoggedIn()) {
			return GWF_HTML::err('ERR_LOGIN_REQUIRED');
		}
		
		# Subscribe
		if (Common::getGet('sub') !== false) {
			return $this->onSubscribe($module);
		}

		if (Common::getGet('unsub') !== false) {
			return $this->onUnSubscribe($module);
		}
		
		
	}
	
	private function sanitize(Module_Forum $module)
	{
		if (false === ($this->thread = $module->getCurrentThread())) {
			return $module->error('err_thread');
		}
		if (false === $this->thread->hasPermission(GWF_Session::getUser())) {
			return $module->error('err_thread_perm');
		}
		return false;
	}
	
	private function onSubscribe(Module_Forum $module)
	{
		$back = $this->thread->getLastPageHREF();
		
		if (!$this->thread->canSubscribe()) {
			return $module->error('err_no_subscr', array($back));
		}
		
		if (false === GWF_ForumSubscription::subscribe(GWF_Session::getUserID(), $this->thread->getID())) {
			return $module->error('err_subscr', array($back));
		}
		
		return $module->message('msg_subscribed', array($back));
	}

	private function onUnSubscribe(Module_Forum $module)
	{
		$back = $this->thread->getLastPageHREF();
		
		if (!$this->thread->canUnSubscribe()) {
			return $module->error('err_no_unsubscr', array($back));
		}
		
		if (false === GWF_ForumSubscription::unsubscribe(GWF_Session::getUserID(), $this->thread->getID())) {
			return $module->error('err_unsubscr', array($back));
		}
		
		return $module->message('msg_unsubscribed', array($back));
	}
	
	################
	### External ###
	################
	/**
	 * @var GWF_User
	 */
	private $user;
	/**
	 * @var GWF_ForumOptions
	 */
	private $options;

	/**
	 * Validate external token.
	 * @param string $token
	 * @return boolean
	 */
	private function checkExternalToken($token)
	{
		if (false === ($this->user = GWF_User::getByID(Common::getGet('uid')))) {
			return false;
		}
		if (false === ($options = GWF_ForumOptions::getUserOptions($this->user))) {
			return false;
		}
		if ($token !== $options->getToken()) {
			return false;
		}
		return true;
	}
	
	/**
	 * Unsubscribe from all threads.
	 * @param Module_Forum $module
	 * @param string $token
	 * @return html
	 */
	private function onUnSubscribeExtAll(Module_Forum $module, $token)
	{
		if (false === ($this->checkExternalToken($token))) {
			return $module->error('err_token');
		}
		
		if (false === GWF_ForumSubscription::unsubscribeAll($this->user->getID())) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		if (false === $this->options->saveSubscription(GWF_ForumOptions::SUBSCRIBE_NONE)) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		return $module->message('msg_unsub_all', array(GWF_WEB_ROOT.'forum'));
	}
	
	private function onUnSubscribeExtThread(Module_Forum $module, $token)
	{
		if (false === ($this->checkExternalToken($token))) {
			return $module->error('err_token');
		}
		
		if (!GWF_ForumSubscription::hasSubscribedManually($this->user, $this->thread->getID())) {
			return $module->error('err_sub_by_global');
		}
		
		if (false === GWF_ForumSubscription::unsubscribe($this->user->getID(), $this->thread->getID())) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		return $module->message('msg_unsubscribed', array($this->thread->getLastPageHREF()));
	}
}
?>