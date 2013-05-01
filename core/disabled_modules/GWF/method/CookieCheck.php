<?php
/**
 * Session Detection
 * @author gizmore
 * @deprecated
 */
final class GWF_CookieCheck extends GWF_Method
{
	public function execute(GWF_Module $module)
	{
		$url = Common::getGet('url', GWF_Session::getLastURL());
		
		switch (Common::getGet('level'))
		{
			case '1': 
				if (GWF_Session::haveCookies() === true) {
					GWF_Website::redirectBack();
				}
				elseif ($module->cfgFallbackSessions()) {
					GWF_Session::createFallback($url);
					GWF_Website::redirect(GWF_WEB_ROOT.'index.php?mo=GWF&me=CookieCheck&level=2&url='.urlencode($url));
				}
				else {
					GWF_Website::redirect($url);
				}
				break;
			case '2':
//				var_dump($_SERVER);
				GWF_Website::redirect($url);
				break;
			default:
				return GWF_HTML::err('ERR_PARAMETER', array( __FILE__, __LINE__, 'level'));
		}
	}
}

?>
