<?php

final class Links_Favorite extends GWF_Method
{
	public function isLoginRequired() { return true; }
	
	public function execute(GWF_Module $module)
	{
		if (false === ($link = GWF_Links::getByID(Common::getGet('lid')))) {
			return $module->error('err_link');
		}
		
		if (!$link->mayView(GWF_Session::getUser())) {
			return $module->error('err_view_perm');
		}
		
		if ('favorite' === Common::getGet('my')) {
			$fav = true;
		}
		elseif ('favorite' === Common::getGet('no')) {
			$fav = false;
		} else {
			return GWF_HTML::err('ERR_GENERAL', array( __FILE__, __LINE__));
		}
		
		if (false === GWF_LinksFavorite::mark(GWF_Session::getUser(), $link, $fav)) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}

		$msg = $fav ? 'msg_fav_yes' : 'msg_fav_no';
		return $module->message($msg);
	}
}
