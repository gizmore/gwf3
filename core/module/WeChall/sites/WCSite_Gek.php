<?php
# <username>:<rank>:<points>:<max-points>:<num-of-solved-tasks>:<num-of-tasks>:<num-of-players>
class WCSite_Gek extends WC_Site
{
	public function parseStats($url)
	{
		if (false === ($result = GWF_HTTP::getFromURL($url, false))) {
			return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($result), $this->displayName())));
		}

		$stats = explode(':', $result);
		if (count($stats) !== 7) {
//			if ($result === '0') {
//				return array(0, 0);
//			}
			return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($result), $this->displayName())));
		}
		
	 	# username:rank:score:maxscore:challssolved:challcount:usercount
		$uname = $stats[0];
		$rank = intval($stats[1]);
		$onsitescore = intval($stats[2]);
		$maxscore = intval($stats[3]);
		$challssolved = intval($stats[4]);
		$challcount = intval($stats[5])/2;
		$usercount = intval($stats[6]);
		
		if ($maxscore === 0 || $challcount === 0 || $usercount === 0) {
			return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($result), $this->displayName())));
		}
		
		$this->updateSite($maxscore, $usercount, $challcount);
		
		return array($onsitescore, $rank, $challssolved);
	}
}
?>