<?php
$lang = array(
	# Form Titles
	'ft_add_ban' => 'Ban / Warn a user',
	'fi_add_ban' => 'Give a user a warning or ban. To give a ban, checkmark the Ban checkbox, also choose either permanent or end-date.',

	# Table Headers
	'th_user_name' => 'Username',		
	'th_ban_msg' => 'Message',
	'th_ban_ends' => 'Ends',
	'th_ban_perm' => 'Permanent',
	'th_ban_type' => 'Type',
	'th_ban_type2' => 'Ban',
	'th_ban_date' => 'Date',

	# Tooltips
	'tt_ban_ends' => 'Only needed for Temp Ban. You have to check the ban checkbox.',
	'tt_ban_perm' => 'Permanent option ignores End-Date',
	'tt_ban_type' => 'Warning or Check for Ban',

	# Buttons
	'btn_add_ban' => 'Warn/Ban',

	# Errors
	'err_perm_or_date' => 'Choose either an end date, or checkmark permanent ban.',
	'err_msg' => 'You forgot the message.',
	'err_ends' => 'The end date is invalid.',

	# Messages
	'msg_permbanned' => 'The user %1% got permanently banned.',
	'msg_tempbanned' => 'The user %1% got banned until %2%.',
	'msg_warned' => 'The user %1% got warned.',
	'msg_marked_read' => 'The message has been marked as read.',
	
	# Info
	'info_warning' => 'You got a warning!<br/>%1%<br/><a href="%2%">Click here to mark it read</a>.',
	'info_tempban' => 'You got banned until %1%!<br/>%2%',
	'info_permban' => 'You are permanently banned:<br/>%1%',

	# Admin Config
	'cfg_ban_ipp' => 'Items Per Page',

	# Bits
	'type_1' => 'Ban',
	'type_2' => 'Warning',
);
?>