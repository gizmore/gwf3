<?php

final class GWF_PoweredBy extends GWF_Method
{
	public function getHTAccess(GWF_Module $module)
	{
		return 'RewriteRule ^is_powered_by$ index.php?mo=GWF&me=PoweredBy'.PHP_EOL;
	}
	
	public function execute(GWF_Module $module)
	{
		$tVars = array(
		);
		return $module->templatePHP('powered_by.php', $tVars);
	}
	
}

?>