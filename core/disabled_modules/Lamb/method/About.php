<?php
final class Lamb_About extends GWF_Method
{
	public function getHTAccess()
	{
		return 'RewriteRule ^about_lamb$ index.php?mo=Lamb&me=About'.PHP_EOL;
	}

	public function execute()
	{
		$tVars = array(
		);
		return $this->module->template('about.php', NULL, $tVars);
	}
}
?>