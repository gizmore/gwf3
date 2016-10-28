<?php
final class Tamagochi_Avatars extends GWF_Method
{
	private $uid = 0;
	
	
	public function execute()
	{
		if (false !== ($error = $this->validate())) {
			return $error;
		}
		$tVars = array();
		die(json_encode($tVars));
	}
	
	private function validate()
	{
		if (false === ($this->uid = Common::getGetInt('uid'))) {
			return $this->module->error('err_api_no_uid');
		}
		if (false === ($this->requested = Common::getGetArray('avatars'))) {
			return $this->module->error('err_api_no_avatars');
		}
	}
}
