<?php

$lang = array(

	# Default GB Name
	'default_title' => 'Il Guestbook di'.GWF_SITENAME,
	'default_descr' => 'Il Guestbook di '.GWF_SITENAME,

	# Errors
	'err_gb' => 'Il guestbook non esiste.',
	'err_gbm' => 'La voce del guestbook non esiste.',
	'err_gbm_username' => 'Il nome utente è invalido. Deve avere una lunghezza compresa tra %s e %s caratteri.',
	'err_gbm_message' => 'Il messaggio inserito non è valido. Deve avere una lunghezza compresa tra %s e %s caratteri.',
	'err_gbm_url' => 'Il sito web inserito non è raggiungibile o l\'URL è invalido.',
	'err_gbm_email' => 'L\'E-Mail inserita non è valida.',
	'err_gb_title' => 'Il titolo è invalido. Deve avere una lunghezza compresa tra %s e %s caratteri.',
	'err_gb_descr' => 'La descrizione è invalida. Deve avere una lunghezza compresa tra %s e %s caratteri.',

	# Messages
	'msg_signed' => 'Hai firmato il Guestbook con successo.',
	'msg_signed_mod' => 'Hai firmato il Guestbook, ma la tua voce deve essere approvata prima di essere visualizzata.',
	'msg_gb_edited' => 'Il Guestbook è stato modificato.',
	'msg_gbm_edited' => 'La voce del Guestbook è stata modificata.',
	'msg_gbm_mod_0' => 'La voce del Guestbook sarà visualizzata.',
	'msg_gbm_mod_1' => 'La voce del Guestbook è stata inserita nella coda di moderazione.',
	'msg_gbm_pub_0' => 'La voce del Guestbook è stata resa invisibile agli utenti non registrati.',
	'msg_gbm_pub_1' => 'La voce del Guestbook è stata resa visibile agli utenti non registrati.',

	# Headers
	'th_gbm_username' => 'Il suo nome utente',
	'th_gbm_email' => 'Il suo indirizzo E-Mail',
	'th_gbm_url' => 'Il suo sito Web',
	'th_gbm_message' => 'Il suo messaggio',
	'th_opt_public' => 'Rendere il messaggio pubblico?',
	'th_opt_toggle' => 'Consenti la modifica della visibilità?',
	'th_gb_title' => 'Titolo',
	'th_gb_locked' => 'Bloccato?',
	'th_gb_moderated' => 'Moderato?',
	'th_gb_guest_view' => 'Visibile a tutti?',
	'th_gb_guest_sign' => 'Utilizzabile degli utenti non registrati?',
	'th_gb_bbcode' => 'Permetti BBCode?',
	'th_gb_urls' => 'Permetti URL Utente?',
	'th_gb_smiles' => 'Permetti Smileys?',
	'th_gb_emails' => 'Permetti E-Mail Utente?',
	'th_gb_descr' => 'Descrizione',
	'th_gb_nesting' => 'Permetti nidificazione?',

	# Tooltips
	'tt_gbm_email' => 'L\'E-Mail sarà mostrata a tutti, nel caso decidesse di specificarne una nel profilo!',
	'tt_gb_locked' => 'Seleziona per disabilitare il Guestbook temporaneamente.',

	# Titles
	'ft_sign' => 'Firma %s',
	'ft_edit_gb' => 'Modifica il Guestbook',
	'ft_edit_entry' => 'Modifica una voce del Guestbook',

	# Buttons
	'btn_sign' => 'Firma %s',
	'btn_edit_gb' => 'Modifica Guestbook',
	'btn_edit_entry' => 'Modifica voce',
	'btn_public_hide' => 'Nascondi questa voce dagli utenti non registrati',
	'btn_public_show' => 'Mostra questa voce a tutti',
	'btn_moderate_no' => 'Autorizza la visualizzazione di questa voce',
	'btn_moderate_yes' => 'Nascondi questa voce e inseriscila nella coda di moderazione',
	'btn_replyto' => 'Replica a %s',

	# Admin Config
	'cfg_gb_allow_email' => 'Permetti e mostra le E-Mail?',
	'cfg_gb_allow_url' => 'Permetti e mostra i siti Web?',
	'cfg_gb_allow_guest' => 'Permetti voci da utenti non registrati?',
	'cfg_gb_captcha' => 'Captcha per utenti non registrati?',
	'cfg_gb_ipp' => 'Voci per pagina',
	'cfg_gb_max_msglen' => 'Lunghezza massima del messaggio',
	'cfg_gb_max_ulen' => 'Lunghezza massima nome utente non registrato',
	'cfg_gb_max_titlelen' => 'Lunghezza massima titolo Guestbook',
	'cfg_gb_max_descrlen' => 'Lunghezza massima descrizione Guestbook',

	# v2.01 fixes and mail
	'cfg_gb_level' => 'Livello minimo per la creazione del Guestbook',
	'mails_signed' => GWF_SITENAME.': Firma sul Guestbook',
	'mailb_signed' => 
		'Caro %s'.PHP_EOL.
		PHP_EOL.
		'Il guestbook di %s è stato firmato da %s (%s)'.PHP_EOL.
		'Messaggio:'.PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'Può mostrare automaticamente questa voce visitando il link:'.PHP_EOL.
		'%s'.PHP_EOL,
		
	# v2.02 Mail on Sign
	'th_mailonsign' => 'E-Mail necesssaria per firmare?',
	'mails2_signed' => GWF_SITENAME.':  Firma sul Guestbook',
	'mailb2_signed' => 
		'Caro %s'.PHP_EOL.
		PHP_EOL.
		'Il guestbook di %s è stato firmato da %s (%s)'.PHP_EOL.
		'Messaggio:'.PHP_EOL.
		'%s'.PHP_EOL,
		
	# v2.03 (Delete entry)
	'btn_del_entry' => 'Cancella voce',
	'msg_e_deleted' => 'La voce è stata cancellata.',

	# v2.04 (finish)
	'cfg_gb_menu' => 'Mostra nel menù?',
	'cfg_gb_nesting' => 'Autorizza nidificazione?',
	'cfg_gb_submenu' => 'Mostra nel sotto-menù?',
	'err_locked' => 'Questo Guestbook è temporaneamente bloccato.',
	
	# v2.05 (showmail)
	'th_opt_showmail' => 'Mostra E-Mail al pubblico?',
);

?>