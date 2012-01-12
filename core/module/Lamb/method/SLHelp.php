<?php
final class Lamb_SLHelp extends GWF_Method
{
	public function getHTAccess(GWF_Module $module)
	{
		return 'RewriteRule ^shadowhelp/?$ index.php?mo=Lamb&me=SLHelp'.PHP_EOL;
	}
	
	public function execute(GWF_Module $module)
	{
		return $this->templateShadowhelp($this->_module);		
	}
	
	private function templateShadowhelp(Module_Lamb $module)
	{
		$tVars = array(
		);
		return $this->_module->template('shadowhelp.php', $tVars);
	}
}
?>