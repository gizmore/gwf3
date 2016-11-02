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
		$player = $user ? TGC_Player::getCurrent(true) : false;
		$authed = $player !== false;
		$tVars = array(
			'user' => $user ? $user: false,
			'player' => $player ? $player->getGDOData() : false,
			'secret' => $player ? $this->getUserSecret(GWF_Session::getUser()) : false,
			'authed' => $authed,
		);
		$code = ($authed === true) ? 200 : ($player ? 403 : 405);
		http_response_code($code);
		die(json_encode($tVars));
	}
	
	private function getUserSecret(GWF_User $user)
	{
		return sprintf("%s:%s:%s", $user->getID(), $user->getVar('user_name'), substr($user->getVar('user_password'), TGC_Const::SECRET_CUT));
	}
	
}
