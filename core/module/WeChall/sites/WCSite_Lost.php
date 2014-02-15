<?php
/**
 * LOST (perfect defaults)
 * uname:rank:score:maxscore:solved:challs:users
 * gizmore:785:1:618:1:200:3072
 * dalfor:2:569:618:191:200:3072
 */
class WCSite_Lost extends WC_Site
{
// 	public function parseStats($url)
// 	{
// 		if (false === ($result = GWF_HTTP::getFromURL($url, false))) {
// 			return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($result), $this->displayName())));
// 		}
// 		$data = explode(":", $result);
// 		if (count($data) !== 5) {
// 			return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($result), $this->displayName())));
// 		}
		
// 		if ($data[1] > $data[2] || $data[1] < 0 || $data[3] == 0) {
// 			return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($result), $this->displayName())));
// 		}
		
// 		return array($data[1], $data[0], -1, $data[2], $data[3], $data[4]);
// 	}
}
