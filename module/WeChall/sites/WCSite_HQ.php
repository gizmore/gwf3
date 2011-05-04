<?php
/**
 * Hackquest
 * $rankpoints:$totalpoints:$challcount:$usercount
 */
class WCSite_HQ extends WC_Site
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
		
		if ($stats[0] < 0 || $stats[0] > $stats[1] || $stats[3] == 0 || $stats[2] == 0) {
			return htmlDisplayError(WC_HTML::lang('err_response', GWF_HTML::display($result), $this->displayName()));
		}
		
		$this->updateSite(10000, $stats[3], $stats[2]);
		
		$score = round($stats[0] / $stats[1] * 10000);
		
		return array($score, -1);
	}
	
}

?>