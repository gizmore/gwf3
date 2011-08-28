<?php
$lang = array(
	# Box
	'box_title' => GWF_SITENAME.'  Shoutbox',

	# History
	'pt_history' => GWF_SITENAME.' Shoutbox Aufzeichnung (Seite %1% / %2%)',
	'pi_history' => 'Die '.GWF_SITENAME.' Shoutbox',
	'mt_history' => GWF_SITENAME.', Shoutbox, Aufzeichnung, Vergangenheit',
	'md_history' => 'Die '.GWF_SITENAME.' Shoutbox ist für Kurznachrichten die keine Diskussion benötigt.',

	# Errors
	'err_flood_time' => 'Bitte warte %1% bevor du erneut eine Nachricht absendest.',
	'err_flood_limit' => 'Du hast dein Limit von %1% Nachrichten pro Tag erreicht.',
	'err_message' => 'Deine Nachricht muss zwischen %1% und %2% Zeichen lang sein.',
	
	# Messages
	'msg_shouted' => 'Deine Nachricht wurde in die Shoutbox eingetragen.<br/>Zurück zu <a href="%1%">%1%</a>.',
	'msg_deleted' => 'Eine Nachricht wurde gelöscht.',

	# Table Heads
	'th_shout_date' => 'Datum',
	'th_shout_uname' => 'Benutzer',
	'th_shout_message' => 'Nachricht',

	# Buttons
	'btn_delete' => 'Löschen',
	'btn_shout' => 'Shouten!',

	# Admin config
	'cfg_sb_guests' => 'Gast Nachrichten erlauben',	
	'cfg_sb_ipp' => 'Nachrichten pro History Seite',
	'cfg_sb_ippbox' => 'Nachrichten pro Inline-Box',
	'cfg_sb_maxlen' => 'Maximale Länge der Nachrichten',
	'cfg_sb_maxdayg' => 'Maximale Anzahl der Nachrichten für Gäste',
	'cfg_sb_maxdayu' => 'Maximale Anzahl der Nachrichten für Mitglieder',
	'cfg_sb_timeout' => 'Auszeit zwischen zwei Nachrichten',

	# v1.01 (EMail moderation)
	'cfg_sb_email_moderation' => 'EMail moderation',
	'emod_subj' => GWF_SITENAME.': New shoutbox entry',
	'emod_body' =>
		'Dear staff,'.PHP_EOL.
		''.PHP_EOL.
		'There is a new entry in the shoutbox.'.PHP_EOL.
		''.PHP_EOL.
		'From: %1%'.PHP_EOL.
		'%2%'.PHP_EOL.
		''.PHP_EOL.
		'You can delete it via %3%'.PHP_EOL.
		''.PHP_EOL.
		'Regards'.PHP_EOL.
		'The GWF3 script',
);
?>