<?php
/**
 * Polnish Hacker Master (PHM)
 * username:rank:score:maxscore:challssolved:challcount:usercount
 */
class WCSite_PHM extends WC_Site
{
	public function parseStats($url)
	{
		if (false === ($result = GWF_HTTP::getFromURL($url, false)))
		{
			return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($result), $this->displayName())));
		}

		$result = str_replace("\xEF\xBB\xBF", '', $result); # BOM
		$result = trim($result);
		
		$stats = explode(":", $result);
		if (count($stats) !== 7)
		{
			return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($result), $this->displayName())));
		}

		$i = 0;
		$username = $stats[$i++];
		$rank = intval($stats[$i++]);
		$onsitescore = intval($stats[$i++]);
		$onsitescore = Common::clamp($onsitescore, 0);
		$maxscore = intval($stats[$i++]);
		$challssolved = intval($stats[$i++]);
		$challcount = intval($stats[$i++]);
		$usercount = intval($stats[$i++]);
		
		if ($maxscore === 0 || $challcount === 0 || $usercount === 0)
		{
			return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($result), $this->displayName())));
		}
		
		return array($onsitescore, $rank, $challssolved, $maxscore, $usercount, $challcount);
	}
	
}
?>