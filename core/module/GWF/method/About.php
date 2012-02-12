<?php
final class GWF_About extends GWF_Method
{
	public function getHTAccess()
	{
		return 'RewriteRule ^about_gwf/?$ index.php?mo=GWF&me=About'.PHP_EOL;
	}
	
	public function execute()
	{
		return $this->templateAbout();
	}
	
	private function templateAbout()
	{
		$tVars = array(
		);
		return $this->module->template('about.tpl', $tVars);
	}
}
?>