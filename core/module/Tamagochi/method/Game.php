<?php
final class Tamagochi_Game extends GWF_Method
{
	public function getHTAccess()
	{
		return 'RewriteRule ^tgc/game/?$ index.php?mo=Tamagochi&me=Game'.PHP_EOL;
	}

	public function execute()
	{
		$tVars = array(
			'user' => GWF_Session::getUser(),
			'player' => TGC_Player::getCurrent(),
			'sessid' => GWF_Session::getCookieValue(),
		);
		return $this->module->templatePHP('game.php', $tVars);
	}
}
