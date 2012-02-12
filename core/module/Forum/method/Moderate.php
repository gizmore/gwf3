<?php

final class Forum_Moderate extends GWF_Method
{
//	public function getHTAccess()
//	{
//		return '';
//	}
	
	public function execute()
	{
		if (false === ($token = Common::getGet('token'))) {
			return GWF_HTML::err('ERR_GENERAL', array(__FILE__, __LINE__));
		}
		
		if (false !== ($tid = Common::getGet('yes_thread'))) {
			return $this->approveThread($tid, $token);
		}
		if (false !== ($tid = Common::getGet('no_thread'))) {
			return $this->deleteThread($tid, $token);
		}
		
		if (false !== ($pid = Common::getGet('yes_post'))) {
			return $this->approvePost($pid, $token);
		}
		if (false !== ($pid = Common::getGet('no_post'))) {
			return $this->deletePost($pid, $token);
		}
		
		return GWF_HTML::err('ERR_GENERAL', array(__FILE__, __LINE__));
	}
	
	private function approveThread($tid, $token)
	{
		if (false === ($thread = GWF_ForumThread::getThread($tid))) {
			return $this->module->error('err_thread');
		}
		
		if (false === ($board = $thread->getBoard())) {
			return $this->module->error('err_board');
		}
		
		if ($token !== $thread->getToken()) {
			return $this->module->error('err_token');
		}

		if (false === $thread->onApprove()) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		if (false === $thread->saveOption(GWF_ForumThread::IN_MODERATION, false)) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		if (false === $thread->getFirstPost()->saveOption(GWF_ForumPost::IN_MODERATION, false)) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}

		$this->module->cachePostcount();
		
		return $this->module->message('msg_thread_shown');
	}
	
	private function deleteThread($tid, $token)
	{
		if (false === ($thread = GWF_ForumThread::getThread($tid))) {
			return $this->module->error('err_thread');
		}
		if ($token !== $thread->getToken()) {
			return $this->module->error('err_token');
		}

		if (false === $thread->deleteThread()) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		return $this->module->message('msg_thread_deleted');
	}
	
	private function approvePost($pid, $token)
	{
		if (false === ($post = GWF_ForumPost::getPost($pid))) {
			return $this->module->error('err_post');
		}
		if ($token !== $post->getToken()) {
			return $this->module->error('err_token');
		}
		
		if (false === $post->onApprove($this->module)) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}

		$this->module->cachePostcount();
		
		return $this->module->message('msg_post_shown');
	}

	private function deletePost($pid, $token)
	{
		if (false === ($post = GWF_ForumPost::getPost($pid))) {
			return $this->module->error('err_post');
		}
		if ($token !== $post->getToken()) {
			return $this->module->error('err_token');
		}
		
		if (false === ($post->deletePost())) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		return $this->module->message('msg_post_deleted');
	}
}
