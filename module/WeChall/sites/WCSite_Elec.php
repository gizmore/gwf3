<?php
final class WCSite_Elec extends WC_Site
{
	public function parseStats($url)
	{
		if (false === ($result = GWF_HTTP::getFromURL($url, false))) {
			return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($result), $this->displayName())));
		}
		
		$data = explode(':', $result);
		
		$percent = $data[0];
		if (!is_numeric($percent) || $percent < 0 || $percent > 1) {
			return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($result), $this->displayName())));
		}
		
		$usercount = isset($data[1]) ? $data[1] : $this->getUsercount();
		
		if ($usercount == 0) {
			return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($result), $this->displayName())));
		}
		
		$maxscore = $this->getOnsiteScore();
		$challcount = $this->getChallcount();
		
		$this->updateSite($maxscore, $usercount, $challcount);
		
		return array(round($percent * $maxscore), -1);
	}
}
?>