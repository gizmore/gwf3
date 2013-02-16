<?php
/**
 * Happy Security
 * rank:score:maxscore:usercount:challcount
 * 431:21:154:4309:0:Gizmore
 */
class WCSite_HS extends WC_Site
{
	public function parseStats($url)
	{
		if (false === ($result = GWF_HTTP::getFromURL($url, false)))
		{
			return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($result), $this->displayName())));
		}

		$data = explode(':', $result);
		if (count($data) !== 6)
		{
			return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($result), $this->displayName())));
		}
		
		$rank = (int) $data[0];
		$score = (int) $data[1];
		$maxscore = (int) $data[2]; // on site max score
		$usercount = (int) $data[3];
		$challcount = (int) $data[4] = (int) $maxscore;
		$onsitename = (int) $data[5];
		
		if ($score > $maxscore || $score < 0 || $challcount == 0 || $usercount == 0 || $maxscore == 0)
		{
			return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($result), $this->displayName())));
		}
		
		return array($score, $rank, -1, $maxscore, $usercount, $challcount);		
	}
	
}

?>
