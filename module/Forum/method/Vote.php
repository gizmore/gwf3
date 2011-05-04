<?php

final class Forum_Vote extends GWF_Method
{
	public function isLoginRequired() { return true; }
	
	public function getHTAccess(GWF_Module $module)
	{
		return 'RewriteRule ^forum/vote/(up|down)/post/([0-9]+)/? index.php?mo=Forum&me=Vote&dir=$1&pid=$2'.PHP_EOL;
		
	}
	
	public function execute(GWF_Module $module)
	{
		if (false === ($post = $module->getCurrentPost())) {
			return $module->error('err_post');
		}
		
		switch(Common::getGet('dir'))
		{
			case 'up': return $this->onVote($module, $post, 1);
			case 'down': return $this->onVote($module, $post, 0);
			default: return GWF_HTML::err('ERR_PARAMETER', __FILE__, __LINE__, '$_GET[dir]');
		}
	}
	
	private function onVote(Module_Forum $module, GWF_ForumPost $post, $up=1)
	{
		if (!$module->cfgVotesEnabled()) {
			return $module->error('err_votes_off');
		}
		
		$userid = GWF_Session::getUserID();

		if ($userid === $post->getUserID()) {
			return $module->error('err_vote_self');
		}
		
		if ($up === 1) {
			$post->onVoteUp($userid);
		} else {
			$post->onVoteDown($userid);
		}
		return '1:'.$post->getVar('post_votes_up').':'.$post->getVar('post_votes_down');
//		return $module->message('msg_voted');
	}
}

?>