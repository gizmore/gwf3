<?php
final class Tamagochi_NewAvatar extends GWF_Method
{
	public function getHTAccess()
	{
		return 'RewriteRule ^tgc/new_avatar/?$ index.php?mo=Tamagochi&me=NewAvatar&ajax=1'.PHP_EOL;
	}

	public function execute()
	{
		
		$tVars = array(
				
		);
		die(json_encode($tVars));
	}
}