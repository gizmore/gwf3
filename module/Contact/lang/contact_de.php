<?php

$lang = array(

	'page_title' => GWF_SITENAME.' kontaktieren',
	'page_meta' => 'META TAGS HIER',

	'contact_title' => 'Kontakt',
	'contact_info' =>
		'Hier können sie uns per E-Mail kontaktieren. Bitte geben sie eine gültige E-Mail an, damit wir ihnen antworten können.<br/>'.
		'Sie können auch direkt eine E-Mail an <a href="mailto:%1%">%1%</a> senden.',
	'form_title' => 'Kontaktiere uns',
	'th_email' => 'Ihre E-Mail',
	'th_message' => 'Ihre Nachricht',
	'btn_contact' => 'Absenden',

	'mail_subj' => GWF_SITENAME.': Neue Kontakt Nachricht',
	'mail_body' => 
		'Eine neue E-Mail wurde durch das Kontakt-Formular gesendet.<br/>'.
		'Sender: %1%<br/>'.
		'Nachricht:<br/>'.
		'%2%<br/>'.
		'',

	'info_skype' => '<br/>Sie können uns auch via Skype kontaktieren: %1%.',

	'err_email' => 'Ihre E-Mail ist ungültig. Sie können diese Feld frei lassen wenn sie möchten.',
	'err_message' => 'Ihre Nachricht ist zu kurz oder zu lang.',

	# Admin Config
	'cfg_captcha' => 'Captcha verwenden',
	'cfg_email' => 'Nachricht an diese E-Mail senden',
	'cfg_icq' => 'ICQ Kontakt Daten',
	'cfg_skype' => 'Skype Kontakt Daten',
	'cfg_maxmsglen' => 'Max. Message Länge',

	# Sendmail
	'th_user_email' => 'Ihre E-Mail Addresse',
	'ft_sendmail' => 'Eine E-Mail an %1% senden',
	'btn_sendmail' => 'E-Mail Senden',
	'err_no_mail' => 'Dieser Benutzer möchte keine E-Mails empfangen.',
	'msg_mailed' => 'Eine E-Mail wurde an %1% gesendet.',
	'mail_subj_mail' => GWF_SITENAME.': E-Mail von %1%',
	'mail_subj_body' => 
		'Hallo %1%'.PHP_EOL.
		PHP_EOL.
		'Ihnen wurde eine E-Mail von %2% über die '.GWF_SITENAME.' Webseite zugesandt:'.PHP_EOL.
		PHP_EOL.
		PHP_EOL.
		'%3%',
		
	# V2.01 (List Admins)
	'list_admins' => 'Administratoren: %1%.',
);

?>