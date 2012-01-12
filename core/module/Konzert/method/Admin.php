<?php
final class Konzert_Admin extends GWF_Method
{
	public function getUserGroups() { return array('admin','staff'); }
	
	public function execute()
	{
		return $this->templateAdmin($this->_module);
	}
	
	private function templateAdmin()
	{
		$tVars = array(
		);
		return $this->_module->template('admin.tpl', $tVars);
	}
}
?>