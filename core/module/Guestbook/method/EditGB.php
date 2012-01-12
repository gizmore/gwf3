<?php

final class Guestbook_EditGB extends GWF_Method
{
	public function isLoginRequired() { return true; }
	
//	public function getHTAccess(GWF_Module $module)
//	{
//		return 'RewriteRule ^guestbook/edit/(\d+)$ index.php?mo=Guestbook&me=EditGB&gb=$1'.PHP_EOL;
//	}

	public function execute(GWF_Module $module)
	{
		if (false === ($gb = GWF_Guestbook::getByID(Common::getGet('gb')))) {
			return $this->_module->error('err_gb');
		}
		
		if (false === $gb->canModerate(GWF_Session::getUser())) {
			return GWF_HTML::err('ERR_NO_PERMISSION');
		}
		
		return $this->templateModerate($this->_module);
	}

	public function templateModerate()
	{
		
	}
	
}

?>