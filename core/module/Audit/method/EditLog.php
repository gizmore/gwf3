<?php
final class Audit_EditLog extends GWF_Method
{
	public function getUserGroups() { return array(GWF_Group::STAFF); }
	
	public function execute()
	{
		return $this->templateEditLog($this->_module);
	}
	
	private function templateEditLog()
	{
		return 'NOT IMPLEMENTED';
	}
}
?>