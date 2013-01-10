<?php
final class Forum_IRC extends GWF_Method
{
	public function getHTAccess()
	{
		return
			'RewriteCond %{QUERY_STRING} datestamp=([^&]+)&limit=([^&]+)'.PHP_EOL.
			'RewriteRule ^nimda_forum.php$ index.php?mo=Forum&me=IRC&datestamp=%1&limit=%2&no_session=true&ajax=true'.PHP_EOL;
	}
	
	public function getPageMenuLinks()
	{
		return array(
				array(
						'page_url' => 'nimda_forum.php',
						'page_title' => 'Nimda Forum',
						'page_meta_desc' => 'Take a look at the Nimda Forum',
				),
		);
	}
	
	public function execute()
	{
		GWF_Website::plaintext();
		
		if (false === ($datestamp = Common::getGet('datestamp')))
		{
			return 'TRY ?datestamp=YYYYMMDDHHIISS&limit=5';
		}
		
		if (strlen($datestamp) !== 14)
		{
			return 'TRY ?datestamp=YYYYMMDDHHIISS&limit=5';
		}
		
		if (0 === ($limit = Common::getGetInt('limit', 0)))
		{
			return 'TRY ?datestamp=YYYYMMDDHHIISS&limit=5';
		}
		
		$date = GDO::escape($datestamp);
		
		$limit = Common::clamp($limit, 1, 25);
		
		if (false === ($result = GDO::table('GWF_ForumThread')->selectObjects('*', "thread_lastdate>='$date' AND thread_options&4=0", 'thread_lastdate DESC', $limit)))
		{
			return GWF_HTML::lang('ERR_DATABASE', __FILE__, __LINE__);
		}
		
		$back = '';
		
		$unknown = GWF_HTML::lang('unknown');
		
		foreach (array_reverse($result) as $thread)
		{
			#timestamp::lock::postid::threadid::posturl::userurl::username::title
			$thread instanceof GWF_ForumThread;
			$locked = $thread->getVar('thread_gid') === '0' ? '0' : '1';
			$back .= $thread->getVar('thread_tid');
			$back .= '::';
			$back .= $thread->getVar('thread_lastdate');
			$back .= '::';
			$back .= $thread->getVar('thread_gid');
			$back .= '::';
			$back .= 'https://'.GWF_DOMAIN.$thread->getLastPageHREF($locked==='1');
			$back .= '::';
			$back .= $locked === '1' ? $unknown : $this->getLastPosterName($thread);
			$back .= '::';
			$back .= $locked === '1' ? $unknown : $thread->getVar('thread_title');
			$back .= PHP_EOL;
		}	
		return $back;
	}
	
	private function getLastPosterName(GWF_ForumThread $thread)
	{
		$posts = GDO::table('GWF_ForumPost'); # posts table
		
		$date = $thread->getVar('thread_lastdate'); # last date
		
		# Check if a post was made at this date.
		if (false !== ($username = $posts->selectVar('user_name', "post_date='{$date}'", '', array('post_uid'))))
		{
			return $username;
		}
		
		# Check if an edit was made at this date.
		if (false !== ($username = $posts->selectVar('post_eusername', "post_edate='{$date}'")))
		{
			return $username;
		}
		
		# Should not get here (race condition) but works as a fallback. 
		return $thread->getVar('thread_lastposter');
	}
}
?>