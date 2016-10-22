<?php
final class Tamagochi_Home extends GWF_Method
{
	public function getHTAccess()
	{
		return 'RewriteRule ^tgc/home/?$ index.php?mo=Tamagochi&me=Home'.PHP_EOL;
	}
	
	public function execute()
	{
		return $this->templateHome();
	}
	
	private function templateHome()
	{
		$tVars = array();
		return $this->module->templatePHP('home.php', $tVars);
	}
}