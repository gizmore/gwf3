<?php
function Upgrade_Account_1_03(Module_Account $module)
{
	var_dump('TRIGGERED Upgrade_Account_1_03');
	var_dump('The token entropy has been raised from 8 chars to 24.');
	
	$db = gdo_db();
	$accc = GWF_TABLE_PREFIX.'accchange';
	$query = "ALTER TABLE $accc MODIFY COLUMN token VARCHAR(24) CHARACTER SET ascii COLLATE ascii_bin";
	if (false === ($db->queryWrite($query)))
	{
		return GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
	}
	return '';
}
?>