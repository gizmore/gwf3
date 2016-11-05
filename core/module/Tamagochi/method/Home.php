<?php
final class Tamagochi_Home extends GWF_Method
{
	public function getHTAccess()
	{
		return 'RewriteRule ^tgc-game/?$ index.php?mo=Tamagochi&me=Home'.PHP_EOL;
	}
	
	public function execute()
	{
// 		GWF_Website::addJavascript($this->googleMapsPath());
		return $this->templateHome();
	}
	
	private function templateHome()
	{
		$tVars = array(
			'user' => GWF_Session::getUser(),
			'player' => TGC_Player::getCurrent(),
// 			'api_key' => $this->module->cfgMapsApiKey(),
			'ws_url' => $this->module->cfgWebsocketUrl(),
			'levels' => GWF_Javascript::toJavascriptArray(TGC_Const::$LEVELS),
		);
		return $this->module->templatePHP('home.php', $tVars);
	}

	private function googleAPIKey()
	{
		$api_key = $this->module->cfgMapsApiKey();
		return $api_key === '' ? '' : '&key='.$api_key;
	}
	
	private function googleMapsPath()
	{
		return Common::getProtocol().'s://maps.googleapis.com/maps/api/js?sensor=true'.$this->googleAPIKey();
	}
	
}
