<?php
function Upgrade_PM_1_01(Module_PM $module)
{
	echo GWF_HTML::message('PM', 'TRIGGERED Upgrade_PM_1_01');
	echo GWF_HTML::message('PM', 'It is now possible to navigate prev/next for pms');
	
	$db = gdo_db();
	$pms = GWF_TABLE_PREFIX.'pm';
	$query = "ALTER TABLE $pms ADD COLUMN pm_in_reply INT(11) UNSIGNED NOT NULL DEFAULT 0";
	if (false === ($db->queryWrite($query))) {
		return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
	}
	
	$query = "ALTER TABLE $pms ADD INDEX pm_in_reply(pm_in_reply)";
	if (false === ($db->queryWrite($query))) {
		return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
	}

	return '';
}
?>