<?php
/**
 * Net-Force
 * rank:solved:challcount:usercount
 */
class WCSite_NF extends WC_Site
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
		
		list($rank, $score, $challcount, $usercount) = $stats;
		
		if ($rank < 1 || $challcount == 0 || $usercount == 0) {
			return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($result), $this->displayName())));
		}
		
		return array($score, $rank, $score, $challcount, $usercount, $challcount);
	}
}

?>
