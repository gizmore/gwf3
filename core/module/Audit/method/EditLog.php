<?php
final class Audit_EditLog extends GWF_Method
{
	public function getUserGroups() { return array(GWF_Group::STAFF); }
	
	public function execute(GWF_Module $module)
	{
		return $this->templateEditLog($this->_module);
	}
	
	private function templateEditLog(Module_Audit $module)
	{
		return 'NOT IMPLEMENTED';
	}
}
?>