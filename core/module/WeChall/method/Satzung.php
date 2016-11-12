<?php
final class WeChall_Satzung extends GWF_Method
{
	public function getHTAccess()
	{
		return 'RewriteRule ^satzung.html$ index.php?mo=WeChall&me=Satzung'.PHP_EOL;
	}

	public function execute()
	{
		$tVars = array(
		);
		return $this->module->templatePHP('satzung.php', $tVars);
	}
}
