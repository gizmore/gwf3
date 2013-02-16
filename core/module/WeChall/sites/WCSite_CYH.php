<?php
class WCSite_CYH extends WC_Site
{
	public function parseStats($url)
	{
		if (false === ($result = GWF_HTTP::getFromURL($url, false)))
		{
			return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($result), $this->displayName())));
		}

		$stats = explode(':', $result);
		if (count($stats) != 7)
		{
			return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($result), $this->displayName())));
		}

		# username:rank:score:maxscore:challssolved:challcount:usercount
		$i = 0;
		$username = $stats[$i++];
		$onsitesrank = (int)$stats[$i++];
		$onsitescore = (int)$stats[$i++];
		$maxscore = (int)$stats[$i++];
		$challssolved = (int)$stats[$i++];
		$challcount = (int)$stats[$i++];
		$usercount = (int)$stats[$i++];
		
		if ($maxscore === 0 || $challcount === 0 || $usercount === 0)
		{
			return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($result), $this->displayName())));
		}
		
		return array($onsitescore, $onsitesrank, $challssolved, $maxscore, $usercount, $challcount);
	}
}
?>
