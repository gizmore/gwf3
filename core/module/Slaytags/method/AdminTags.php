<?php
final class Slaytags_AdminTags extends GWF_Method
{
	public function getUserGroups() { return array(GWF_Group::ADMIN, GWF_Group::STAFF); }
	
	public function execute()
	{
		return $this->templateAdminTags();
	}
	
	private function templateAdminTags()
	{
		$tVars = array(
		);
		return $this->module->template('admin_tags.tpl', $tVars);
	}
}
?>