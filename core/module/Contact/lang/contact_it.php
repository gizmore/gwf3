<?php

$lang = array(

	'page_title' => 'Contatta'.GWF_SITENAME,
	'page_meta' => 'META TAGS HIER',

	'contact_title' => 'Contatto',
	'contact_info' =>
		'Qui potete contattarci via E-Mail. Vi preghiamo di inserire un indirizzo E-Mail valido, così potremo rispondere alle vostre domande.<br/>'.
		'Potete inviarci una E-Mail da qualsiasi altro indirizzo E-Mail al seguente indirizzo <a href="mailto:%s">%s</a>.',
	'form_title' => 'Contatta '.GWF_SITENAME,
	'th_email' => 'La vostra E-Mail',
	'th_message' => 'Il Vostro messaggio',
	'btn_contact' => 'Invia E-Mail',

	'mail_subj' => GWF_SITENAME.': Nuovo messaggio di contatto',
	'mail_body' => 
		'È stata inviata una nuova E-Mail tramite il form di contatto.<br/>'.PHP_EOL.
		'Invia: %s<br/>'.PHP_EOL.
		'Messaggio:<br/>'.PHP_EOL.
		'%s<br/>'.PHP_EOL.
		'',


	'info_skype' => '<br/>Può anche contattarci tramite Skype: %s.',

	'err_email' => 'L\'E-Mail è invalida. Può lasciare il campo vuoto se desidera.',
	'err_message' => 'Il messaggio è troppo lungo o troppo corto.',

	# Admin Config
	'cfg_captcha' => 'Usa Captcha',	
	'cfg_email' => 'Invia i messaggi a (E-Mail)',
	'cfg_icq' => 'Contatto ICQ',
	'cfg_skype' => 'Contatto Skype',
	'cfg_maxmsglen' => 'Lunghezza massima messaggio',

	# Sendmail
	'th_user_email' => 'Indirizzo E-Mail',
	'ft_sendmail' => 'Invia una E-Mail a %s',
	'btn_sendmail' => 'Invia E-mail',
	'err_no_mail' => 'Questo utente non vuole ricevere E-Mail.',
	'msg_mailed' => 'Una E-Mail è stata inviata a %s.',
	'mail_subj_mail' => GWF_SITENAME.': E-Mail da %s',
	'mail_subj_body' => 
		'Salve %s'.PHP_EOL.
		PHP_EOL.
		'Le è stata inviata una E-Mail da %s tramite il sito '.GWF_SITENAME.PHP_EOL.
		PHP_EOL.
		PHP_EOL.
		'%s',

	# V2.01 (List Admins)
	'list_admins' => 'Amministratori: %s.',
	
	'cfg_captcha_member' => 'Mostra Captcha per i membri?',
);
?>