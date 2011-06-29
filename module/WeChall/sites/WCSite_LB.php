<?php
#rank:score:maxscore:usercount:challcount
class WCSite_LB extends WC_Site
{
	public function parseStats($url)
	{
		if (false === ($result = GWF_HTTP::getFromURL($url, false))) {
			return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($result), $this->displayName())));
		}
		
		$stats = explode(':', $result);
		if (count($stats) !== 5) {
			return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($result), $this->displayName())));
		}

		list($rank, $onsitescore, $maxscore, $usercount, $challcount) = $stats;

		if ($maxscore == 0 || $challcount == 0 || $usercount == 0) {
			return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($result), $this->displayName())));
		}
		
		$this->updateSite($maxscore, $usercount, $challcount);
		
		return array($onsitescore, $rank, -1);
	}
}
?>