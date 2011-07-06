<?php
/**
 * Newbie Contest
 */
final class WCSite_NC extends WC_Site
{
	public function parseStats($url)
	{
		if (false === ($result = GWF_HTTP::getFromURL($url, false))) {
			return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($result), $this->displayName())));
		}
		
		$file = explode('<br>', $result);

		if (count($file) !== 5) {
			return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($result), $this->displayName())));
		}
		
//		$ranking = $file[1];
		list($ranking, $usercount) = explode('/', trim(Common::substrFrom($file[1], ':')));
//		$usercount = Common::substrFrom($ranking, "/");
		
		$challstats = $file[3];
		$challcount = Common::substrFrom($challstats, "/");
		
		$points = $file[2];
		
		$back = array();
		preg_match('#(\d*)\/(\d*)#', $points, $back);
		
		if (count($back) !== 3 || $back[1] < 0 || $back[1] > $back[2] || $usercount == 0 || $challcount == 0) {
			return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($result), $this->displayName())));
		}
		
		$this->updateSite($back[2], $usercount, $challcount);

		return array($back[1], $ranking, -1);
	}
}

?>
