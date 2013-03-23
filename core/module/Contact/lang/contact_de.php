<?php

$lang = array(

	'page_title' => GWF_SITENAME.' kontaktieren',
	'page_meta' => 'META TAGS HIER',

	'contact_title' => 'Kontakt',
	'contact_info' =>
		'Hier können Sie uns per E-Mail kontaktieren. Bitte geben Sie eine gültige E-Mail an, damit wir Ihnen antworten können.<br/>'.
		'Sie können auch direkt eine E-Mail an <a href="mailto:%s">%s</a> senden.',
	'form_title' => 'Kontaktieren Sie uns',
	'th_email' => 'Ihre E-Mail',
	'th_message' => 'Ihre Nachricht',
	'btn_contact' => 'Absenden',

	'mail_subj' => GWF_SITENAME.': Neue Kontakt Nachricht',
	'mail_body' => 
		'Eine neue E-Mail wurde durch das Kontakt-Formular gesendet.<br/>'.PHP_EOL.
		'Sender: %s<br/>'.PHP_EOL.
		'Nachricht:<br/>'.PHP_EOL.
		'%s<br/>'.PHP_EOL.
		'',

	'info_skype' => '<br/>Sie können uns auch via Skype kontaktieren: %s.',

	'err_email' => 'Ihre E-Mail ist ungültig. Sie können dieses Feld frei lassen wenn sie möchten.',
	'err_message' => 'Ihre Nachricht ist zu kurz oder zu lang.',

	# Admin Config
	'cfg_captcha' => 'Captcha verwenden',
	'cfg_email' => 'Nachricht an diese E-Mail senden',
	'cfg_icq' => 'ICQ Kontakt Daten',
	'cfg_skype' => 'Skype Kontakt Daten',
	'cfg_maxmsglen' => 'Max. Message Länge',

	# Sendmail
	'th_user_email' => 'Ihre E-Mail Adresse',
	'ft_sendmail' => 'Eine E-Mail an %s senden',
	'btn_sendmail' => 'E-Mail Senden',
	'err_no_mail' => 'Dieser Benutzer möchte keine E-Mails empfangen.',
	'msg_mailed' => 'Eine E-Mail wurde an %s gesendet.',
	'mail_subj_mail' => GWF_SITENAME.': E-Mail von %s',
	'mail_subj_body' => 
		'Hallo %s'.PHP_EOL.
		PHP_EOL.
		'Ihnen wurde eine E-Mail von %s über die '.GWF_SITENAME.' Webseite zugesandt:'.PHP_EOL.
		PHP_EOL.
		PHP_EOL.
		'%s',
		
	# V2.01 (List Admins)
	'list_admins' => 'Administratoren: %s.',
	'cfg_captcha_member' => 'Show captcha for members?',
);

?>