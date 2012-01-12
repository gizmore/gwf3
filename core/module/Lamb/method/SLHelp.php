<?php
final class Lamb_SLHelp extends GWF_Method
{
	public function getHTAccess()
	{
		return 'RewriteRule ^shadowhelp/?$ index.php?mo=Lamb&me=SLHelp'.PHP_EOL;
	}
	
	public function execute()
	{
		return $this->templateShadowhelp();		
	}
	
	private function templateShadowhelp()
	{
		$tVars = array(
		);
		return $this->_module->template('shadowhelp.php', $tVars);
	}
}
?>