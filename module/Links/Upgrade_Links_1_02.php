<?php
function Upgrade_Links_1_02(Module_Links $module)
{
	echo GWF_HTML::message('Links', 'Link Up/Down Checker');
	
	$db = gdo_db();
	$table = GWF_TABLE_PREFIX.'links';
	
	$query = "ALTER TABLE $table ADD COLUMN link_lastcheck INT(11) UNSIGNED NOT NULL DEFAULT 0";
	if (false === $db->queryWrite($query)) {
		return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
	}
	
	$query = "ALTER TABLE $table ADD COLUMN link_downcount INT(11) UNSIGNED NOT NULL DEFAULT 0";
	if (false === $db->queryWrite($query)) {
		return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
	}
	
	return '';
}
?>