<?php
function Upgrade_WeChall_1_01(Module_WeChall $module)
{
	var_dump('TRIGGERED Upgrade_WeChall_1_01 (chall_token)');
	$db = gdo_db();
	$challs = GWF_TABLE_PREFIX.'wc_chall';
	$query = "ALTER TABLE $challs ADD COLUMN chall_token CHAR(8) CHARACTER SET ascii COLLATE ascii_bin NOT NULL DEFAULT ''";
	if (false === ($db->queryWrite($query))) {
		return GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
	}
	
	$query = "SELECT chall_id FROM $challs";
	if (false === ($result = $db->queryRead($query))) {
		return GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
	}
	while (false !== ($row = $db->fetchRow($result)))
	{
		$id = $row[0];
		$token = Common::randomKey(8);
		if (false === ($db->queryWrite("UPDATE $challs SET chall_token='$token' WHERE chall_id=$id"))) {
			return GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
		}
	}
	$db->free($result);
	
	return '';
}
?>