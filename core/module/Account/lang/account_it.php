<?php
$lang = array(
	# Titles
	'form_title' => 'Impostazioni account',
	'chmail_title' => 'Inserisca la sua nuova E-Mail',

	# Headers
	'th_username' => 'Nome utente',
	'th_email' => 'Indirizzo E-Mail di contatto',
	'th_demo' => 'Impostazioni demografiche - Può cambiarle una volta ogni %s.',
	'th_countryid' => 'Nazione',
	'th_langid' => 'Lingua primaria',
	'th_langid2' => 'Lingua secondaria',
	'th_birthdate' => 'Data di nascita',
	'th_gender' => 'Sesso',
	'th_flags' => 'Opzioni - Modificabili al volo',
	'th_adult' => 'Vuole vedere i contenuti per adulti?',
	'th_online' => 'Vuole nascondere la sua presenza online?',
	'th_show_email' => 'Vuole rendere pubblica la tua E-Mail?',
	'th_avatar' => 'Avatar personale',
	'th_approvemail' => '<b>Il suo indirizzo E-Mail <br/>non è stata approvato</b>',
	'th_email_new' => 'Il suo nuovo indirizzo E-Mail',
	'th_email_re' => 'Ridigiti l\'indirizzo E-Mail',

	# Buttons
	'btn_submit' => 'Salva i cambiamenti',
	'btn_approvemail' => 'Conferma indirizzo E-Mail',
	'btn_changemail' => 'Imposta il nuovo indirizzo E-Mail',
	'btn_drop_avatar' => 'Cancella Avatar',

	# Errors
	'err_token' => 'Token invalido.',
	'err_email_retype' => 'Deve ridigitare l\'indirizzo E-Mail correttamente.',
	'err_delete_avatar' => 'Si è verificato un errore durante la cancellazione del tuo Avatar.',
	'err_no_mail_to_approve' => 'Non ha nessuno indirizzo E-Mail da approvare.',
	'err_already_approved' => 'Il suo indirizzo E-mail è già stato approvato.',
	'err_no_image' => 'Il file caricato non è un immagine o è troppo piccolo.',
	'err_demo_wait' => 'Ha già cambiato le sue impostazioni demografiche recentemente. La preghiamo di aspettare %s.',
	'err_birthdate' => 'La sua data di nascita sembra invalida.',

	# Messages
	'msg_mail_changed' => 'La sua E-Mail di contatto è stato cambiato in <b>%s</b>.',
	'msg_deleted_avatar' => 'Il suo Avatar è stato cancellato.',
	'msg_avatar_saved' => 'Il suo nuovo Avatar è stato salvato.',
	'msg_demo_changed' => 'Le sue impostazioni demografiche sono state modificate.',
	'msg_mail_sent' => 'Le è stata inviata una E-Mail per confermare i cambiamenti. La preghiamo di seguire le informazioni in essa contetute.',
	'msg_show_email_on' => 'Il suo indirizzo E-Mail è ora visibile a tutti.',
	'msg_show_email_off' => 'Il suo indirizzo E-Mail è ora nascosto.',
	'msg_adult_on' => 'Ora può visualizzare i contenuti per adulti.',
	'msg_adult_off' => 'D\'ora in avanti non visualizzerà più i contenuti per adulti.',
	'msg_online_on' => 'D\'ora in avanti non sarà visualizzato tra gli utenti connessi.',
	'msg_online_off' => 'D\'ora in avanti sarà visualizzato tra gli utenti connessi.',

	# Admin Config
	'cfg_avatar_max_x' => 'Larghezza massima dell\'Avatar',
	'cfg_avatar_max_y' => 'Altezza massima dell\'Avatar',
	'cfg_avatar_min_x' => 'Larghezza minima dell\'Avatar',
	'cfg_avatar_min_y' => 'Altezza minima dell\'Avatar',
	'cfg_adult_age' => 'Età minima per i contenuti per adulti',
	'cfg_demo_changetime' => 'Pausa tra cambi demografici',
	'cfg_mail_sender' => 'Mittente E-Mail per cambio impostazioni demografiche',
	'cfg_show_adult' => 'Il sito ha materiale per adulti?',
	'cfg_show_gender' => 'Mostra menù per selezionare il sesso?',
	'cfg_use_email' => 'Richiedi un E-Mail per fare cambiamenti all\'account?',
	'cfg_show_avatar' => 'Mostra form per caricare un Avatar?',
	'cfg_show_checkboxes' =>'Mostra le checkbox',
	############################
	# --- EMAIL BELOW HERE --- #
	# CHANGE MAIL A
	'chmaila_subj' => GWF_SITENAME.': Modifica indirizzo E-Mail',
	'chmaila_body' =>
	'Caro %s,'.PHP_EOL.
	PHP_EOL.
	'Lei ha richiesto di cambiare l\'indirizzo E-Mail del suo account su '.GWF_SITENAME.'.'.PHP_EOL.
	'Per fare ciò, visiti il link sottostante.'.PHP_EOL.
	'Nel caso in cui non avesse richiesto questo cambiamento, può ignorare questa E-Mail e/o avvertirci dell\'accaduto.'.PHP_EOL.
	PHP_EOL.
	'%s'.PHP_EOL.
	PHP_EOL.
	'Cordiali saluti'.PHP_EOL.
	'Il team di '.GWF_SITENAME,

	# CHANGE MAIL B
	'chmailb_subj' => GWF_SITENAME.': Confermi la sua E-Mail',
	'chmailb_body' =>
	'Caro %s,'.PHP_EOL.
	PHP_EOL.
	'Per poter utilizzare questo indirizzo E-Mail come suo indirizzo E-Mail di contatto deve confermarlo, visitando il link sottostante:'.PHP_EOL.
	'%s'.PHP_EOL.
	PHP_EOL.
	'Cordiali saluti'.PHP_EOL.
	'Il team di '.GWF_SITENAME,

	# CHANGE DEMO
	'chdemo_subj' => GWF_SITENAME.': Cambiamento delle impostazioni demografiche',
	'chdemo_body' =>
	'Caro %s'.PHP_EOL.
	PHP_EOL.
	'Lei ha richiesto di reimpostare le sue impostazioni demografiche.'.PHP_EOL.
	'Può farlo solo una volta ogni %s, per cui si assicuri che le informazioni siano corrette prima di continuare.'.PHP_EOL.
	PHP_EOL.
	'Sesso: %s'.PHP_EOL.
	'Nazione: %s'.PHP_EOL.
	'Lingua primaria: %s'.PHP_EOL.
	'Lingua secondaria: %s'.PHP_EOL.
	'Data di nascita: %s'.PHP_EOL.
	PHP_EOL.
	'Se vuole mantenere queste impostazioni, visiti il link sottostante:'.PHP_EOL.
	'%s'.
	PHP_EOL.
	'Cordiali saluti'.PHP_EOL.
	'Il team di '.GWF_SITENAME,

	# New Flags
	'th_allow_email' => 'Autorizza gli altri utenti ad inviarti E-Mail',
	'msg_allow_email_on' => 'Gli altri utenti possono ora inviarti delle E-Mail (il tuo indirizzo E-Mail resterà comunque nascosto).',
	'msg_allow_email_off' => 'Contatto tramite E-mail disattivato.',

	'th_show_bday' => 'Mostra il suo compleanno',
	'msg_show_bday_on' => 'Il suo compleanno sarà annunciato agli utenti che fanno uso di tale funzione.',
	'msg_show_bday_off' => 'Il suo compleanno non sarà reso pubblico.',

	'th_show_obday' => 'Mostra i compleanni degli altri utenti',
	'msg_show_obday_on' => 'D\'ora in avanti vedrà i compleanni degli altri utenti.',
	'msg_show_obday_off' => 'D\'ora in avanti non verrà notificato dei compleanni degli altri utenti.',

	# v2.02 Account Deletion
	'pt_accrm' => 'Cancella account',
	'mt_accrm' => 'Cancelli il suo account da '.GWF_SITENAME,
	'pi_accrm' =>
	'Sembra che lei voglia cancellare il suo account da '.GWF_SITENAME.'.<br/>'.
	'Ci dispiace che abbia deciso ciò, ma sappia che il suo account non verrà cancellato, sarà solo disabilitato.<br/>'.
	'Tutti i link a questo nome utente, al profilo, etc... diventeranno inutilizzabili o verranno sostituiti con account di default. Questa operazione è irreversibile.<br/>'.
	'Prima di procedere con la cancellazione del suo account, può lasciarci una nota con le ragioni che l\'hanno portata a cancellare il suo account.<br/>',
	'th_accrm_note' => 'Nota',
	'btn_accrm' => 'Cancella account',
	'msg_accrm' => 'Il suo account è stato contrassegnato come cancellato e tutti i riferimenti ad esso sono stati eliminati.<br/>Siete stato disconnesso.',
	'ms_accrm' => GWF_SITENAME.': %s cancellazione account',
	'mb_accrm' =>
	'Cari membri dello Staff'.PHP_EOL.
	''.PHP_EOL.
	'L\'utente %s ha appena cancellato il suo account e lasciato questa nota (può essere vuota):'.PHP_EOL.PHP_EOL.
	'%s',

	# v2.03 Email Options
	'th_email_fmt' => 'Formato E-Mail preferito',
	'email_fmt_text' => 'Testo',
	'email_fmt_html' => 'HTML semplice',
	'err_email_fmt' => 'Seleziona un formato E-Mail valido.',
	'msg_email_fmt_0' => 'D\'ora in avanti riceverà E-Mails in formato HTML.',
	'msg_email_fmt_4096' => 'D\'ora in avanti riceverà E-Mails testuali.',
	'ft_gpg' => 'Imposta crittature PGP/GPG ',
	'th_gpg_key' => 'Carichi la sua chiave pubblica',
	'th_gpg_key2' => 'Oppure la copi nell\'area di testo sottostante',
	'tt_gpg_key' => 'Quando avrà impostato la sua chiave PGP tutte le E-Mail inviatele degli scripts del sito verranno crittate con la sua chiave pubblica',
	'tt_gpg_key2' => 'Può copiare la chiave pubblica qui oppure caricare un file contente la chiave pubblica.',
	'btn_setup_gpg' => 'Carica chiave',
	'btn_remove_gpg' => 'Rimuovi chiave',
	'err_gpg_setup' => 'Può copiare la chiave pubblica qui oppure caricare un file contente la chiave pubblica: non entrambe.',
	'err_gpg_key' => 'La sua chiave pubblica sembra invalida.',
	'err_gpg_token' => 'Il suo GPG Fingerprint Token non corrisponde ai dati in nostro possesso.',
	'err_no_gpg_key' => 'L\'utente %s non ha ancora caricato la sua chiave pubblica.',
	'err_no_mail' => 'Lei non ha un indirizzo di contatto approvato.',
	'err_gpg_del' => 'Lei non ha una chiave GPG da rimuovere.',
	'err_gpg_fine' => 'Lei ha già una chiave GPG. La preghiamo di cancellarla prima di caricarne un altra.',
	'msg_gpg_del' => 'La sua chiave GPG è stata cancellata con successo.',
	'msg_setup_gpg' => 'La sua chiave GPG è stata salvata e verrà usata, d\'ora in poi.',
	'mails_gpg' => GWF_SITENAME.': Imposta crittatura GPG ',
	'mailb_gpg' =>
	'Caro %s,'.PHP_EOL.
	PHP_EOL.
	'Lei ha deciso di attivare la crittatura GPG per le E-Mail inviate da questo robot.'.PHP_EOL.
	'Per farlo, visiti il link sottostante:'.PHP_EOL.
	PHP_EOL.
	'%s'.PHP_EOL.
	PHP_EOL.
	'Cordiali saluti'.PHP_EOL.
	'Il team di '.GWF_SITENAME,

	# v2.04 Change Password
	'th_change_pw' => '<a href="%s">Cambia password</a>',
	'err_gpg_raw' => GWF_SITENAME.' supporta solo il formato ascii per la chiave pubblica GPG.',
	# v2.05 (fixes)
	'btn_delete' => 'Cancella account',
	'err_email_invalid' => 'Il suo indirizzo E-Mail sembra invalido.',
	# v3.00 (fixes3)
	'err_email_taken' => 'Questo indirizzo E-Mail è già stato utilizzato.',
	# v3.01 (record IPs)
	'btn_record_enable' => 'IP Recording',
	'mail_signature' => GWF_SITENAME.' Security Robot',
	'mails_record_disabled' => GWF_SITENAME.': IP Recording',
	'mailv_record_disabled' => 'IP recording has been disabled for your account.',
	'mails_record_alert' => GWF_SITENAME.': Security Alert',
	'mailv_record_alert' => 'There has been access to your account via an unknown UserAgent or an unknown/suspicious IP.',
	'mailb_record_alert' =>
		'Hello %s'.PHP_EOL.
		PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'UserAgent: %s'.PHP_EOL.
		'IP address: %s'.PHP_EOL.
		'Hostname: %s'.PHP_EOL.
		PHP_EOL.
		'You can ignore this Email safely or maybe you like to review all IPs:'.PHP_EOL.
		PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		PHP_EOL.
		'Kind Regards'.PHP_EOL.
		'The %s'.PHP_EOL,
	# 4 Checkboxes
	'th_record_ips' => 'Monitor <a href="%s">IP access</a>',
	'tt_record_ips' => 'Record access to your account by IP so you can review it. Entries cannot be deleted!',
	'msg_record_ips_on' => 'All unique IP Addresses using your account are now lieftime recorded. This is your last change to quit. You can of course pause recording anytime.',
	'msg_record_ips_off' => 'You have disabled IP recording for your account.',
	#
	'th_alert_uas' => 'Alert on UA change',
	'tt_alert_uas' => 'Sends you an email when your UserAgent changes. (recommended)',
	'msg_alert_uas_on' => 'Security Alert Email will be sent when your User Agent changes. Recording needs to be enabled.',
	'msg_alert_uas_off' => 'User Agent changes are now ignored.',
	#
	'th_alert_ips' => 'Alert on IP change',
	'tt_alert_ips' => 'Sends you an email when ´your´ IP changes. (recommended)',
	'msg_alert_ips_on' => 'Security Alert Email will be sent when your IP changes. Recording needs to be enabled.',
	'msg_alert_ips_off' => 'IP changes are now ignored.',
	#	
	'th_alert_isps' => 'Alert on ISP change',
	'tt_alert_isps' => 'Sends you an email when your ISP / hostname changes. (not recommended)',
	'msg_alert_isps_on' => 'Security Alert Email will be sent when your hostname changes significantly. Recording needs to be enabled.',
	'msg_alert_isps_off' => 'ISP/hostname changes are now ignored.',

	'th_date' => 'Date',
	'th_ua' => 'UserAgent',
	'th_ip' => 'IP Address',
	'th_isp' => 'Hostname',
);
