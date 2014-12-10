<?php
/**
* modx.co.uk
* Response: Dunlin:143:8:9
* Format: <username>:<rank>:<level>:<maxlevel>
*/
class WCSite_DAN extends WC_Site
{
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
		
		$onsiterank = intval($stats[1]);
		$onsitescore = intval($stats[2]);
		$maxscore = intval($stats[3]);
		$challcount = $maxscore;
		$usercount = intval($stats[4]);
		
		if ($onsiterank === 0 || $challcount === 0 || $usercount === 0)
		{
			return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($result), $this->displayName())));
		}
		
		return array($onsitescore, $onsiterank, $onsitescore, $maxscore, $usercount, $challcount);
	}
}
