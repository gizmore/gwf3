<?php
final class Tamagochi_Ping extends GWF_Method
{
	public function getHTAccess()
	{
		return 'RewriteRule ^tgc/ping/?$ index.php?mo=Tamagochi&me=Ping'.PHP_EOL;
	}
	
	public function execute()
	{
		$tVars = array(
			'user' => GWF_Session::getUser(),
			'player' => TGC_Player::getCurrent(),
			'sessid' => GWF_Session::getCookieValue(),
		);
		die(json_encode($tVars));
	}
	
}
