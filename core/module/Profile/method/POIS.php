<?php
final class Profile_POIS extends GWF_Method
{
	public function execute()
	{
		GWF_Website::plaintext();
		GWF3::setConfig('store_last_url', false);

		if (!$this->module->canReadPOIs())
		{
			return $this->module->ajaxErr('err_poi_read_perm');
		}
		
		$minlat = $this->module->lat('minlat');
		$maxlat = $this->module->lat('maxlat');
		$minlon = $this->module->lon('minlon');
		$maxlon = $this->module->lon('maxlon');
		
		$where_perms = GWF_ProfilePOI::wherePermissions();
		$where_place = GWF_ProfilePOI::whereLocations($minlat, $maxlat, $minlon, $maxlon);
		$where = "($where_perms) AND ($where_place)";

		$joins = array('users', 'profiles', 'whitelist');
		
		$result = GDO::table('GWF_ProfilePOI')->selectAll('pp_id, pp_uid, user_name, pp_lat, pp_lon, pp_descr', $where, '', $joins);
		die(json_encode($result));
	}
}
