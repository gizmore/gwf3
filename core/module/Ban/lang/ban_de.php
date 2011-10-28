<?php
$lang = array(
	# Form Titles
	'ft_add_ban' => 'Benutzer bannen / verwarnen',
	'fi_add_ban' => 'Um den Benutzer zu bannen markieren sie die Ban Checkbox und wählen entweder Permanent oder ein End-Datum.',

	# Table Headers
	'th_user_name' => 'Nickname',		
	'th_ban_msg' => 'Nachricht',
	'th_ban_ends' => 'Endet am',
	'th_ban_perm' => 'Permanent ',
	'th_ban_type' => 'Typ',
	'th_ban_type2' => 'Bannen',
	'th_ban_date' => 'Datum',

	# Tooltips
	'tt_ban_ends' => 'Nur für einen temporären Ban. Sie müssen außerdem bei Ban ein Häkchen setzen.',
	'tt_ban_perm' => 'Die Permanent Option ignoriert das End-Datum',
	'tt_ban_type' => 'Warnung, oder ein Häkchen setzen für Ban',

	# Buttons
	'btn_add_ban' => 'Verwarnen / Bannen',

	# Errors
	'err_perm_or_date' => 'Wählen Sie entweder ein End-Datum oder setzen Sie ein Häkchen bei Permanent.',
	'err_msg' => 'Sie haben die Nachricht vergessen.',
	'err_ends' => 'Das End-Datum ist ungültig.',

	# Messages
	'msg_permbanned' => 'Der Benutzer %1$s wurde permanent gebannt.',
	'msg_tempbanned' => 'Der Benutzer %1$s wurde gebannt bis %2$s.',
	'msg_warned' => 'Der Benutzer %1$s wurde verwarnt.',
	'msg_marked_read' => 'Die Nachricht wurde als gelesen markiert.',
	
	# Info
	'info_warning' => 'Sie wurden verwarnt!<br/>%1$s<br/><a href="%2$s">Klicken Sie hier um die Nachricht als gelesen zu markieren</a>.',
	'info_tempban' => 'Ihr Benutzerkonto ist gesperrt bis %1$s!<br/>%2$s',
	'info_permban' => 'Ihr Benutzerkonto wurden permanent gesperrt:<br/>%1$s',

	# Admin Config
	'cfg_ban_ipp' => 'Einträge pro Seite',

	# Bits
	'type_1' => 'Ban ',
	'type_2' => 'Warnung',
);
?>
