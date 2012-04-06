<?php
$lang = array(
	'pt_register' => 'Registrieren auf '.GWF_SITENAME,

	'title_register' => 'Registrieren',

	'th_username' => 'Nickname',
	'th_password' => 'Passwort',
	'th_email' => 'E-Mail',
	'th_birthdate' => 'Geburtsdatum',
	'th_countryid' => 'Land',
	'th_tos' => 'Ich stimme den Nutzungsbedingungen zu',
	'th_tos2' => 'Ich stimme den <a href="%s">Nutzungsbedingungen</a> zu',
	'th_register' => 'Registrieren',

	'btn_register' => 'Registrieren',
	
	'err_register' => 'Ein Fehler ist beim registrieren aufgetreten.',
	'err_name_invalid' => 'Ihr Nickname ist ungültig.',
	'err_name_taken' => 'Der gewählte Nickname ist bereits vergeben.',
	'err_country' => 'Ihr gewähltes Land ist ungültig.',
	'err_pass_weak' => 'Ihr gewähltes Passwort ist zu kurz. Tip: <b>Verwenden sie wichtige Passwörter nicht mehrmals</b>.',
	'err_token' => 'Ihr aktivierungscode ist ungültig. Möglicherweise sind sie bereits aktiviert.',
	'err_email_invalid' => 'Ihre EMail ist ungültig.',
	'err_email_taken' => 'Ihre EMail ist bereits vergeben.',
	'err_activate' => 'Beim aktivieren ist ein Fehler aufgetreten.',

	'msg_activated' => 'Ihr Account ist nun aktiviert und sie können sich mit ihren Benutzerdaten einloggen.',
	'msg_registered' => 'Vielen Dank für ihre Registrierung.',

	'regmail_subject' => GWF_SITENAME.': Anmeldung',
	'regmail_body' => 
		'Hallo %s<br/>'.
		'<br/>'.
		'Vielen Dank für ihre Registrierung auf '.GWF_SITENAME.'.<br/>'.
		'Um die Registrierung abzuschliessen, muss ihr Konto noch aktiviert werden, indem sie den unteren Link aufrufen.<br/>'.
		'Falls sie sich nicht selbst auf '.GWF_SITENAME.' registriert haben, ignorieren sie diese EMail bitte, oder melden diese durch eine EMail an '.GWF_SUPPORT_EMAIL.'.<br/>'.
		'<br/>'.
		'%s<br/>'.
		'<br/>'.
		'%s'.
		'Freundliche Grüße,<br/>'.
		'Das '.GWF_SITENAME.' Team.',

	'err_tos' => 'Sie müssen den Nutzungsbedingungen zustimmen.',

	'regmail_ptbody' => 
		'Hier nochmals Ihre Zugangsdaten:<br/><b>'.
		'Nickname: %s<br/>'.
		'Passwort: %s<br/>'.
		'</b><br/>'.
		'Es ist eine gute Idee diese Email zu löschen, und sich das Passwort sicherer aufzubewahren.<br/>'.
		'Wir speichern ihr Passwort auch nicht im Klartext ab, sie können aber jederzeit über diese EMail ein neues beantragen.<br/>'.
		'<b>Die Sicherheit Ihres Kontos hängt stark von der Sicherheit dieses E-Mail Konto`s ab</b>.'.
		'<br/>',

	### Admin Config ###
	'cfg_auto_login' => 'Auto-Login nach Aktivierung?',	
	'cfg_captcha' => 'Captcha Benutzen?',
	'cfg_country_select' => 'Länderwahl anzeigen?',
	'cfg_email_activation' => 'EMail Aktivierung Benutzen?',
	'cfg_email_twice' => 'Gleiche EMail mehrmals erlaubt?',
	'cfg_force_tos' => 'Nutzungsbedingungen Prüfen?',
	'cfg_ip_usetime' => 'IP nach aktivierung sperren für',
	'cfg_min_age' => 'Mindestalter / Geburtstags Auswahl.',
	'cfg_plaintextpass' => 'Passwort im Klartext bei der Anmeldung senden.',
	'cfg_activation_pp' => 'Anzahl Zeilen pro Admin Seite',
	'cfg_ua_threshold' => 'Zeitlimit um die Anmeldung abzuschliessen',

	'err_birthdate' => 'Ihr Geburtstag ist ungültig.',
	'err_minage' => 'Sie sind nicht alt genug um sich auf '.GWF_SITENAME.' zu registrieren. Sie müssen mindestens %s Jahre alt sein.',
	'err_ip_timeout' => 'Mit dieser IP wurde erst kürzlich ein Konto erstellt.',
	'th_token' => 'Code',
	'th_timestamp' => 'Anmelde-Datum',
	'th_ip' => 'Anmelde IP',
	'tt_username' => 'Der Nickname muss mit einem Buchstaben beginnen.'.PHP_EOL.'Er darf nur Zahlen, Buchtstaben und _ enthalten. Erlaubte Länge: 3 - %s Zeichen.', 
	'tt_email' => 'Eine gültige EMail ist für die Anmeldung erforderlich.',

	'info_no_cookie' => 'Ihr Browser unterstützt keine cookies, oder erlaubt diese nicht. Zum einloggen werden diese aber benötigt.',

	# v2.01 (fixes)
	'msg_mail_sent' => 'Ihnen wird eine EMail zugesandt um ihr Konto zu aktivieren.',

	# v2.02 (Detect Country)
	'cfg_reg_detect_country' => 'Benutzerland immer automatisch erfassen',

	# v2.03 (Links)
	'btn_login' => 'Einloggen',
	'btn_recovery' => 'Passwort Vergessen',
	# v2.04 (Fixes)
	'tt_password' => 'Your password can be chosen freely. Please do not re-use important passwords. Consider a short phrase as password.',
	# v2.05 (Blacklist)
	'err_domain_banned' => 'Your email provider is on the blacklist.',
);

?>
