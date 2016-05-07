<?php
abstract class WC_SiteBase extends GDO
{
	/**
	 * Scoreurl for warbox.wechall.net
	 * @see WC_Site::getScoreURL()
	 */
// 	public function getWarboxScoreURL($onsitename)
// 	{
// 		$host = Module_WeChall::instance()->cfgWarboxURL();
// 		return sprintf('%s/cgi/warscore.score.cgi?username=%s&site=%s', $host, $onsitename, $this->getSiteClassName());
// 	}
	
// 	public function getWarboxScoreURLMulti($onsitename)
// 	{
// 		$host = Module_WeChall::instance()->cfgWarboxURL();
// 		return sprintf('%s/cgi/warscore.cgi?username=%s&site=%s', $host, $onsitename, $this->getSiteClassName());
// 	}
	
	/**
	 * Link URL. No emails submitted.
	 * @see WC_Site::getAccountURL()
	 */
// 	public function getWarboxAccountURL($onsitename, $onsitemail)
// 	{
// 		$host = Module_WeChall::instance()->cfgWarboxURL();
// 		return sprintf('%s/cgi/warscore.link.cgi?site=%s', $host, $this->getSiteClassName());
// 	}
	
// 	public function parseMultiStats(GWF_User $user, &$stats)
// 	{
// 		$onsitename = $user->getVar('user_name');
// 		$url = $this->getWarboxScoreURLMulti($onsitename);
		
// // 		var_dump($url);
		
// 		if (false === ($page = GWF_HTTP::getFromURL($url, false)))
// 		{
// 			return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($result), $this->displayName())));
// 		}
		
// 		$page = preg_split('/(?:\r?\n)+/', $page);
// // 		$page = array_slice($page, 2);
// // 		var_dump($page);
// 		foreach ($page as $row)
// 		{
// 			$result = str_getcsv($row);
// 			if (count($result) === 7)
// 			{
// 				$i = 0;
// 				//$username = $result[$i++];
// 				$wbid = $result[$i++];
				
// 				if (false !== ($box = WC_Warbox::getByID($wbid)))
// 				{
// 					$box instanceof WC_Warbox;
					
// 					$score = $result[$i++];
// 					$rank = $result[$i++];
// 					$challssolved = $result[$i++];
// 					$maxscore = $result[$i++];
// 					$usercount = $result[$i++];
// 					$challcount = $result[$i++];
					
// 					$box->saveVars(array(
// 						'wb_levels' => $challcount,
// 					));
					
// 					// Add stats to reference array
// 					// score, rank, challssolved, maxscore, usercount, challcount
// 					// Score
// 					$stats[0] += $score;
// 					// Rank
// 					//		 		$stats[1]
// 					// Challs solved
// 					if ($stats[2] > -1)
// 					{
// 						$stats[2] += $score;
// 					}
					
// 					// The other 3 fields
// 					if ($stats[3] >= 0) $stats[3] += $maxscore;
// 					if ($stats[4] >= 0) $stats[4] += $usercount;
// 					if ($stats[5] >= 0) $stats[5] += $challcount;
// 				}
				
// 			}
// 		}
// 	}
	
	/**
	 * Default parser.
	 * @TODO: Check with join_us specs.
	 * @param string $url
	 */
	public function parseStats($url)
	{
		if (false === ($result = GWF_HTTP::getFromURL($url, false)))
		{
			return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($result), $this->displayName())));
		}
	
		$stats = explode(':', trim($result));
		if (count($stats) !== 7)
		{
			return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($result), $this->displayName())));
		}
	
		$i = 0;
		$username = $stats[$i++];
		$rank = (int) $stats[$i++];
		$score = (int) $stats[$i++];
		$maxscore = (int) $stats[$i++];
		$challssolved = (int) $stats[$i++];
		$challcount = (int) $stats[$i++];
		$usercount = (int) $stats[$i++];
	
		if ($maxscore === 0 || $challcount === 0)
		{
			return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($result), $this->displayName())));
		}
	
// 		$this->updateSite($maxscore, $usercount, $challcount);
	
		return array($score, $rank, $challssolved, $maxscore, $usercount, $challcount);
	}
}
