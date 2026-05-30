<?php
/**
 * Hack This Site
 */
final class WCSite_DTW extends WC_Site
{
	public function parseStats($result)
	{
		$stats = explode(":", $result);
		if (count($stats) !== 4) {
			return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($result), $this->displayName())));
		}
		
		$onsitescore = intval($stats[2]);
		$score = intval($stats[1]);
		$rankname = $stats[0]; 
		$usercount = 39500;
		$challcount = 102; #intval($stats[3]);
		
		if ( ($score > ($onsitescore * 2)) || ($challcount <= 2) || ($onsitescore < 0))
		{
			return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($result), $this->displayName())));
		}
		
		return array($score, -1, -1, $onsitescore, $usercount, $challcount);
	}
}
?>
