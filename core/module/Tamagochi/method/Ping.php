<?php
/**
 * Ping and current char at the same time.
 * @author gizmore
 * @license properitary
 */
final class Tamagochi_Ping extends GWF_Method
{
	public function getHTAccess()
	{
		return 'RewriteRule ^tgc/ping/?$ index.php?mo=Tamagochi&me=Ping'.PHP_EOL;
	}
	
	public function execute()
	{
		$user = TGC_Player::getJSONUser();
		$player = $user !== false ? TGC_Player::getCurrent(true) : false;
		$authed = $player !== false;
		$tVars = array(
			'user' => $user !== false ? $user: false,
			'player' => $player !== false ? $player->getGDOData() : false,
			'cookie' => GWF_Session::getCookieValue(),
			'authed' => $authed,
		);
		$code = ($authed === true) ? 200 : ($player ? 403 : 405);
		http_response_code($code);
		die(json_encode($tVars));
	}	
}
