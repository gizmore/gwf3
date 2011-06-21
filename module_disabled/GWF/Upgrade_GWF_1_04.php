<?php
function Upgrade_GWF_1_04(Module_GWF $module)
{
	$db = gdo_db();
	$country = GWF_TABLE_PREFIX.'country'; 
	$query = "ALTER TABLE $country ADD COLUMN country_pop INT(11) UNSIGNED NOT NULL DEFAULT 0";
	if (false === ($db->queryWrite($query))) {
		return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
	}

	GWF_HTML::message('GWF', '[+] GWF 1.04 (country population)', true, true);
	
	return '';
}
?>