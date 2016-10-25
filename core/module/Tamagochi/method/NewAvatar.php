<?php
final class Tamagochi_NewAvatar extends GWF_Method
{
	public function getHTAccess()
	{
		return 'RewriteRule ^tgc/new_avatar/?$ index.php?mo=Tamagochi&me=NewAvatar'.PHP_EOL;
	}

	public function execute()
	{
		$tVars = array();
	}
}