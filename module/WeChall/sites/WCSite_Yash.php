<?php
/**
 * Yashira
 * rank:score:maxscore:usercount:challcount
 */
class WCSite_Yash extends WC_Site
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
		
		$rank = (int)$data[0];
		$score = (int)($data[1] * 100);
		$maxscore = (int)($data[2] * 100);
		$usercount = (int)$data[3];
		$challcount = (int)$data[4];
		
		if ($maxscore == 0 || $usercount == 0 || $challcount == 0) {
			return htmlDisplayError(WC_HTML::lang('err_response', GWF_HTML::display($result), $this->displayName()));
		}
		
		$this->updateSite($maxscore, $usercount, $challcount);
		
		return array($score, $rank);
	}
}
?>