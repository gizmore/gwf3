<?php
/**
 * Table of manually subribed threads.
 * @author gizmore
 */
final class GWF_ForumSubscription extends GDO
{
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'forumsubscr'; }
	
	public function getColumnDefines()
	{
		return array(
			'subscr_uid' => array(GDO::UINT|GDO::PRIMARY_KEY, true),
			'subscr_tid' => array(GDO::UINT|GDO::PRIMARY_KEY, true),
			'subscr_fopts' => array(GDO::OBJECT, GDO::NULL, array('GWF_ForumOptions', 'subscr_uid', 'fopt_uid')),
		
			'threads' => array(GDO::JOIN, GDO::NULL, array('GWF_ForumThread', 'subscr_tid', 'thread_tid')),
		);
	}
	
	####################
	### Un/Subscribe ###
	####################
	public static function subscribe($userid, $threadid)
	{
		$sub = new self(array(
			'subscr_uid' => $userid,
			'subscr_tid' => $threadid,
		));
		return $sub->replace();
	}
	
	public static function unsubscribe($userid, $threadid)
	{
		$userid = (int) $userid;
		$threadid = (int) $threadid;
		$table = new self(false);
		return $table->deleteWhere("subscr_uid=$userid AND subscr_tid=$threadid");
	}
	
	public static function unsubscribeAll($userid)
	{
		$userid = (int) $userid;
		$table = new self(false);
		return $table->deleteWhere("subscr_uid=$userid");
	}
	
	##############################
	### Has Subscribed Manuall ###
	##############################
	public static function hasSubscribedManually(GWF_User $user, $threadid)
	{
		$userid = $user->getID();
		$threadid = (int) $threadid;
		$table = new self(false);
		return $table->selectFirst('1', "subscr_uid=$userid AND subscr_tid=$threadid") !== false;
	}
	
	##########################################
	### Get All subscriptions for a thread ###
	##########################################
	/**
	 * Get All subscribers for a thread.
	 * This is a costy operation and should only get called on sending emails.
	 * @param GWF_ForumThread $thread
	 * @return array((string)'userid' => GWF_User, ...) 
	 */
	public static function getSubscriptions(GWF_ForumThread $thread, $show_hidden=true)
	{
		return 
			self::filterSubscriptions($thread, array_merge(
				self::getSubscriptionsManual($thread, $show_hidden),
				self::getSubscriptionsManualBoard($thread, $show_hidden),
				self::getSubscriptionsOwn($thread, $show_hidden),
				self::getSubscriptionsAll($thread, $show_hidden)
			));
	}
	
	private static function filterSubscriptions(GWF_ForumThread $thread, array $users)
	{
		foreach ($users as $uid => $user)
		{
			if (!$user->hasValidMail())
			{
				unset($users[$uid]);
			}
		}
		
		if (0 < ($gid = $thread->getGroupID()))
		{
			foreach ($users as $uid => $user)
			{
				if (!$user->isInGroupID($gid))
				{
					unset($users[$uid]);
				}
			}
		}
		
		return array_values($users);
	}
		
	private static function getSubscrConverted(array $rows)
	{
		$back = array();
		foreach ($rows as $uid)
		{
			if (false !== ($user = GWF_User::getByID($uid)) && !$user->isDeleted())
			{
				$back["S_$uid"] = $user;
			}
		}
		return $back;
	}
	
	private static function getSubscriptionsManual(GWF_ForumThread $thread, $show_hidden)
	{
		$table = self::table(__CLASS__);
		$tid = $thread->getID();
		$hidden_query = self::getHiddenQuery($show_hidden);
		if (false === ($rows = $table->selectColumn('subscr_uid', "subscr_tid=$tid AND ($hidden_query)", '', array('subscr_fopts'))))
		{
			return array();
		}
		return self::getSubscrConverted($rows);
	}
	
	private static function getSubscriptionsManualBoard(GWF_ForumThread $thread, $show_hidden)
	{
		$back = array();
		$table = GDO::table('GWF_ForumSubscrBoard');
		$curr = $thread->getBoard();
		while ($curr !== false)
		{
			$bid = $curr->getID();
			$back2 = $table->selectColumn('subscr_uid', "subscr_bid={$bid}");
			$back = array_merge($back, $back2);
			$curr = $curr->getParent();
		}
		return self::getSubscrConverted($back);
	}
	
	private static function getSubscriptionsOwn(GWF_ForumThread $thread, $show_hidden)
	{
		$table = new GWF_ForumPost(false);
		$tid = $thread->getID();
		$own = GWF_ForumOptions::SUBSCRIBE_OWN;
		$hidden_query = self::getHiddenQuery($show_hidden);
		if (false === ($rows = $table->selectColumn('post_uid', "post_tid=$tid AND fopt_subscr='$own' AND ($hidden_query)", '', array('post_useropts'))))
		{
			return array();
		}
		return self::getSubscrConverted($rows);
	}
	
	private static function getSubscriptionsAll(GWF_ForumThread $thread, $show_hidden)
	{
		$hidden_query = self::getHiddenQuery($show_hidden);
		$table = new GWF_ForumOptions(false);
		$all = GWF_ForumOptions::SUBSCRIBE_ALL;
		if (false === ($rows = $table->selectColumn('fopt_uid', "fopt_subscr='$all' AND ($hidden_query)")))
		{
			return array();
		}
		return self::getSubscrConverted($rows);
	}
	
	private static function getHiddenQuery($show_hidden)
	{
		if ($show_hidden === true)
		{
			return '1';
		}
		$bit = GWF_ForumOptions::HIDE_SUBSCR;
		return "fopt_options&$bit=0";
	}
	
	##############
	### Emails ###
	##############
	private static function getBoardTreeText(GWF_ForumBoard $board)
	{
		$tree = $board->getBoardTree();
		$back = '';
		foreach ($tree as $b)
		{
			list($reserved, $bid, $title) = $b;
			$back .= sprintf('->%s', GWF_HTML::display($title));
		}
		return substr($back, 2);
	}
	
	public static function sendModerateThread(Module_Forum $module, GWF_ForumThread $thread, $message)
	{
		$boardtxt = self::getBoardTreeText($thread->getBoard());
		$threadtxt = $thread->display('thread_title');
		$usertxt = $thread->display('thread_lastposter');
		$title = $threadtxt;
		$tid = $thread->getID();
		$token = $thread->getToken();
		$addtxt = Common::getAbsoluteURL('index.php?mo=Forum&me=Moderate&yes_thread='.$tid.'&token='.$token);
		$remtxt = Common::getAbsoluteURL('index.php?mo=Forum&me=Moderate&no_thread='.$tid.'&token='.$token);

		return self::sendModMail($module, $boardtxt, $threadtxt, $usertxt, $title, $message, $addtxt, $remtxt);
	}
	
	public static function sendModeratePost(Module_Forum $module, GWF_ForumPost $post)
	{
		$thread = $post->getThread();
		$boardtxt = self::getBoardTreeText($thread->getBoard());
		$threadtxt = $thread->display('thread_title');
		$usertxt = GWF_User::getStaticOrGuest()->display('user_name');
		$title = $post->displayTitle();
		$message = $post->displayMessage(array(), true);
		$pid = $post->getID();
		$token = $post->getToken();
		$addtxt = Common::getAbsoluteURL('index.php?mo=Forum&me=Moderate&yes_post='.$pid.'&token='.$token);
		$remtxt = Common::getAbsoluteURL('index.php?mo=Forum&me=Moderate&no_post='.$pid.'&token='.$token);
		
		return self::sendModMail($module, $boardtxt, $threadtxt, $usertxt, $title, $message, $addtxt, $remtxt);
	}

	private static function sendModMail(Module_Forum $module, $boardtxt, $threadtxt, $usertxt, $title, $message, $addtxt, $remtxt)
	{
		if ($usertxt === '')
		{
			$usertxt = GWF_HTML::lang('guest');
		}
		
		$addtxt = GWF_HTML::anchor($addtxt, $addtxt);
		$remtxt = GWF_HTML::anchor($remtxt, $remtxt);
//		$showtime = GWF_Time::humanDuration($module->getModerationTime());
		$showtime = GWF_HTML::langAdmin('never');
		
		if (false === ($admin_ids = GDO::table('GWF_UserGroup')->selectColumn('ug_userid', "group_name='admin'", '', array('group'))))
		{
			return false;
		}
		
		foreach ($admin_ids as $userid)
		{
			if (false === ($admin = GWF_User::getByID($userid)))
			{
				continue;
			}
			
			if ('' === ($rec = $admin->getValidMail()))
			{
				continue;
			}

			$mail = new GWF_Mail();
			$mail->setSender($module->getModerationSender());
			$mail->setReceiver($rec);
			$mail->setSubject($module->langUser($admin, 'modmail_subj'));
			$mail->setBody($module->langUser($admin, 'modmail_body', array($boardtxt, $threadtxt, $usertxt, $title, $message, $remtxt, $addtxt, $showtime)));
			$mail->sendToUser($admin);
		}
		return true;
	}
	
	#########################
	### Subscription Mail ###
	#########################
	public static function sendSubscription(Module_Forum $module, GWF_ForumThread $thread, $posts)
	{
		$users = self::getSubscriptions($thread);
		
		$boardText = self::getBoardTreeText($thread->getBoard());
		$threadTitle = $thread->display('thread_title');
		$sender = GWF_BOT_EMAIL;
		$last_poster = '';
		$msg_block = '';

		foreach ($posts as $post)
		{
			$post instanceof GWF_ForumPost;
			$last_poster = $post->getPosterName();
			$msg_block .=
				'FROM: '.$post->getPosterName().PHP_EOL.
				'TITLE: '.$post->displayTitle().PHP_EOL.
				PHP_EOL.
				$post->displayMessage().PHP_EOL.PHP_EOL;
		}
		
		foreach ($users as $user)
		{
			self::sendSubscriptionB($module, $thread, $user, $last_poster, $msg_block, count($posts), $boardText, $threadTitle, $sender);
			usleep($module->cfgMailMicrosleep());
		}
	}
	
	private static function sendSubscriptionB(Module_Forum $module, GWF_ForumThread $thread, GWF_User $user, $postername, $msg_block, $msg_count, $boardText, $threadTitle, $sender)
	{
		$userid = $user->getID();
		$username = $user->displayUsername();
		
		if (false === ($receiver = $user->getValidMail()))
		{
			GWF_Log::logCron('[ERROR] User '.$username.' has no valid email.');
			return false;
		}
			
		if (false === ($options = GWF_ForumOptions::getUserOptions($user)))
		{
			GWF_Log::logCron('[ERROR] User '.$username.' has no valid forum options.');
		}
		
		$token = $options->getVar('fopt_token');
		
		$href = Common::getAbsoluteURL($thread->getLastPageHREF(false), false);
		$showLink = GWF_HTML::anchor($href, $href);
		
		$href = Common::getAbsoluteURL($thread->getExternalUnSubscribeHREF($userid, $token, true), false);
		$unsubLink = GWF_HTML::anchor($href, $href);

		$href = Common::getAbsoluteURL($thread->getExternalUnSubscribeAllHREF($userid, $token, true), false);
		$unsubLinkAll = GWF_HTML::anchor($href, $href);

		$mail = new GWF_Mail();
		$mail->setSender($sender);
		$mail->setReceiver($receiver);
		$mail->setSubject($module->langUser($user, 'submail_subj', array($threadTitle, $postername, $boardText)));
		$mail->setBody($module->langUser($user, 'submail_body', array($username, $msg_count, $boardText, $threadTitle, $msg_block, $showLink, $unsubLink, $unsubLinkAll)));
		
		if (false === $mail->sendToUser($user))
		{
			GWF_Log::logCron('[ERROR] Can not send mail to '.$username.'; EMail: '.$receiver);
		}
		else
		{
			GWF_Log::logCron('[+] Successfully sent Email to '.$username.'; EMail: '.$receiver);
		}
	}
}
?>
