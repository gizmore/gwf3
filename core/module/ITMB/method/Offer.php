<?php
/**
 * @author gizmore
 * @version 1.0
 */
final class ITMB_Home extends GWF_Method
{
	public function isLoginRequired() { return false; }
	
	public function getHTAccess()
	{
		return 'RewriteRule ^itmb/offers/?$ index.php?mo=ITMB&me'.PHP_EOL;
	}
	
	public function execute()
	{
		return $this->templateHome();
	}
	
	public function templateHome()
	{
		$tVars = array();
		return $this->module->templatePHP('home.php', $tVars);
	}


}
