<?php
final class Slaytags_About extends GWF_Method
{
	public function getHTAccess(GWF_Module $module)
	{
		return 'RewriteRule ^about_slaytags.html$ index.php?mo=Slaytags&me=About'.PHP_EOL;
	}

	public function execute(GWF_Module $module)
	{
		return $this->templateAbout($module);
	}
	
	private function templateAbout(Module_Slaytags $module)
	{
		$tVars = array(
		);
		return $module->template('about.tpl', $tVars);
	}
}
?>