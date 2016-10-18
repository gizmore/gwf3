<?php
/**
 * @author gizmore
* @version 1.0
*/
final class ITMB_About extends GWF_Method
{
	public function isLoginRequired() { return false; }

	public function getHTAccess()
	{
		return 'RewriteRule ^itmb/about/?$ index.php?mo=ITMB&me=About'.PHP_EOL;
	}

	public function execute()
	{
		$tVars = array();
		return $this->module->templatePHP('about.php', $tVars);
	}
}
