<?php
/**
 * @author gizmore
 * @deprecated
 */
final class GWF_JSEnabled extends GWF_Method
{
	public function execute(GWF_Module $module)
	{
		if (GWF_Session::haveCookies())
		{
			GWF_Session::set(GWF_Browser::SESS_DETECTION, 1);
			GWF_Session::set(GWF_Browser::SESS_RESOLUTION, array(intval(Common::getGet('w', -1)),intval(Common::getGet('h', -1))));
			GWF_Website::redirectBack();
		}
		else
		{
			$url = Common::getGet('url', GWF_Session::getLastURL());
			if ($module->cfgFallbackSessions())
			{
				GWF_Session::createFallback($url);
				GWF_Website::redirect(GWF_WEB_ROOT.'index.php?mo=GWF&me=CookieCheck&level=2&url='.urlencode($url));
			}
			else
			{
				GWF_Website::redirectBack();
			}
		}
	}
}

?>