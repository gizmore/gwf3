<?php

final class Forum_Moderate extends GWF_Method
{
//	public function getHTAccess(GWF_Module $module)
//	{
//		return ''
//	}
	
	public function execute(GWF_Module $module)
	{
		if (false === ($token = Common::getGet('token'))) {
			return GWF_HTML::err('ERR_GENERAL', __FILE__, __LINE__);
		}
		
		if (false !== ($tid = Common::getGet('yes_thread'))) {
			return $this->approveThread($module, $tid, $token);
		}
		if (false !== ($tid = Common::getGet('no_thread'))) {
			return $this->deleteThread($module, $tid, $token);
		}
		
		if (false !== ($pid = Common::getGet('yes_post'))) {
			return $this->approvePost($module, $pid, $token);
		}
		if (false !== ($pid = Common::getGet('no_post'))) {
			return $this->deletePost($module, $pid, $token);
		}
		
		return GWF_HTML::err('ERR_GENERAL', __FILE__, __LINE__);
	}
	
	private function approveThread(Module_Forum $module, $tid, $token)
	{
		if (false === ($thread = GWF_ForumThread::getThread($tid))) {
			return $module->error('err_thread');
		}
		
		if (false === ($board = $thread->getBoard())) {
			return $module->error('err_board');
		}
		
		if ($token !== $thread->getToken()) {
			return $module->error('err_token');
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

		$module->cachePostcount();
		
		return $module->message('msg_thread_shown');
	}
	
	private function deleteThread(Module_Forum $module, $tid, $token)
	{
		if (false === ($thread = GWF_ForumThread::getThread($tid))) {
			return $module->error('err_thread');
		}
		if ($token !== $thread->getToken()) {
			return $module->error('err_token');
		}

		if (false === $thread->deleteThread()) {
			return GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
		}
		
		return $module->message('msg_thread_deleted');
	}
	
	private function approvePost(Module_Forum $module, $pid, $token)
	{
		if (false === ($post = GWF_ForumPost::getPost($pid))) {
			return $module->error('err_post');
		}
		if ($token !== $post->getToken()) {
			return $module->error('err_token');
		}
		
		if (false === $post->onApprove($module)) {
			return GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
		}

		$module->cachePostcount();
		
		return $module->message('msg_post_shown');
	}

	private function deletePost(Module_Forum $module, $pid, $token)
	{
		if (false === ($post = GWF_ForumPost::getPost($pid))) {
			return $module->error('err_post');
		}
		if ($token !== $post->getToken()) {
			return $module->error('err_token');
		}
		
		if (false === ($post->deletePost())) {
			return GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
		}
		
		return $module->message('msg_post_deleted');
	}
}

?>
