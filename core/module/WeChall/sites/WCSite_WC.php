<?php
# Score:MaxScore:Challs:Users
final class WCSite_WC extends WC_Site
{
	public function parseStats($url)
	{
		$result2 = GWF_HTTP::getFromURL($url, false);
		
		$result = explode(':', $result2);
		
		if (count($result) !== 6) {
			return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($result2), $this->displayName())));
		}
		
		list($rank, $score, $maxscore, $challsolved, $challcount, $usercount) = $result;
		
		$this->updateSite($maxscore, $usercount, $challcount);
		
		return array(intval($score), (int)$rank, $challsolved);
	}
}

?>
