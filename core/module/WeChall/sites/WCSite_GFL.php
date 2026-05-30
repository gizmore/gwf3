<?php
class WCSite_GFL extends WC_Site
{
	private function post($url, $data)
	{
		return GWF_HTTP::post($url, json_encode($data), false, array('Content-Type: application/json'));
	}

	public function requestAccountHelper($url, $username, $email, $auth_key)
	{
		$payload = array(
			'username' => $username,
			'email' => $email,
			'apikey' => $auth_key
		);

		$result = $this->post($url, $payload);
		return $result;
	}

	public function requestScoreHelper($url, $username, $auth_key)
	{
		$payload = array(
			'username' => $username,
			'apikey' => $auth_key
		);

		$result = $this->post($url, $payload);
		return $result;
	}

	public function parseStats($result)
	{
		$stats = json_decode($result, true, 2);
		if ($stats === NULL or isset($stats['error']))
		{
			return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($result), $this->displayName())));
		}

		$onsitescore = intval($stats['score']);
		$onsitescore = Common::clamp($onsitescore, 0);

		$onsiterank = isset($stats['rank']) ? intval($stats['rank']) : -1;

                $challssolved = intval($stats['challsolved']);

		$maxscore = intval($stats['maxscore']);

		$usercount = intval($stats['usercount']);

		$challcount = intval($stats['challcount']);

		if ($onsitescore < 0 or $onsitescore > $maxscore or $usercount === 0 or $challssolved < 0 or $challssolved > $challcount)
		{
			return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($result), $this->displayName())));
		}

		return array($onsitescore, $onsiterank, $challssolved, $maxscore, $usercount, $challcount);
	}
}
