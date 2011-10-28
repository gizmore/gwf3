<?php

$lang = array(
	'pt_register' => 'registrazione sù '.GWF_SITENAME,

	'title_register' => 'registrazione',

	'th_username' => 'Nome Utente',
	'th_password' => 'Passwort',
	'th_email' => 'e-Mmail',
	'th_birthdate' => 'data di nascita',
	'th_countryid' => 'Paese',
	'th_tos' => 'Accetto le condizione',
	'th_tos2' => 'Accetto <a href="%1$s">le condizione</a>',
	'th_register' => 'Registrazione',

	'btn_register' => 'Regitrazione',
	
	'err_register' => 'Durante la registrazione è apparso un errore.',
	'err_name_invalid' => 'Il suo nome utente non è valido.',
	'err_name_taken' => 'Il nome Utente da Voi dato è gia assegnato.',
	'err_country' => 'Il vostro Paese non è valido.',
	'err_pass_weak' => 'Il vostro Password è troppo corto. Tip: <b>Non usi Password importanti più volte</b>.',
	'err_token' => 'Il vostro codice di attivazione non è valido. Probabilmente siete già attivati.',
	'err_email_invalid' => 'La vostra e-Mail non è valida.',
	'err_email_taken' => 'La Vostra e-Mail è già assegnata.',
	'err_activate' => 'Durante la attivazione è apparso un errore.',

	'msg_activated' => 'Il Vostro Account è stato attivato con sucesso e vi potete registrare con i Vostri dati di accesso.',
	'msg_registered' => 'La ringraziamo per la vostra registrazione.',

	'regmail_subject' => 'registrato su '.GWF_SITENAME,
	'regmail_body' => 
		'Salve %1$s<br/>'.
		'<br/>'.
		'La ringraziamo per la vostra registrazione su'.GWF_SITENAME.'.<br/>'.
		'Per concludere la Vostra registrazione, si deve attivare il Conto, nel quanto attivate il Link sottoimpresso.<br/>'.
		'Nel caso non Vi siete registrati su '.GWF_SITENAME.' Vi preghiamo di igniorare questa e-Mail o ci segnali il tutto su '.GWF_SUPPORT_EMAIL.'.<br/>'.
		'<br/>'.
		'%2$s<br/>'.
		'<br/>'.
		'%3$s'.
		'Cordiali saluti,<br/>'.
		'Il '.GWF_SITENAME.' Team.',

	'err_tos' => 'Devi accettare i Termini di servizio.',

	'regmail_ptbody' => 
		'Hier nochmals Ihre Zugangsdaten:<br/><b>'.
		'Nickname: %1$s<br/>'.
		'Passwort: %2$s<br/>'.
		'</b><br/>'.
		'Es ist eine gute Idee diese Email zu löschen, und sich das Password sicherer aufzubewahren.<br/>'.
		'Wir speichern ihr Passwort auch nicht im klartext ab, sie können aber jederzeit über diese EMail ein neues beantragen.<br/>'.
		'<b>Die Sicherheit Ihres Kontos hängt stark von der Sicherheit dieses E-Mail Konto`s ab</b>.'.
		'<br/>',

	### Admin Config ###
	'cfg_auto_login' => 'Auto-Login nach Aktivierung?',	
	'cfg_captcha' => 'Captcha Benutzen?',
	'cfg_country_select' => 'Länderwahl anzeigen?',
	'cfg_email_activation' => 'EMail Aktierung Benutzen?',
	'cfg_email_twice' => 'Gleiche EMail mehrmals erlaubt?',
	'cfg_force_tos' => 'Nutzungsbedingungen Prüfen?',
	'cfg_ip_usetime' => 'IP nach aktivierung sperren für',
	'cfg_min_age' => 'Mindestalter / Geburtstags Auswahl.',
	'cfg_plaintextpass' => 'Passwort im Klartext bei der Anmeldung senden.',
	'cfg_activation_pp' => 'Anzahl Zeilen pro Admin Seite',
	'cfg_ua_threshold' => 'Zeitlimit um die Anmeldung abzuschliessen',

	'err_birthdate' => 'Ihr Geburtstag ist ungültig.',
	'err_minage' => 'Sie sind nicht alt genug um sich auf '.GWF_SITENAME.' zu registrieren. Sie müssen mindestens %1$s Jahre alt sein.',
	'err_ip_timeout' => 'Mit dieser IP wurde erst kürzlich ein Konto erstellt.',
	'th_token' => 'Token',
	'th_timestamp' => 'Anmelde-Datum',
	'th_ip' => 'Anmelde IP',
	'tt_username' => 'Der Nickname muss mit einem Buchstaben beginnen.'.PHP_EOL.'Er darf nur Zahlen, Buchtstaben und _ enthalten. Erlaubte Länge: 3 - %1$s Zeichen.', 
	'tt_email' => 'Eine gültige EMail ist für die Anmeldung erforderlich.',

	'info_no_cookie' => 'Ihr Browser unterstützt keine cookies, oder erlaubt diese nicht. Zum einloggen werden diese aber benötigt.',

	# v2.01 (fixes)
	'msg_mail_sent' => 'An EMail with instructions to activate your account has been sent to you.',

	# v2.02 (Detect Country)
	'cfg_reg_detect_country' => 'Always auto-detect country',

	# v2.03 (Links)
	'btn_login' => 'Login',
	'btn_recovery' => 'Password recovery',
	# v2.04 (Fixes)
	'tt_password' => 'Your password can be chosen freely. Please do not re-use important passwords. Consider a short phrase as password.',
	# v2.05 (Blacklist)
	'err_domain_banned' => 'Your email provider is on the blacklist.',
);
?>
