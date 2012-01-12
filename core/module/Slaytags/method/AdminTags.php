<?php
final class Slaytags_AdminTags extends GWF_Method
{
	public function getUserGroups() { return array(GWF_Group::ADMIN, GWF_Group::STAFF); }
	
	public function execute(GWF_Module $module)
	{
		return $this->templateAdminTags($this->_module);
	}
	
	private function templateAdminTags(Module_Slaytags $module)
	{
		$tVars = array(
		);
		return $this->_module->template('admin_tags.tpl', $tVars);
	}
}
?>