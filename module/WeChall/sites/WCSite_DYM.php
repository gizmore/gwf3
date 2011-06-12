<?php
// rank:score:maxscore:usercount:challcount
// 431:21.23:154:4309:0:Gizmore
class WCSite_DYM extends WC_Site
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
		
		$rank = (int)$data[0];
		$score = (int)($data[1] * 100);
		$maxscore = (int)($data[2] * 100);
		$users = (int) $data[3];
		$challs = (int) $data[4];
		
		if ($score > $maxscore || $score < 0 || $maxscore == 0 || $challs == 0) {
			return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($result), $this->displayName())));
		}
		
		$this->updateSite($maxscore, $users, $challs);
		
		return array($score, $rank);
	}
	
}
?>
