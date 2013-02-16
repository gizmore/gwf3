<?php
# solved:challcount:usercount
class WCSite_Asta extends WC_Site
{
	public function parseStats($url)
	{
		if (false === ($result = GWF_HTTP::getFromURL($url, false))) {
			return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($result), $this->displayName())));
		}
		
		$stats = explode(':', $result);
		if (count($stats) !== 3) {
			return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($result), $this->displayName())));
		}

		list($onsitescore, $challcount, $usercount) = $stats;

		if ($challcount == 0 || $usercount == 0) {
			return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($result), $this->displayName())));
		}
		
		return array($onsitescore, -1, -1, $challcount, $usercount, $challcount);
	}
}
?>