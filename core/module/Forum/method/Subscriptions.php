<?php
final class Forum_Subscriptions extends GWF_Method
{
	public function isLoginRequired() { return true; }
	
	public function execute(GWF_Module $module)
	{
		return $this->templateSubscription($module);
	}
	
	private function templateSubscription(Module_Forum $module)
	{
		$tsub = GDO::table('GWF_ForumSubscription');
		$bsub = GDO::table('GWF_ForumSubscrBoard');
		$fopt = GWF_ForumOptions::getUserOptionsS();
		
		$tVars = array(
			'subscr_intro' => $this->getIntro($module, $fopt),
			'subscr_intro_boards' => $this->getIntroBoards($module, $bsub),
			'subscr_intro_threads' => $this->getIntroThreads($module, $tsub),
			'subscr_threads' => $this->getSubscrThreads($module, $tsub),
			'subscr_boards' => $this->getSubscrBoards($module, $bsub),
		);
		return $module->template('subscriptions.tpl', $tVars);
	}
	
	private function getIntro(Module_Forum $module, GWF_ForumOptions $fopt)
	{
		$mode = $fopt->getVar('fopt_subscr');
		$modetxt = $module->lang('submode_'.$mode);
		return $module->lang('submode', array($modetxt));
	}

	private function getIntroBoards(Module_Forum $module, GWF_ForumSubscrBoard $bsub)
	{
		$uid = GWF_Session::getUserID();
		$count = $bsub->countRows("subscr_uid={$uid}");
		return $module->lang('subscr_boards', array($count));
	}

	private function getIntroThreads(Module_Forum $module, GWF_ForumSubscription $tsub)
	{
		$uid = GWF_Session::getUserID();
		$count = $tsub->countRows("subscr_uid={$uid}");
		return $module->lang('subscr_threads', array($count));
	}

	private function getSubscrThreads(Module_Forum $module, GWF_ForumSubscription $tsub)
	{
		$root = GWF_WEB_ROOT;
		$uid = GWF_Session::getUserID();
		return $tsub->selectAll("thread_tid, thread_title, CONCAT('{$root}forum-t', thread_tid, '/', thread_title, '.html') as thread_url, CONCAT('{$root}forum/unsubscribe/from/', thread_tid, '/', thread_title) as href_unsub", "subscr_uid={$uid}", 'thread_firstdate ASC', array('threads'));
	}
	
	private function getSubscrBoards(Module_Forum $module, GWF_ForumSubscrBoard $bsub)
	{
		$root = GWF_WEB_ROOT;
		$uid = GWF_Session::getUserID();
		return $bsub->selectAll("board_bid, board_title, CONCAT('{$root}forum-b', board_bid, '/', board_title, '.html') as board_url, CONCAT('{$root}index.php?mo=Forum&me=SubscribeBoard&unsubscribe=', board_bid) as href_unsub", "subscr_uid={$uid}", 'board_pos ASC', array('boards'));
	}
}
?>