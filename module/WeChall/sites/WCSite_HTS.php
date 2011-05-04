<?php
/**
 * Hack This Site
 */
final class WCSite_HTS extends WC_Site
{
	public function parseStats($url)
	{
		if (false === ($result = GWF_HTTP::getFromURL($url, false))) {
			return htmlDisplayError(WC_HTML::lang('err_response', GWF_HTML::display($result), $this->displayName()));
		}
		$stats = explode(":", $result);
		if (count($stats) !== 4) {
			return htmlDisplayError(WC_HTML::lang('err_response', GWF_HTML::display($result), $this->displayName()));
		}
		
		$onsitescore = intval($stats[2]);
		$score = intval($stats[1]);
		$rankname = $stats[0]; 
		$usercount = 39500;
		$challcount = 102; #intval($stats[3]);
		
		if ( ($score > ($onsitescore * 2)) || ($challcount <= 2) || ($onsitescore < 0)) {
			return htmlDisplayError(WC_HTML::lang('err_response', GWF_HTML::display($result), $this->displayName()));
		}
		
		$this->updateSite($onsitescore, $usercount, $challcount);
		
		return array($score, -1);
	}
}
?>