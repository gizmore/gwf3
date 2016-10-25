<?php
final class Tamagochi_ChangeSetting extends GWF_Method
{
	public function getHTAccess()
	{
		return 'RewriteRule ^tgc/change_setting/?$ index.php?mo=Tamagochi&me=ChangeSetting'.PHP_EOL;
	}
	
	public function execute()
	{
		if (false !== ($error = $this->validate())) {
			return $error;
		}
		$tVars = array();
		return $this->module->templatePHP('game.php', $tVars);
	}
	
}