<?php
class WCSite_HA extends WC_Site
{
	public function parseStats($url)
	{
		if (false === ($result = GWF_HTTP::getFromURL($url, false)))
		{
			return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($result), $this->displayName())));
		}

		$stats = explode(':', $result);
		if (count($stats) !== 4)
		{
			return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($result), $this->displayName())));
		}
		
	 	# rank:challssolved:challcount:usercount
		$rank = intval($stats[0]);
		$onsitescore = intval($stats[1]);
		$maxscore = intval($stats[2]);
		$challssolved = $onsitescore;
		$challcount = $maxscore;
		$usercount = intval($stats[3]);
		
		if ($maxscore === 0 || $challcount === 0 || $usercount === 0)
		{
			return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($result), $this->displayName())));
		}
		
		$this->updateSite($maxscore, $usercount, $challcount);
		
		return array($onsitescore, $rank, $challssolved);
	}
}
?>
