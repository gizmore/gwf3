<?php
/**
 * Hacker.org
 * rank:score:maxscore:usercount:challcount
 */
class WCSite_IRIS extends WC_Site
{
	public function parseStats($url)
	{
		if (false === ($result = GWF_HTTP::getFromURL($url, false)))
		{
			return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($result), $this->displayName())));
		}
		$stats = explode(':', $result);
		if (count($stats) !== 6)
		{
			return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($result), $this->displayName())));
		}
		$onsitename = $stats[0];
		$onsitescore = intval($stats[1], 10);
		$maxscore = intval($stats[2], 10);
		$challsolve = intval($stats[3], 10);
		$challcount = intval($stats[4], 10);
		$usercount = intval($stats[5], 10);
		
		if ($maxscore === 0 || $challcount === 0 || $usercount === 0)
		{
			return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($result), $this->displayName())));
		}
		
		return array($onsitescore, -1, $challsolve, $maxscore, $usercount, $challcount);
	}
}
