<?php
final class Konzert_Admin extends GWF_Method
{
	public function getUserGroups() { return array('admin','staff'); }
	
	public function execute()
	{
		return $this->templateAdmin();
	}
	
	private function templateAdmin()
	{
		$tVars = array(
		);
		return $this->module->template('admin.tpl', $tVars);
	}
}
?>