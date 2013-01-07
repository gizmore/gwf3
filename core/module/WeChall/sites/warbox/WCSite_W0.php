<?php
class WCSite_W0 extends WC_Site
{
	public function isWarBox() { return true; }
	
	public function parseStats($url)
	{
		if (false === ($result = GWF_HTTP::getFromURL($url, false)))
		{
			return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($result), $this->displayName())));
		}

		$stats = explode(':', $result);
		if (count($stats) < 5)
		{
			return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($result), $this->displayName())));
		}
		
		//Gizmore:warchall.net:-1:10:2
		$onsitename = $stats[0];
		$onsitertbs = $stats[1];
		$onsitescore = intval($stats[2]);
		$challcount = intval($stats[3]);
		$usercount = intval($stats[4]);
		$maxscore = $challcount;
		$challssolved = $onsitescore;
		
		$rank = -1;
		
		if ($maxscore === 0 || $challcount === 0)
		{
			return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($result), $this->displayName())));
		}
		
		$this->updateSite($maxscore, $usercount, $challcount);
		
		return array($onsitescore, $rank, $challssolved);
	}
}
?>
