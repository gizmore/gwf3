<?php
final class PM_Delete extends GWF_Method
{
	public function execute(GWF_Module $module)
	{
		return $this->onDelete($module, Common::getGet('pmid'), Common::getGet('token'), Common::getGet('uid'))
			.$module->requestMethodB('Overview');
	}
	
	private function onDelete(Module_PM $module, $id, $token, $uid)
	{
		if (false === ($pm = GWF_PM::getByID($id))) {
			return $module->error('err_pm');
		}
		if ($token != ($pm->getHashcode())) {
			echo $pm->getHashcode();
			return $module->error('err_pm');
		}
		if (false === ($user = GWF_User::getByID($uid))) {
			return GWF_HTML::err('ERR_UNKNOWN_USER');
		}
		
		if (false === $pm->markDeleted($user)) {
			return $module->error('err_del_twice');
		}
		
		return
			$module->message('msg_deleted', array('1'));
	}
}
?>