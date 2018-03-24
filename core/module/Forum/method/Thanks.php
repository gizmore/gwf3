<?php

final class Forum_Thanks extends GWF_Method
{
	public function isLoginRequired() { return true; }
	
	public function getHTAccess()
	{
		return 'RewriteRule ^forum/thanks/for/post/([0-9]+)/[^/]+$ index.php?mo=Forum&me=Thanks&pid=$1'.PHP_EOL;
	}
	
	public function execute()
	{
		return $this->onThanks();
	}
	
	private function onThanks()
	{
		if (false === ($post = $this->module->getCurrentPost())) {
			return $this->module->error('err_post');
		}
		
		if (false === $this->module->cfgThanksEnabled()) {
			return $this->module->error('err_thanks_off');
		}
		
		if (false === ($user = GWF_Session::getUser())) {
			return GWF_HTML::err('ERR_GENERAL', array(__FILE__, __LINE__));
		}
		
		if ($post->hasThanked($user)) {
			return $this->module->error('err_thank_twice');
		}
		
		if ($post->getUserID() === $user->getID()) {
			return $this->module->error('err_thank_self');
		}

		if (false === $post->onThanks($this->module, $user)) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		if ($this->module->isAjax())
		{
			return '1:'.$post->getThanksCount();
		} else
		{
			return $this->module->message('msg_thanked', $post->getShowHREF());
		}
	}
}

?>
