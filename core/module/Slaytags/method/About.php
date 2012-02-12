<?php
final class Slaytags_About extends GWF_Method
{
	public function getHTAccess()
	{
		return 'RewriteRule ^about_slaytags.html$ index.php?mo=Slaytags&me=About'.PHP_EOL;
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