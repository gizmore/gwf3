<?php

$lang = array(

	'page_title' => GWF_SITENAME.' Contattare',
	'page_meta' => 'META TAGS HIER',

	'contact_title' => 'Contatto',
	'contact_info' =>
		'Qui potete contattarci via e-Mail. Vi preghiamo di inserire un e-Mail valido, così potremo rispondere alle vostre domande.<br/>'.
		'Potete inviarci una e-mail da qualsiasi altro programma e-Mail al seguente indirizzo <a href="mailto:%s">%s</a> senden.',
	'form_title' => 'Contatto '.GWF_SITENAME,
	'th_email' => 'La vostra e-Mail',
	'th_message' => 'Il Vostro messaggio',
	'btn_contact' => 'Invia la e-Mail',

	'mail_subj' => GWF_SITENAME.': Nuovo messaggio di contatto',
	'mail_body' => 
		'È stata inviata una nuova e-Mail tramite il formulare di contatto.<br/>'.
		'Invia: %s<br/>'.
		'Messaggio:<br/>'.
		'%s<br/>'.
		'',

	'info_skype' => '<br/>Sie können uns auch via Skype kontaktieren: %s.',

	'err_email' => 'Ihre EMail ist ungültig. Sie können diese Feld frei lassen wenn sie möchten.',
	'err_message' => 'Ihre Nachricht ist zu kurz oder zu lang.',

	# Admin Config
	'cfg_captcha' => 'Captcha verwenden',
	'cfg_email' => 'Nachricht an diese EMail senden',
	'cfg_icq' => 'ICQ Kontakt Daten',
	'cfg_skype' => 'Skype Kontakt Daten',
	'cfg_maxmsglen' => 'Max. Nachrichten Länge',

	# Sendmail
	'th_user_email' => 'Ihre EMail Addresse',
	'ft_sendmail' => 'Eine EMail an %s senden',
	'btn_sendmail' => 'EMail Senden',
	'err_no_mail' => 'Dieser Benutzer möchte keine EMails empfangen.',
	'msg_mailed' => 'Eine EMail wurde an %s gesendet.',
	'mail_subj_mail' => GWF_SITENAME.': EMail von %s',
	'mail_subj_body' => 
		'Hallo %s'.PHP_EOL.
		PHP_EOL.
		'Ihnen wurde eine EMail von %s über die '.GWF_SITENAME.' Webseite zugesandt:'.PHP_EOL.
		PHP_EOL.
		PHP_EOL.
		'%s',
	
	# V2.01 (List Admins)
	'list_admins' => 'Admins: %s.',
	'cfg_captcha_member' => 'Show captcha for members?',
);

?>
