<?php
/**
 * @author gizmore
 * @version 1.0
 */
final class ITMB_Credits extends GWF_Method
{
	public function isLoginRequired() { return false; }
	
	public function getHTAccess()
	{
		return 'RewriteRule ^itmb/credits/?$ index.php?mo=ITMB&me=Credits'.PHP_EOL;
	}
	
	public function execute()
	{
		return $this->templateCredits();
	}
	
	public function templateCredits()
	{
		$tVars = array();
		return $this->module->templatePHP('credits.php', $tVars);
	}


}
