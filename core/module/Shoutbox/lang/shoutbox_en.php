<?php
$lang = array(
	# Box
	'box_title' => GWF_SITENAME.' Shoutbox',

	# History
	'pt_history' => GWF_SITENAME.' Shoutbox History (Page %s / %s)',
	'pi_history' => 'The '.GWF_SITENAME.' Shoutbox',
	'mt_history' => GWF_SITENAME.', Shoutbox, History',
	'md_history' => 'The '.GWF_SITENAME.' shoutbox is for small messages that are not worth a forum thread.',

	# Errors
	'err_flood_time' => 'Please wait %s before you shout again.',
	'err_flood_limit' => 'You have exceeded your limit of %s messages per day.',
	'err_message' => 'Your message has to be between %s to %s characters long.',
	
	# Messages
	'msg_shouted' => 'Your shoutbox entry has been added.<br/>Go back to <a href="%s">%s</a>.',
	'msg_deleted' => 'One message has been deleted.',

	# Table Heads
	'th_shout_date' => 'Date',
	'th_shout_uname' => 'Username',
	'th_shout_message' => 'Message',

	# Buttons
	'btn_delete' => 'Delete',
	'btn_shout' => 'Shout!',

	# Admin config
	'cfg_sb_guests' => 'Allow guest posts',	
	'cfg_sb_ipp' => 'Items per history',
	'cfg_sb_ippbox' => 'Items per inline box',
	'cfg_sb_maxlen' => 'Max. message length',
	'cfg_sb_maxdayg' => 'Max messages per day for guests',
	'cfg_sb_maxdayu' => 'Max messages per day for members',
	'cfg_sb_timeout' => 'Timeout between 2 messages',

	# v1.01 (EMail moderation)
	'cfg_sb_email_moderation' => 'EMail moderation',
	'emod_subj' => GWF_SITENAME.': New shoutbox entry',
	'emod_body' =>
		'Dear staff,'.PHP_EOL.
		''.PHP_EOL.
		'There is a new entry in the shoutbox.'.PHP_EOL.
		''.PHP_EOL.
		'From: %s'.PHP_EOL.
		'%s'.PHP_EOL.
		''.PHP_EOL.
		'You can delete it via %s'.PHP_EOL.
		''.PHP_EOL.
		'Regards'.PHP_EOL.
		'The GWF3 script',

);
?>