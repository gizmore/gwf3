<?php
final class Wanda_Home extends GWF_Method
{
	public function getHTAccess()
	{
		return 'RewriteRule ^wanda/home/?$ index.php?mo=Wanda&me=Home'.PHP_EOL;
	}
	
	public function execute()
	{
		$tVars = array();
		return $this->module->templatePHP('home.php', $tVars);
	}
	
	
}