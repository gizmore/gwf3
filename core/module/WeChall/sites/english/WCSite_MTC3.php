<?php
class WCSite_MTC3 extends WC_Site
{
	public function parseStats($json)
	{
		$data = json_decode($json, true, 4);
		if ($data === null || !isset($data['users']))
		{
			return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($json), $this->displayName())));
		}

		if (count($data['users']) !== 1)
		{
			return htmlDisplayError(WC_HTML::lang('err_response', array(WC_HTML::lang('err_username_displayname'), $this->displayName())));
		}

		$stats = $data['users'][0];
		if (
			   !isset($stats['score'])
			|| !isset($stats['rank'])
			|| !isset($stats['challenges_solved'])
			|| !isset($stats['maxscore'])
			|| !isset($stats['user_count'])
			|| !isset($stats['challenge_count'])
		)
		{
			return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($json), $this->displayName())));
		}

		return array(
			$stats['score'],
			$stats['rank'],
			$stats['challenges_solved'],
			$stats['maxscore'],
			$stats['user_count'],
			$stats['challenge_count']
		);
	}

	public function parseAccount($json)
	{
		$data = json_decode($json, true, 2);
		if ($data === null || !isset($data['exists']))
		{
			return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($json), $this->displayName())));
		}

		return $data['exists'] === true;
	}
}
