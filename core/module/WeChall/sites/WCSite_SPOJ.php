<?php
/**
 * rank:userscore:maxscore:usercount:challcount
 * Gizmore:13705:0:1090:92143:1955
 * username:rank:score:maxscore:usercount:challcount
 */
class WCSite_SPOJ extends WC_Site
{
	public function parseStats($result)
	{
		$stats = explode(':', $result);
		if (count($stats) !== 6) {
			return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($result), $this->displayName())));
		}

		$username = $stats[0];
		
		
		$rank = intval($stats[1]);
		$onsitescore = intval($stats[2]);
		$maxscore = intval($stats[3]);
		$usercount = intval($stats[4]);
		$challcount = intval($stats[5]);
		
		if ($maxscore === 0 || $challcount === 0 || $usercount === 0) {
			return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($result), $this->displayName())));
		}
		
		return array($onsitescore, $rank, -1, $maxscore, $usercount, $challcount);
	}
}
?>
