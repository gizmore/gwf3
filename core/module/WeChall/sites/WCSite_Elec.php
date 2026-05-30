<?php
final class WCSite_Elec extends WC_Site
{
	public function parseStats($result)
	{
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
		
		return array(round($percent * $maxscore), -1, -1, $maxscore, $usercount, $challcount);
	}
}
?>
