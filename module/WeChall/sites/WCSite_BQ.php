<?php
//	rank:score:maxscore:usercount:challcount
class WCSite_BQ extends WC_Site
{
	public function parseStats($url)
	{
		if (false === ($result = GWF_HTTP::getFromURL($url, false))) {
			return htmlDisplayError(WC_HTML::lang('err_response', GWF_HTML::display($result), $this->displayName()));
		}
		
		$data = explode(':', $result);
		if (count($data) !== 5) {
			return htmlDisplayError(WC_HTML::lang('err_response', GWF_HTML::display($result), $this->displayName()));
		}
		
		list($rank, $score, $maxscore, $usercount, $challcount) = $data;
		
		if ($rank == 0 || $maxscore == 0 || $usercount == 0 || $challcount == 0) {
			return htmlDisplayError(WC_HTML::lang('err_response', GWF_HTML::display($result), $this->displayName()));
		}
		
		$this->updateSite($maxscore, $usercount, $challcount);
		
		return array(round($score), $rank);
	}
	
}

?>