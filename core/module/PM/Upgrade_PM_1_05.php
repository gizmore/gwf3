<?php
function Upgrade_PM_1_05(Module_PM $module)
{
	echo GWF_HTML::message('PM', 'Triggering Upgrade_PM_1_05');
	echo GWF_HTML::message('PM', 'PMO_user_level');
	
	$db = gdo_db();
	$pmo = GWF_TABLE_PREFIX.'pm_options';
	$query = "ALTER TABLE $pmo ADD COLUMN pmo_level INT(11) UNSIGNED DEFAULT 0";
	if (false === ($db->queryWrite($query)))
	{
		return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
	}
	return '';
}
