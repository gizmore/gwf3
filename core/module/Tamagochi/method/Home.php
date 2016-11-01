<?php
final class Tamagochi_Home extends GWF_Method
{
	public function getHTAccess()
	{
		return 'RewriteRule ^tgc/home/?$ index.php?mo=Tamagochi&me=Home'.PHP_EOL;
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
			'cookie' => GWF_Session::getCookieValue(),
			'api_key' => $this->module->cfgMapsApiKey(),
			'max_avatars' => $this->module->cfgMaxAvatars(),
			'max_avatar_size' => $this->module->cfgMaxAvatarSize(),
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
