<?php
/**
 * LOST
 * rank:score:maxscore:usercount:challcount
 * 431:21:154:4309:0:Gizmore
 */
class WCSite_Lost extends WC_Site
{
	public function parseStats($url)
	{
		if (false === ($result = GWF_HTTP::getFromURL($url, false))) {
			return htmlDisplayError(WC_HTML::lang('err_response', GWF_HTML::display($result), $this->displayName()));
		}
		$data = explode(":", $result);
		if (count($data) !== 5) {
			return htmlDisplayError(WC_HTML::lang('err_response', GWF_HTML::display($result), $this->displayName()));
		}
		
		if ($data[1] > $data[2] || $data[1] < 0 || $data[3] == 0) {
			return htmlDisplayError(WC_HTML::lang('err_response', GWF_HTML::display($result), $this->displayName()));
		}
		
		$this->updateSite($data[2], $data[3], $data[4]);
		
		return array($data[1], $data[0]);
	}
	
}

?>
