<?php
function Upgrade_WeChall_1_06(Module_WeChall $module)
{
	$db = gdo_db();
	$regat = GWF_TABLE_PREFIX.'wc_regat';
	$query = "ALTER TABLE $regat ADD COLUMN regat_challsolved INT(11) NOT NULL DEFAULT -1";
	if (false === ($db->queryWrite($query)))
	{
		return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
	}
}
?>