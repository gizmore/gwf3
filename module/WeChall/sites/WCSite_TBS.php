<?php
# Score:MaxScore:Challs:Users
final class WCSite_TBS extends WC_Site
{
	public function parseStats($url)
	{
		$result = GWF_HTTP::getFromURL($url, false);
		
		if ($result === false) {
			return false;
		}
		
		if ($result === "Unknown User") {
			return htmlDisplayError(WC_HTML::lang('err_onsitename', $this->displayName()));
		}
		
		$data = explode(":", $result);
		
		if (count($data) !== 5 || $data[3] < 0 || $data[3] > $data[4] || $data[2] == 0 || $data[4] == 0) {
			return htmlDisplayError(WC_HTML::lang('err_response', GWF_HTML::display($result), $this->displayName()));
		}
		
		$this->updateSite($data[4], $data[2], $data[4]);
		
		return array($data[3], Common::clamp($data[1], 0));
	}
}

?>