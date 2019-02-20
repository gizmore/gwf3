<?php
function Upgrade_Forum_1_03(Module_Forum $module)
{
	var_dump('TRIGGERED Upgrade_Forum_1_03');
	var_dump('New threads are forced being unread, when added to group.');
	
	$db = gdo_db();
	$threads = GWF_TABLE_PREFIX.'forumthread';
	$query = "ALTER TABLE $threads ADD COLUMN thread_force_unread TEXT CHARACTER SET ascii COLLATE ascii_bin";
	if (false === ($db->queryWrite($query))) {
		return GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
	}
	
	$query = "UPDATE $threads SET thread_force_unread=':'";
	if (false === ($db->queryWrite($query))) {
		return GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
	}
	
	return '';
}
?>