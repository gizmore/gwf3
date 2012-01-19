<?php
$lang = array(
	# Box
	'box_title' => 'Shoutbox di '.GWF_SITENAME,

	# History
	'pt_history' => 'Cronologia della Shoutbox di '.GWF_SITENAME.' (Pagina %s / %s)',
	'pi_history' => 'La Shoutbox di '.GWF_SITENAME,
	'mt_history' => GWF_SITENAME.', Shoutbox, History',
	'md_history' => 'La Shoutbox di '.GWF_SITENAME.' è per brevi messaggi che non meritano un thread nel forum.',

	# Errors
	'err_flood_time' => 'La preghiamo di aspettare %s prima di inviare un nuovo messaggio.',
	'err_flood_limit' => 'Ha esaurito il limite di %s messagio al giorno.',
	'err_message' => 'Il messaggio deve avere una lunghezza compresa tra %s e %s caratteri.',
	
	# Messages
	'msg_shouted' => 'Il tuo messaggio è stato pubblicato.<br/>Clicca qui per tornare a <a href="%s">%s</a>.',
	'msg_deleted' => 'Un messaggio è stato cancellato.',

	# Table Heads
	'th_shout_date' => 'Data',
	'th_shout_uname' => 'Nome utente',
	'th_shout_message' => 'Messaggio',

	# Buttons
	'btn_delete' => 'Cancella',
	'btn_shout' => 'Urla!',

	# Admin config
	'cfg_sb_guests' => 'Permetti i post degli utenti non registrati',	
	'cfg_sb_ipp' => 'Elementi nella Cronologia',
	'cfg_sb_ippbox' => 'Elementi per riga',
	'cfg_sb_maxlen' => 'Lunghezza massima messaggio',
	'cfg_sb_maxdayg' => 'Numero massimo di messaggi al giorno per utenti non registrati',
	'cfg_sb_maxdayu' => 'Numero massimo di messaggi al giorno per utenti registrati',
	'cfg_sb_timeout' => 'Intervallo tra due messaggi',

	# v1.01 (EMail moderation)
	'cfg_sb_email_moderation' => 'Moderazione E-Mail',
	'emod_subj' => GWF_SITENAME.': Nuova voce nello Shoutbox',
	'emod_body' =>
		'Cari membri dello staff,'.PHP_EOL.
		''.PHP_EOL.
		'E\' stato pubblicato un nuovo messaggio nella Shoutbox.'.PHP_EOL.
		''.PHP_EOL.
		'Da: %s'.PHP_EOL.
		'%s'.PHP_EOL.
		''.PHP_EOL.
		'Puoi cancellarlo tramite %s'.PHP_EOL.
		''.PHP_EOL.
		'Cordiali saluti'.PHP_EOL.
		'Gli script di '.GWF_SITENAME,

);
?>