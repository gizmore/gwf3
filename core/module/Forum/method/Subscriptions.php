<?php
final class Forum_Subscriptions extends GWF_Method
{
	public function isLoginRequired() { return true; }
	
	public function execute()
	{
		return $this->templateSubscription();
	}
	
	public function getPageMenuLinks()
	{
		return array(
				array(
						'page_url' => 'index.php?mo=Forum&me=Subscriptions',
						'page_title' => 'Subscriptions',
						'page_meta_desc' => 'Browse your subscriptions',
				),
		);
	}
	
	private function templateSubscription()
	{
		$tsub = GDO::table('GWF_ForumSubscription');
		$bsub = GDO::table('GWF_ForumSubscrBoard');
		$fopt = GWF_ForumOptions::getUserOptionsS();
		
		$tVars = array(
			'subscr_intro' => $this->getIntro($fopt),
			'subscr_intro_boards' => $this->getIntroBoards($bsub),
			'subscr_intro_threads' => $this->getIntroThreads($tsub),
			'subscr_threads' => $this->getSubscrThreads($tsub),
			'subscr_boards' => $this->getSubscrBoards($bsub),
		);
		return $this->module->template('subscriptions.tpl', $tVars);
	}
	
	private function getIntro(GWF_ForumOptions $fopt)
	{
		$mode = $fopt->getVar('fopt_subscr');
		$modetxt = $this->module->lang('submode_'.$mode);
		return $this->module->lang('submode', array($modetxt));
	}

	private function getIntroBoards(GWF_ForumSubscrBoard $bsub)
	{
		$uid = GWF_Session::getUserID();
		$count = $bsub->countRows("subscr_uid={$uid}");
		return $this->module->lang('subscr_boards', array($count));
	}

	private function getIntroThreads(GWF_ForumSubscription $tsub)
	{
		$uid = GWF_Session::getUserID();
		$count = $tsub->countRows("subscr_uid={$uid}");
		return $this->module->lang('subscr_threads', array($count));
	}

	private function getSubscrThreads(GWF_ForumSubscription $tsub)
	{
		$root = GWF_WEB_ROOT;
		$uid = GWF_Session::getUserID();
		$back = array();
		if (false === ($result = $tsub->select('thread_tid, thread_title', "subscr_uid={$uid}", 'thread_firstdate ASC', array('threads'))))
		{
			return $back;
		}
		while (false !== ($row = $tsub->fetch($result, GDO::ARRAY_N)))
		{
			$back[] = array(
				'thread_tid' => $row[0],
				'thread_title' => $row[1],
				'thread_url' => sprintf('%sforum-t/%s/%s.html', GWF_WEB_ROOT, $row[0], Common::urlencodeSEO($row[1])),
				'href_unsub' => sprintf('%sforum/unsubscribe/from/%s/%s', GWF_WEB_ROOT, $row[0], Common::urlencodeSEO($row[1])),
			);
		}
		return $back;
	}
	
	private function getSubscrBoards(GWF_ForumSubscrBoard $bsub)
	{
		$root = GWF_WEB_ROOT;
		$uid = GWF_Session::getUserID();
		return $bsub->selectAll("board_bid, board_title, CONCAT('{$root}forum-b', board_bid, '/', board_title, '.html') as board_url, CONCAT('{$root}index.php?mo=Forum&me=SubscribeBoard&unsubscribe=', board_bid) as href_unsub", "subscr_uid={$uid}", 'board_pos ASC', array('boards'));
	}
}
?>