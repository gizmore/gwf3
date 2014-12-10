<?php
/**
* modx.co.uk
* Response: Dunlin:143:8:9
* Dunlin:37:200:310:5:7:233
* Format: <username>:<rank>:<level>:<maxlevel>:<challsolve>:<maxchalls>:<userscore>
*/
class WCSite_OP extends WC_Site
{
	public function parseStats($url)
	{
		if (false === ($result = GWF_HTTP::getFromURL($url, false)))
		{
			return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($result), $this->displayName())));
		}
		
		$stats = explode(':', $result);
		if (count($stats) < 7)
		{
			return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($result), $this->displayName())));
		}
		
// 		$username = $stats[0];
		$onsiterank = intval($stats[1]);
		$onsitescore = round($stats[2]);
		$maxscore = round($stats[3]);
		$challsolved = intval($stats[4]);
		$challcount = intval($stats[5]);
		$usercount = intval($stats[6]);
		
		if ($onsiterank === 0 || $challcount === 0 || $usercount === 0)
		{
			return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($result), $this->displayName())));
		}
		
		return array($onsitescore, $onsiterank, $challsolved, $maxscore, $usercount, $challcount);
	}
}
