<?php
function Upgrade_GWF_1_02(Module_GWF $module)
{
	var_dump('TRIGGERED Upgrade GWF1.02 (Supported Language Flag)');
	$db = gdo_db();
	# NEW: Module options
	$lang = GWF_TABLE_PREFIX.'language';
	$query = "ALTER TABLE $lang ADD COLUMN lang_options INT(11) UNSIGNED NOT NULL DEFAULT 0";
	if (false === $db->queryWrite($query)) {
		return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
	}
	return '';
}
?>