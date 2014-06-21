<?php
/**
* chall.codeshell.kr
* rank missing.
* username:score:maxscore:challssolved:challcount:usercount
*/
class WCSite_CS extends WC_Site
{
	public function parseStats($url)
	{
		if (false === ($page = GWF_HTTP::getFromURL($url, false)))
		{
			return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($page), $this->displayName())));
		}
	
		$result = explode(':', trim($page));
		if (count($result) !== 6)
		{
			return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($page), $this->displayName())));
		}
	
		$i = 0;
		$username = $result[$i++];
		$rank = -1;
		$score = $result[$i++];
		$maxscore = $result[$i++];
		$challssolved = $result[$i++];
		$challcount = $result[$i++];
		$usercount = $result[$i++];
	
		if ($maxscore === 0 || $challcount === 0)
		{
			return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($result), $this->displayName())));
		}
	
		return array($score, $rank, $challssolved, $maxscore, $usercount, $challcount);
	}
}
