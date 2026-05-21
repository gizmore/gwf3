<?php
/**
 * Hack This Site
 */
final class WCSite_HTS extends WC_Site
{
	public function parseStats($url)
	{
		if (false === ($result = GWF_HTTP::getFromURL($url, false))) {
			return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($result), $this->displayName())));
		}
		$stats = explode(":", $result);
		if (count($stats) !== 4) {
			return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($result), $this->displayName())));
		}
		
		$onsitescore = intval($stats[2]);   // this is always 6713 - probably was a max score once?
		$score = intval($stats[1]);
		$rankname = $stats[0];
		// max score from https://www.hackthissite.org/user/rankings/explanation
		// note: users might still have higher scores, as e.g. finding a vuln gives points, too
		$maxScore = 10533;
		$usercount = 39500;
		$challcount = 107; #intval($stats[3]);
		
		if ( ($score > ($onsitescore * 2)) || ($challcount <= 2) || ($onsitescore < 0))
		{
			return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($result), $this->displayName())));
		}
		
		return array($score, -1, -1, $maxScore, $usercount, $challcount);
	}
}
?>
