<?php
/**
* ringzer0team.com
* {"user":"...","score":"...","maxscore":"...","rank":...,"totalplayers":"...","solved":"...","totalchallenges":"..."}
*/
class WCSite_RZT extends WC_Site
{
	public function isAccountValid($onsitename, $onsitemail)
	{
		$url = $this->getAccountURL($onsitename, $onsitemail);
		if (false === ($result = GWF_HTTP::getFromURL($url, false)))
		{
			htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($result), $this->displayName())));
			return false;
		}

		if (WECHALL_DEBUG_LINKING)
		{
			var_dump($url);
			var_dump($result);
		}

		$data = json_decode($result, true, 2);
		if ($data === NULL or isset($data['error']) or !isset($data['success']))
		{
			htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($result), $this->displayName())));
			return false;
		}

		return intval($data['success']) > 0;
	}

	public function parseStats($url)
	{
		if (false === ($result = GWF_HTTP::getFromURL($url, false)))
		{
			return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($result), $this->displayName())));
		}
		
		$stats = json_decode($result, true, 2);
		if ($stats === NULL or isset($stats['error']))
		{
			return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($result), $this->displayName())));
		}

		$onsitescore = intval($stats['score']);
		$onsitescore = Common::clamp($onsitescore, 0);

		$onsiterank = isset($stats['rank']) ? intval($stats['rank']) : -1;

                $challssolved = intval($stats['solved']);

		$maxscore = intval($stats['maxscore']);

		$usercount = intval($stats['totalplayers']);
		
		$challcount = intval($stats['totalchallenges']);

		if ($onsitescore < 0 or $onsitescore > $maxscore or $usercount === 0 or $challssolved < 0 or $challssolved > $challcount)
		{
			return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($result), $this->displayName())));
		}

		return array($onsitescore, $onsiterank, $challssolved, $maxscore, $usercount, $challcount);
	}
}
