<?php
final class GWF_AboutGWF extends GWF_Method
{
	public function getHTAccess(GWF_Module $module)
	{
		return 'RewriteRule ^about_gwf$ index.php?mo=GWF&me=AboutGWF'.PHP_EOL;
	}
	
	public function execute(GWF_Module $module)
	{
		return $module->template('about.php');
	}
}
?>