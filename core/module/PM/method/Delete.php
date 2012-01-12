<?php
final class PM_Delete extends GWF_Method
{
	public function execute(GWF_Module $module)
	{
		return $this->onDelete($this->_module, Common::getGet('pmid'), Common::getGet('token'), Common::getGet('uid'))
			.$this->_module->requestMethodB('Overview');
	}
	
	private function onDelete(Module_PM $module, $id, $token, $uid)
	{
		if (false === ($pm = GWF_PM::getByID($id))) {
			return $this->_module->error('err_pm');
		}
		if ($token != ($pm->getHashcode())) {
			echo $pm->getHashcode();
			return $this->_module->error('err_pm');
		}
		if (false === ($user = GWF_User::getByID($uid))) {
			return GWF_HTML::err('ERR_UNKNOWN_USER');
		}
		
		if (false === $pm->markDeleted($user)) {
			return $this->_module->error('err_del_twice');
		}
		
		return
			$this->_module->message('msg_deleted', array('1'));
	}
}
?>