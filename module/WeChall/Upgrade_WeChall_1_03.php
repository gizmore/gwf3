<?php
function Upgrade_WeChall_1_03(Module_WeChall $module)
{
	$db = gdo_db();
	$sites = GWF_TABLE_PREFIX.'wc_site';
	$query = "ALTER TABLE $sites ADD COLUMN site_spc INT(11) UNSIGNED NOT NULL DEFAULT 25";
	if (false === ($db->queryWrite($query))) {
		return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
	}
	
	$query = "ALTER TABLE $sites ADD COLUMN site_powarg INT(11) UNSIGNED NOT NULL DEFAULT 100";
	if (false === ($db->queryWrite($query))) {
		return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
	}
	
	GWF_HTML::message('WC', '[+] Advanced Scoring by Caesum');
	return '';
}
?>