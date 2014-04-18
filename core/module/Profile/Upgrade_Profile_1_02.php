<?php
function Upgrade_Profile_1_02(Module_Profile $module)
{
	$db = gdo_db();
	$profile = GWF_TABLE_PREFIX.'profile';
	$query = "ALTER TABLE $profile ADD COLUMN prof_poi_score INT(11) DEFAULT 0";
	if (false === $db->queryWrite($query))
	{
		return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
	}
	echo GWF_HTML::message('Profile', '[+] Profile POI Score', false);
	return '';
}
