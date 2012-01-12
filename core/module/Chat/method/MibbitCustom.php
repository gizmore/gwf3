<?php
final class Chat_MibbitCustom extends GWF_Method
{
	public function execute(GWF_Module $module)
	{
		return $this->templateMibbit($this->_module);
	}
	
	private function templateMibbit(Module_Chat $module)
	{
		$tVars = array(
		);
		return $this->_module->templatePHP('mibbit_custom.php', $tVars);
	}
}
?>