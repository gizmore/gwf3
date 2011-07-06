<?php
function Upgrade_PM_1_04(Module_PM $module)
{
	echo GWF_HTML::message('PM', 'Triggering Upgrade_PM_1_04');
	echo GWF_HTML::message('PM', 'PM ignore reasons');
	
	$db = gdo_db();
	$pmi = GWF_TABLE_PREFIX.'pm_ignore';
	$query = "ALTER TABLE $pmi ADD COLUMN pmi_reason TEXT CHARACTER SET utf8 COLLATE utf8_general_ci";
	if (false === ($db->queryWrite($query))) {
		return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
	}
	return '';
}
?>