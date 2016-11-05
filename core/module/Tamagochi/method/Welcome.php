<?php
final class Tamagochi_Welcome extends GWF_Method
{
	public function getHTAccess()
	{
		return 'RewriteRule ^tgc-welcome/?$ index.php?mo=Tamagochi&me=Welcome'.PHP_EOL;
	}

	public function execute()
	{
		$tVars = array(
		);
		return $this->module->templatePHP('welcome.php', $tVars);
	}

}
