<?php
function Upgrade_WeChall_1_02(Module_WeChall $module)
{
	var_dump('TRIGGERED Upgrade_WeChall_1_02 (csolve_time_taken, csolve_tries)');
	
	$db = gdo_db();
	$solved = GWF_TABLE_PREFIX.'wc_chall_solved';
	$query = "ALTER TABLE $solved ADD COLUMN csolve_time_taken INT(11) UNSIGNED NOT NULL DEFAULT 0";
	if (false === ($db->queryWrite($query))) {
		return GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
	}
	
	$query = "ALTER TABLE $solved ADD COLUMN csolve_tries INT(11) UNSIGNED NOT NULL DEFAULT 0";
	if (false === ($db->queryWrite($query))) {
		return GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
	}
	
	require_once 'module/WeChall/WC_ChallSolved.php';
	$table = GDO::table('WC_ChallSolved');
	
	if (false === ($result = $table->queryReadAll("csolve_date != ''"))) {
		return GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
	}
	
	$challs = GDO::table('WC_Challenge');
	$challcache = array();
	
	while (false !== ($row = $table->fetchObject($result)))
	{
		$solved = $row->getVar('csolve_date');
		$looked = $row->getVar('csolve_1st_look');
		
		$challid = $row->getVar('csolve_cid');
		if (!isset($challcache[$challid])) {
			$challcache[$challid] = $challs->selectVar('chall_date', "chall_id=$challid");
		}
		
		if ( (strcmp($looked, $solved) >= 0) || ($looked === $challcache[$challid]) ) {
			$time = 0;
		} else {
			$time = $row->calcTimeTaken($solved);
		}
		if (false === $row->saveVar('csolve_time_taken', $time)) {
			return GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
		}
	}
	$table->freeResult($result);
	
	return '';
}
?>