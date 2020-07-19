<?php
$lang = array(
	'msg_sent_mail' => 'Es wurde eine E-Mail an %s gesendet. Bitte folgen Sie den Anweisungen dort.',
	'err_not_found' => 'Kein Benutzer gefunden. Bitte übermitteln Sie Ihre E-Mail oder Ihren Benutzernamen.',
	'err_not_same_user' => 'Kein Benutzer gefunden. Bitte übermitteln Sie Ihre E-Mail oder Ihren Benutzernamen.', # same message! no spoiled connection from uname=>email
	'err_no_mail' => 'Es tut uns leid, aber für Ihr Konto wurde keine E-Mail hinterlegt. :(',
	'err_pass_retype' => 'Sie müssen zwei mal das selbe Passwort eingeben.',
    'err_no_token' => 'Ihre Anfrage konnte nicht gefunden werden.',
	'msg_pass_changed' => 'Ihr Passwort wurde geändert.',

	'pt_request' => 'Neues Passwort anfordern',
	'pt_change' => 'Ändern Sie Ihr Passwort',
	
    'info_request' => 'Hier können Sie ein neues Passwort für Ihr Konto anfordern.<br/>Übermitteln Sie Ihren Nutzernamen <b>oder</b> Ihre E-Mail und Sie erhalten eine E-Mail mit Anweisungen.',
    'info_change' => 'Geben Sie jetzt Ihr gewünschtes Passwort für Ihr Konto ein, %s.',

	'title_request' => 'Neues Passwort anfordern',
	'title_change' => 'Neues Passwort setzen',

	'btn_request' => 'Anfordern',
	'btn_change' => 'Ändern',

	'th_username' => 'Benutzername',
	'th_email' => 'E-Mail',
	'th_password' => 'Neues Passwort',
	'th_password2' => 'Passwort wiederholen',

	# The email (beware %s is twice. It`s an email. thats correct!)
	'mail_subj' => GWF_SITENAME.': Passwort ändern',
	'mail_body' => 
		'Hallo %1$s,<br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'Sie haben die Änderung Ihres Passwortes auf '.GWF_SITENAME.' angefordert.<br/>'.PHP_EOL.
		'Um dies zu tun, rufen Sie den folgenden Link auf.<br/>'.PHP_EOL.
		'Falls Sie dies nicht angefordert haben, ignorieren Sie diese E-Mail oder nehmen Kontakt mit uns auf; <a href="mailto:%2$s">%2$s</a>.<br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'%3$s<br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'Viele Grüße<br/>'.PHP_EOL.
		'Das '.GWF_SITENAME.' Team'.PHP_EOL,

	# v2.01 (fixes)
	'err_weak_pass' => 'Ihr Passwort ist zu kurz. Es muss mindestens %s Zeichen lang sein.',
		
	#monnino fixes
	'cfg_captcha' => 'Captcha verwenden?',
	'cfg_mail_sender' => 'E-Mail Absender',
);
