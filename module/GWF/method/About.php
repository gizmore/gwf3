<?php
final class GWF_About extends GWF_Method
{
	public function getHTAccess(GWF_Module $module)
	{
		return 'RewriteRule ^about_gwf/?$ index.php?mo=GWF&me=About'.PHP_EOL;
	}
	
	public function execute(GWF_Module $module)
	{
		return $this->templateAbout($module);
	}
	
	private function templateAbout(Module_GWF $module)
	{
		$tVars = array(
		);
		return $module->template('about.tpl', $tVars);
	}
}
?>