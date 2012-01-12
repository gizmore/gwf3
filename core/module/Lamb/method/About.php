<?php
final class Lamb_About extends GWF_Method
{
	public function getHTAccess(GWF_Module $module)
	{
		return 'RewriteRule ^about_lamb$ index.php?mo=Lamb&me=About'.PHP_EOL;
	}

	public function execute(GWF_Module $module)
	{
		$tVars = array(
		);
		return $this->_module->template('about.php', NULL, $tVars);
	}
}
?>