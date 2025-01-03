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
			'ws_url' => $this->module->cfgWebsocketUrl(),
			'wss_url' => $this->getWSSURl(),
			'levels' => GWF_Javascript::toJavascriptArray(TGC_Const::$LEVELS),
			'runes' => json_encode(TGC_Const::$RUNES),
		);
		return $this->module->templatePHP('home.php', $tVars);
	}
	
	private function getWSSURl()
	{
		return GWF_DOMAIN === 'giz.org' ? $this->module->cfgWebsocketUrl() : $this->module->cfgWebsocketTLSUrl();
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
