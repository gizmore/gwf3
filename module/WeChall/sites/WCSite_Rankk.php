<?php
/**
 * Rankk
 * memberinfo.py
 */
final class WCSite_Rankk extends WC_Site
{
	public function parseStats($url)
	{
		if (false === ($result = GWF_HTTP::getFromURL($url, false))) {
			return htmlDisplayError(WC_HTML::lang('err_response', GWF_HTML::display($result), $this->displayName()));
		}

		$data = explode(":", $result);
		if (count($data) !== 7) {
			return htmlDisplayError(WC_HTML::lang('err_response', GWF_HTML::display($result), $this->displayName()));
		}
		
		$challcount = isset($data[5]) ? intval($data[5]) : $this->getVar('challcount');
		$usercount = isset($data[6]) ? intval($data[6]) : $this->getVar('usercount');
		
		if ($data[1] < 0 || $data[1] > $data[2] || $challcount == 0 || $usercount == 0) {
			return htmlDisplayError(WC_HTML::lang('err_response', GWF_HTML::display($result), $this->displayName()));
		}
		
		$this->updateSite($data[2], $usercount, $challcount);
		
		return array($data[1], $data[4]);
	}
}
?>
