<?php
final class Tamagochi_StartGame extends GWF_Method
{
	public function isLoginRequired() { return true; }
	
	public function getHTAccess()
	{
		return 'RewriteRule ^tgc/start/game/?$ index.php?mo=Tamagochi&me=StartGame'.PHP_EOL;
	}
	
	public function execute()
	{
	}
	
	private function templateStartGame()
	{
		
	}
}