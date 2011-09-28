<?php
$table = GDO::table('GWF_PM');
$db = gdo_db();
$tmp_name = 'gwf23_tmp_pm'.$table->getTableName();
if (false === $db->renameTable($table->getTableName(), $tmp_name)) {
	return;
}

if (false === $table->createTable(true)) {
	return;
}

if (false === ($result = $db->queryRead("SELECT * FROM $tmp_name"))) {
	return;
}

while (false !== ($row = $db->fetchAssoc($result)))
{
	$o = (int)$row['pm_options'];
	
	# Sender
	$from_opts = $o&0x04; # smileys
//	$from_opts |= $o&0x01 ? GWF_PM::READ : 0; # other read
	$from_opts |= GWF_PM::READ; # I probably have read what i wrote :)
	$from_opts |= $o&0x10 ? GWF_PM::OWNER_DELETED : 0; # sender deleted
	$from_opts |= $o&0x20 ? GWF_PM::OTHER_DELETED : 0; # reciever deleted
//	var_dump($o);
//	var_dump($from_opts);
	$from = new GWF_PM(array(
		'pm_id' => '0',
		'pm_date' => $row['pm_date'],
		'pm_owner' => $row['pm_from'],
		'pm_folder' => $row['pm_from_folder'],
		'pm_parent' => $row['pm_in_reply'],
	
		'pm_to' => $row['pm_to'],
		'pm_from' => $row['pm_from'],
		'pm_otherid' => 0,
 
		'pm_title' => $row['pm_title'],
		'pm_message' => $row['pm_message'],
		
		'pm_options' => $from_opts,
	));
	$from->insert();
	
	$to_opts = 0;
	$to_opts |= $o&0x01 ? GWF_PM::READ : 0; # meme read
	$to_opts |= $o&0x04; # smileys
	$to_opts |= $o&0x20 ? GWF_PM::OWNER_DELETED : 0; # sender deleted
	$to_opts |= $o&0x10 ? GWF_PM::OTHER_DELETED : 0; # reciever deleted
	$to = new GWF_PM(array(
		'pm_id' => '0',
		'pm_date' => $row['pm_date'],
		'pm_owner' => $row['pm_to'],
		'pm_folder' => $row['pm_to_folder'],
		'pm_parent' => $row['pm_in_reply'],
	
		'pm_to' => $row['pm_to'],
		'pm_from' => $row['pm_from'],
		'pm_otherid' => $from->getID(),

		'pm_title' => $row['pm_title'],
		'pm_message' => $row['pm_message'],
		
		'pm_options' => $to_opts,
	));
	$to->insert();
	
	$from->saveVar('pm_otherid', $to->getID());
}

$db->free($result);

$db->dropTable($tmp_name);
?>