<?php
/**
 * Forum Cronjobs will send new posts by email.
 * @author gizmore
 */
final class GWF_ForumCronjob extends GWF_Cronjob
{
	public static function onCronjob(Module_Forum $module)
	{
		GWF_ForumBoard::init(false, true);
		self::start('Forum');
//		self::autoModeration($module);
		self::emailSubscription($module);
		self::end('Forum');
	}
	
	#######################
	### Auto Moderation ###
	#######################
//	private static function autoModeration(Module_Forum $module)
//	{
//		if (0 < ($cut = $module->getModerationTime()))
//		{
//			$cut = time() - $cut;
//			$cut = time();
//			self::log('Start auto moderating for threads older than '.GWF_Time::displayTimestamp($cut));
//			$cut = GWF_Time::getDate(GWF_Date::LEN_SECOND, $cut);
//			self::autoPublishThreads($module, $cut);
//			self::autoPublishPosts($module, $cut);
//		}
//	}
//	
//	private static function autoPublishThreads(Module_Forum $module, $cut)
//	{
//		self::log('Publishing Threads that are in the Moderation queue for too long.');
//		
//		$threads = new GWF_ForumThread(false);
//		$in_mod = GWF_ForumThread::IN_MODERATION;
//		if (false === ($threads = $threads->select("thread_options&$in_mod AND thread_firstdate<'$cut'"))) {
//			self::error(GWF_HTML::lang('ERR_DATABASE', __FILE__, __LINE__));
//			return false;
//		}
//		
//		if (count($threads) > 0)
//		{
//			$fails = $wins = 0;
//			foreach ($threads as $thread)
//			{
//				$thread instanceof GWF_ForumThread;
//				if (false === $thread->onApprove()) {
//					self::error('Can not publish thread.');
//					$fails++;
//				} else {
//					$wins++;
//				}
//			}
//			self::log(sprintf('Published %d threads. %d failed. %d success.', $fails+$wins, $fails, $wins));
//		}
//	}
//
//	private static function autoPublishPosts(Module_Forum $module, $cut)
//	{
//		self::log('Publishing Posts that are in the Moderation queue for too long.');
//		$posts = new GWF_ForumPost(false);
//		$in_mod = GWF_ForumPost::IN_MODERATION;
//		if (false === ($posts = $posts->select("post_options&$in_mod AND post_date<'$cut'"))) {
//			self::error(GWF_HTML::lang('ERR_DATABASE', __FILE__, __LINE__));
//			return false;
//		}
//		if(count($posts) > 0)
//		{ 
//			$fails = $wins = 0;
//			foreach ($posts as $post)
//			{
//				$post instanceof GWF_ForumPost;
//				if (false === $post->onApprove($module)) {
//					self::error('Can not publish post.');
//					$fails++;
//				} else {
//					$wins++;
//				}
//			}
//			self::log(sprintf('Published %d posts. %d failed. %d success.', $fails+$wins, $fails, $wins));
//		}
//		
//	}
	
	###########################
	### Email Subscriptions ###
	###########################
	private static function emailSubscription(Module_Forum $module)
	{
		self::log('Sending Forum EMail Subscriptions');
		
		$posts = new GWF_ForumPost(false);
		$mail = GWF_ForumPost::MAIL_OUT;
		$moderated = GWF_ForumPost::IN_MODERATION;
		if (false === ($posts = $posts->selectObjects('*', "post_options&$mail AND (post_options&$moderated=0)"))) {
			return self::error(GWF_HTML::lang('ERR_DATABASE', __FILE__, __LINE__));
		}
		
		if (0 < ($amount = count($posts))) {
			self::log(sprintf('Found %d new posts...', count($posts)));
			return self::emailSubscriptionB($module, $posts);
		}
		
		return true;
	}
	
	private static function emailSubscriptionB(Module_Forum $module, array $posts)
	{
		$threaded = self::getThreaded($module, $posts);
		self::log(sprintf('In %d different threads...', count($threaded)));
		foreach ($threaded as $tid => $data)
		{
			list($thread, $msg_block, $msg_count) = $data;
			GWF_ForumSubscription::sendSubscription($module, $thread, $msg_block, $msg_count);
		}
	}
	
	private static function getThreaded(Module_Forum $module, array $posts)
	{
		$back = array();
		foreach ($posts as $post)
		{
			$post instanceof GWF_ForumPost;
			
			$tid = $post->getThreadID();
			
			if (!(isset($back[$tid])))
			{
				if (false === ($t = $post->getThread()))
				{
					self::log('A post could not find it\'s thread!!');
					continue; // OOps!!!
				}
				$back[$tid] = array($t, '', 0);
			}
			
			$back[$tid][1] .=
				'FROM: '.$post->getPosterName().PHP_EOL.
				'TITLE: '.$post->displayTitle().PHP_EOL.
				PHP_EOL.
				$post->displayMessage().PHP_EOL.PHP_EOL;
				
			$back[$tid][2]++;
			
			$post->saveOption(GWF_ForumPost::MAIL_OUT, false);
		}
		return $back;
	}
	
	
	
}

?>