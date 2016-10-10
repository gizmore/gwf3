<?php
/**
 * @author gizmore
 * @version 1.0
 */
final class ITMB_Partners extends GWF_Method
{
	public function isLoginRequired() { return false; }
	
	public function getHTAccess()
	{
		return 'RewriteRule ^itmb/partners/?$ index.php?mo=ITMB&me=Partners'.PHP_EOL;
	}
	
	public function execute()
	{
		return $this->templatePartners();
	}
	
	public function templatePartners()
	{
		$tVars = array();
		return $this->module->templatePHP('partners.php', $tVars);
	}


}
