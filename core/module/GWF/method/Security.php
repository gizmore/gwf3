<?php
final class GWF_Security extends GWF_Method
{
	public function getHTAccess()
	{
		$m = $this->module;
		$m instanceof Module_GWF;
		$back = '';
		if (false === $m->cfgAllRequests())
		{
			$back .= 
			'# Secure Limits'.PHP_EOL.
			'<LimitExcept GET HEAD POST>'.PHP_EOL.
			'  Deny from all'.PHP_EOL.
			'</LimitExcept>'.PHP_EOL.PHP_EOL;
		}
		return $back;
	}
	
	public function execute()
	{
		
	}
}
?>