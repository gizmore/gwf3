<?php
# 1:8:username
class WCSite_Hispa extends WC_Site
{
	public function parseStats($url)
	{
		if (false === ($result = GWF_HTTP::getFromURL($url, false))) {
			return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($result), $this->displayName())));
		}

		$stats = explode(":", $result);
		if (count($stats) < 3) {
			return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($result), $this->displayName())));
		}
		$challs = $stats[1];
		$done = $stats[0];
		#$usercount = $stats[2];
		
		if ($challs == 0) {# || $usercount == 0) {
			return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($result), $this->displayName())));
		}
		
		return array($done, -1, $done, $challs, 0, $challs);
	}
}
?>