<?php
/**
 * @author gizmore
* @version 1.0
*/
final class ITMB_References extends GWF_Method
{
	public function isLoginRequired() { return false; }

	public function getHTAccess()
	{
		return 'RewriteRule ^itmb/references/?$ index.php?mo=ITMB&me=References'.PHP_EOL;
	}

	public function execute()
	{
		$tVars = array();
		return $this->module->templatePHP('references.php', $tVars);
	}


}
