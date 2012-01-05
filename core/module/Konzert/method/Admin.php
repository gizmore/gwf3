<?php
final class Konzert_Admin extends GWF_Method
{
	public function getUserGroups() { return array('admin','staff'); }
	
	public function execute(GWF_Module $module)
	{
		return $this->templateAdmin($module);
	}
	
	private function templateAdmin(Module_Konzert $module)
	{
		$tVars = array(
		);
		return $module->template('admin.tpl', $tVars);
	}
}
?>