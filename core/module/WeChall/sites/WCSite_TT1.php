<?php
/**
 * Try This One
 */
final class WCSite_TT1 extends WC_Site
{
	public function parseStats($url)
	{		
		if (false === ($result = GWF_HTTP::getFromURL($url, false))) {
			return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($result), $this->displayName())));
		}

		$data = explode(":", $result);
		if (count($data) !== 5) {
			return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($result), $this->displayName())));
		}
		
		$title = $data[0];
		$score = intval($data[1]);
		
		$challcount = isset($data[4]) ? intval($data[4]) : $this->getVar('challcount');
		$usercount = isset($data[3]) ? intval($data[3]) : $this->getVar('usercount');
		
		if ($data[1] < 0 || $data[1] > $data[2] || $challcount == 0 || $usercount == 0) {
			return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($result), $this->displayName())));
		}
		
		$this->updateSite($data[2], $usercount, $challcount);
		
		return array($data[1], $data[0], -1);
	}
}
?>