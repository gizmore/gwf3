<?php
function Upgrade_Profile_1_01(Module_Profile $module)
{
	$db = gdo_db();
	$profile = GWF_TABLE_PREFIX.'profile';
	$query = "ALTER TABLE $profile ADD COLUMN prof_irc VARCHAR(255) CHARACTER SET ascii COLLATE ascii_bin";
	if (false === $db->queryWrite($query)) {
		return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
	}

	echo GWF_HTML::message('Profile', '[+] Profile IRC', false);
	
	return '';
}
?>