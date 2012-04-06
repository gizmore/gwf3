<?php

$lang = array(

	'pt_login' => 'Einloggen auf '.GWF_SITENAME,
	'title_login' => 'Einloggen',
	
	'th_username' => 'Nickname',
	'th_password' => 'Passwort',
	'th_login' => 'Einloggen',
	'btn_login' => 'Einloggen',
	'btn_register' => 'Register',
	'btn_recovery' => 'Recovery',

	'err_login' => 'Unbekannter Nickname',
	'err_login2' => 'Falsches Passwort. Sie haben noch %s Versuche bevor das Konto für %s blockiert wird.',
	'err_blocked' => 'Bitte warten sie %s bevor sie es erneut versuchen.',

	'welcome' => 
		'Willkommen auf '.GWF_SITENAME.', %s.<br/><br/>'.
		'Wir hoffen, dass Sie unsere Seite mögen und Spaß beim Browsen haben.<br/>'.
		'Falls Sie Fragen haben, zögern Sie nicht, uns zu kontaktieren.', 

	'welcome_back' => 
		'Willkommen zurück auf '.GWF_SITENAME.', %s.<br/><br/>'.
		'Ihre letzte Aktivität war am %s von dieser IP-Addresse: %s.', 

	'logout_info' => 'Sie sind nun ausgeloggt.',

	# Admin Config
	'cfg_captcha' => 'Captcha benutzen?',	
	'cfg_max_tries' => 'Max Versuche in',	
	'cfg_try_exceed' => 'dieser Zeitspanne',
	
	'info_no_cookie' => 'Ihr Browser unterstützt keine cookies, oder erlaubt diese nicht. Zum einloggen werden diese aber benötigt.',

	'th_bind_ip' => 'Sitzung auf diese IP begrenzen',
	'tt_bind_ip' => 'Eine Sicherheitsmassnahme um Cookie Diebstahl vorzubeugen.',

	'err_failures' => 'Seit ihrem letzten Login wurde das Passwort %s mal falsch eingegeben. Sie könnten Opfer einer misslungenen oder zukünftigen Attacke sein.',

	# v1.01 (login failures)
	'cfg_lf_cleanup_i' => 'Fehlerhafte Logins nach dem einloggen löschen?',
	'cfg_lf_cleanup_t' => 'Fehlerhafte Logins nach dieser Zeit löschen',

	# v2.00 (login history)
	'msg_last_login' => 'Ihr letzer Login war am %s von %s (%s).<br/>Sie können <a href="%s">hier Ihre gesamten logins einsehen</a>.',
	'th_loghis_time' => 'Datum',
	'th_loghis_ip' => 'IP ',
	'th_hostname' => 'Hostname ',

	# v2.01 (clear hist)
	'ft_clear' => 'Login Aufzeichnung Löschen',
	'btn_clear' => 'Löschen',
	'msg_cleared' => 'Ihre alten Logins wurden gelöscht.',
	'info_cleared' => 'Ihre Login Aufzeichnung wurde zuletzt am %s gelöscht, von dieser IP: %s / %s',

	# v2.02 (email alerts)
	'alert_subj' => GWF_SITENAME.': Login failures',
	'alert_body' =>
		'Dear %s,'.PHP_EOL.
		PHP_EOL.
		'There was a failed login attempt from this IP: %s.'.PHP_EOL.
		PHP_EOL.
		'We just let you know.'.PHP_EOL.
		PHP_EOL.
		'Sincerely,'.
		PHP_EOL.
		'The '.GWF_SITENAME.' script',

	# monnino fixes
	'cfg_send_alerts' => 'Alarm senden',
	'err_already_logged_in' => 'Sie sind bereits eingeloggt.',
);

?>