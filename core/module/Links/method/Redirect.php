<?php

final class Links_Redirect extends GWF_Method
{
//	public function getHTAccess(GWF_Module $module)
//	{
////		return 'RewriteRule ^links/redirect/([0-9]+)/? index.php?mo=Links&me=Redirect&lid=$1'.PHP_EOL;
//	}
	
	public function execute(GWF_Module $module)
	{
		if (false === ($link = GWF_Links::getByID(Common::getGet('lid')))) {
			return $module->error('err_link');
		}
		
		if (!$link->mayView(GWF_Session::getUser())) {
			return $module->error('err_view_perm');
		}
		
		if (false === $link->increase('link_clicks', 1)) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
		if (false === $link->onCalcPopularity()) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
//		$link->markRead(GWF_Session::getUser());
		
		return $module->message('msg_counted_visit');
		
//		header('Location: '.$link->getVar('link_href'));
//		return $module->message('msg_redirecting', array($link->display('link_href')));
	}
}
