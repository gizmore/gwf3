<?php

final class Forum_Moderate extends GWF_Method
{
//	public function getHTAccess()
//	{
//		return ''
//	}
	
	public function execute()
	{
		if (false === ($token = Common::getGet('token'))) {
			return GWF_HTML::err('ERR_GENERAL', __FILE__, __LINE__);
		}
		
		if (false !== ($tid = Common::getGet('yes_thread'))) {
			return $this->approveThread($this->_module, $tid, $token);
		}
		if (false !== ($tid = Common::getGet('no_thread'))) {
			return $this->deleteThread($this->_module, $tid, $token);
		}
		
		if (false !== ($pid = Common::getGet('yes_post'))) {
			return $this->approvePost($this->_module, $pid, $token);
		}
		if (false !== ($pid = Common::getGet('no_post'))) {
			return $this->deletePost($this->_module, $pid, $token);
		}
		
		return GWF_HTML::err('ERR_GENERAL', __FILE__, __LINE__);
	}
	
	private function approveThread(Module_Forum $module, $tid, $token)
	{
		if (false === ($thread = GWF_ForumThread::getThread($tid))) {
			return $this->_module->error('err_thread');
		}
		
		if (false === ($board = $thread->getBoard())) {
			return $this->_module->error('err_board');
		}
		
		if ($token !== $thread->getToken()) {
			return $this->_module->error('err_token');
		}

		if (false === $thread->onApprove()) {
			return GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
		}
		
		if (false === $thread->saveOption(GWF_ForumThread::IN_MODERATION, false)) {
			return GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
		}
		
		if (false === $thread->getFirstPost()->saveOption(GWF_ForumPost::IN_MODERATION, false)) {
			return GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
		}

		$this->_module->cachePostcount();
		
		return $this->_module->message('msg_thread_shown');
	}
	
	private function deleteThread(Module_Forum $module, $tid, $token)
	{
		if (false === ($thread = GWF_ForumThread::getThread($tid))) {
			return $this->_module->error('err_thread');
		}
		if ($token !== $thread->getToken()) {
			return $this->_module->error('err_token');
		}

		if (false === $thread->deleteThread()) {
			return GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
		}
		
		return $this->_module->message('msg_thread_deleted');
	}
	
	private function approvePost(Module_Forum $module, $pid, $token)
	{
		if (false === ($post = GWF_ForumPost::getPost($pid))) {
			return $this->_module->error('err_post');
		}
		if ($token !== $post->getToken()) {
			return $this->_module->error('err_token');
		}
		
		if (false === $post->onApprove($this->_module)) {
			return GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
		}

		$this->_module->cachePostcount();
		
		return $this->_module->message('msg_post_shown');
	}

	private function deletePost(Module_Forum $module, $pid, $token)
	{
		if (false === ($post = GWF_ForumPost::getPost($pid))) {
			return $this->_module->error('err_post');
		}
		if ($token !== $post->getToken()) {
			return $this->_module->error('err_token');
		}
		
		if (false === ($post->deletePost())) {
			return GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
		}
		
		return $this->_module->message('msg_post_deleted');
	}
}

?>
