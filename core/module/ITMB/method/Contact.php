<?php
/**
 * @author gizmore
* @version 1.0
*/
final class ITMB_Contact extends GWF_Method
{
	public function isLoginRequired() { return false; }

	public function getHTAccess()
	{
		return 'RewriteRule ^itmb/contact/?$ index.php?mo=ITMB&me=Contact'.PHP_EOL;
	}

	public function execute()
	{
		return $this->templateHome();
	}

	public function templateHome()
	{
		$tVars = array();
		return $this->module->templatePHP('contact.php', $tVars);
	}


}
