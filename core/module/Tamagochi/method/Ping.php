<?php
final class Tamagochi_Ping extends GWF_Method
{
	public function getHTAccess()
	{
		return 'RewriteRule ^tgc/ping/?$ index.php?mo=Tamagochi&me=Ping'.PHP_EOL;
	}
	
	public function execute()
	{
		$user = GWF_Session::getUser();
		$player = $user ? TGC_Player::getCurrent(true) : false;
		$authed = $player ? true : false;
		$tVars = array(
			'user' => $user ? $user->getGDOData() : array(),
			'player' => $player ? $player->getGDOData() : array(),
			'cookie' => GWF_Session::getCookieValue(),
			'authed' => $authed,
		);
		$code = $authed ? 200 : $player ? 403 : 405;
		http_response_code($code);
		die(json_encode($tVars));
	}	
}
