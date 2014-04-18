<?php
final class Profile_POISAdd extends GWF_Method
{
	public function execute()
	{
		GWF_Website::plaintext();
		GWF3::setConfig('store_last_url', false);
		
		$lat = $this->module->lat();
		$lon = $this->module->lon();
		$descr = trim(Common::getGetString('pp_descr'));
		$descr = $descr === '' ? null : $descr;
		$id = Common::getGetInt('pp_id', 0);
		$user = GWF_User::getStaticOrGuest();
		$uid = $user->getID();
		if (!GWF_ProfilePOI::changeAllowed($id, $uid))
		{
			$this->module->ajaxError('Permission error!');
		}
		
		$count = $id === 0 ? GWF_ProfilePOI::getPOICount($uid) : 0;
		$max_pois = $this->module->cfgAllowedPOIs();
		if ($count >= $max_pois)
		{
			$this->module->ajaxErr('err_poi_exceed');
		}
		$poi = new GWF_ProfilePOI(array(
			'pp_id' => $id,
			'pp_uid' => $uid,
			'pp_lat' => $lat,
			'pp_lon' => $lon,
			'pp_descr' => $descr,
		));
		$poi->replace();
		$data = $poi->getGDOData();
		$data['user_name'] = $user->getVar('user_name');
		die(json_encode($data));
	}
}
