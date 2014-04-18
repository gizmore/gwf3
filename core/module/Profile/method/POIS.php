<?php
final class Profile_POIS extends GWF_Method
{
	public function execute()
	{
		GWF3::setConfig('store_last_url', false);
		GWF_Website::plaintext();
		if (!$this->module->canReadPOIs())
		{
			return $this->module->ajaxError($this->module->lang('err_poi_read_perm'));
		}
		$minlat = $this->module->lat('minlat');
		$maxlat = $this->module->lat('maxlat');
		$minlon = $this->module->lon('minlon');
		$maxlon = $this->module->lon('maxlon');
		$user = GWF_User::getStaticOrGuest();
		$uid = $user->getID();
		$score = $user->getLevel();
		$white = GWF_TABLE_PREFIX.'profile_poi_whitelist';
		$where = "((pp_uid=0) OR (user_options&0x02=0)) AND ( (pp_uid=0) OR (pp_uid=$uid) OR (prof_options&0x40 AND (SELECT 1 FROM $white WHERE pw_uida=pp_uid AND pw_uidb=$uid)) OR (prof_options&0x40=0 AND prof_poi_score<=$score) ) AND (pp_lat BETWEEN $minlat AND $maxlat AND pp_lon BETWEEN $minlon AND $maxlon)";
		$result = GDO::table('GWF_ProfilePOI')->selectAll('pp_id, pp_uid, user_name, pp_lat, pp_lon, pp_descr', $where, '', array('users', 'profiles', 'whitelist'), -1, -1, GDO::ARRAY_A);
		die(json_encode($result));
	}
}
