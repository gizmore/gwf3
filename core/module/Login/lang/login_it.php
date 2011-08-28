<?php

$lang = array(

	'pt_login' => 'Login su '.GWF_SITENAME,
	'title_login' => 'login',
	
	'th_username' => 'Nome Utente',
	'th_password' => 'Passwort',
	'th_login' => 'Login',
	'btn_login' => 'Login',
	'btn_register' => 'Register',
	'btn_recovery' => 'Recovery',

	'err_login' => 'Nome Utente sconosciuto',
	'err_login2' => 'Passwort errato. Avete ancora %1% tentativo, prima che il Conto sarrà %2% bloccato.',
	'err_blocked' => 'Attenda %1% prima di riprovare nuovamente.',

	'welcome' => 
		'Benvenuti su '.GWF_SITENAME.', %1%.<br/><br/>'.
		'Auguriamo che piacia il nostro sito e buon sucesso nelle vostre sicerche.<br/>'.
		'Se avete delle domande, non esiti di contattarci.',

	'welcome_back' => 
		'Benvenuti nuovamente su '.GWF_SITENAME.', %1%.<br/><br/>'.
		'La vostra ultima attività era al %2% da qusto indirizzo IP: %3%.', 

	'logout_info' => 'Attualmente lei non si trova più nel Login.',

	# Admin Config
	'cfg_captcha' => 'Captcha benutzen?',	
	'cfg_max_tries' => 'Max Versuche in',	
	'cfg_try_exceed' => 'dieser Zeitspanne',

	'info_no_cookie' => 'Ihr Browser unterstützt keine cookies, oder erlaubt diese nicht. Zum einloggen werden diese aber benötigt.',

	'th_bind_ip' => 'Sitzung auf diese IP begrenzen',
	'tt_bind_ip' => 'Eine Sicherheitsmassnahme um Cookie Diebstahl vorzubeugen.',

	'err_failures' => 'Seit ihrem letzten Login wurde das Passwort %1% mal falsch eingegeben. Sie könnten Opfer einer misslungenen oder zukünftigen Attacke sein.',

	# v1.01 (login failures)
	'cfg_lf_cleanup_i' => 'Cleanup user failures after login?',
	'cfg_lf_cleanup_t' => 'Cleanup old failures after time',

	# v2.00 (login history)
	'msg_last_login' => 'Your last login was %1% from %2% (%3%).<br/>You can also <a href="%4%">review your login history here</a>.',
	'th_loghis_time' => 'Date',
	'th_loghis_ip' => 'IP',
	'th_hostname' => 'Hostname',

	# v2.01 (clear hist)
	'ft_clear' => 'Clear login history',
	'btn_clear' => 'Clear',
	'msg_cleared' => 'Your login history has been cleared.',
	'info_cleared' => 'Your login history was last cleared at %1% from this IP: %2% / %3%',
);

?>