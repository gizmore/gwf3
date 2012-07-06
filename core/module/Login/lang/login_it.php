<?php
$lang = array(

	'pt_login' => 'Login su '.GWF_SITENAME,
	'title_login' => 'Login ',

	'th_username' => 'Nome utente',
	'th_password' => 'Password ',
	'th_login' => 'Login ',
	'btn_login' => 'Login ',
	'btn_register' => 'Registrati',
	'btn_recovery' => 'Recupero',

	'err_login' => 'Nome utente sconosciuto',
	'err_login2' => 'Password errata. Avete ancora %s tentativi, prima che il l\'account venga bloccato per %s.',
	'err_blocked' => 'Attenda %s prima di riprovare nuovamente.',

	'welcome' =>
	'Benvenuto su '.GWF_SITENAME.', %s.<br/><br/>'.
	'Ci auguriamo che gradisca il nostro sito e buon divertimento.<br/>'.
	'Nel caso avesse delle domande, non esiti a contattarci.',

	'welcome_back' =>
	'Bentornato su '.GWF_SITENAME.', %s.<br/><br/>'.
	'La sua ultima attività risale al %s da questo indirizzo IP: %s.',

	'logout_info' => 'E\' stato disconnesso dal sito.',

	# Admin Config
	'cfg_captcha' => 'Utilizza Captcha?',
	'cfg_max_tries' => 'Numero massimo di login',
	'cfg_try_exceed' => 'in questo lasso di tempo',

	'info_no_cookie' => 'Il suo Browser non supporta i cookies o non permette a '.GWF_SITENAME.' di utilizzarli, ma questi sono necessari per effettuare il login.',

	'th_bind_ip' => 'Limita la sessione a questo IP',
	'tt_bind_ip' => 'Una misura di sicurezza per evitare il furto dei cookies.',

	'err_failures' => 'Ci sono stati %s tentativi di accesso falliti ed il suo account potrebbe essere stato soggetto di un attacco.',

	# v1.01 (login failures)
	'cfg_lf_cleanup_i' => 'Resetta i tentativi errati dopo un login corretto?',
	'cfg_lf_cleanup_t' => 'Resetta i tentativi errati dopo un certo periodo di tempo?',

	# v2.00 (login history)
	'msg_last_login' => 'Il suo ultimo login risale a %s da %s (%s).<br/>Può anche <a href="%s">ripercorrere la cronologia dei suoi accessi qui</a>.',
	'th_loghis_time' => 'Data',
	'th_loghis_ip' => 'IP ',
	'th_hostname' => 'Nome dell\'host',

	# v2.01 (clear hist)
	'ft_clear' => 'Ripulisci cronologia degli accessi',
	'btn_clear' => 'Ripulisci',
	'msg_cleared' => 'La cronologia degli accessi è stata ripulita.',
	'info_cleared' => 'La cronologia degli accessi è stata ripulita il %s da questo IP: %s / %s',

	# v2.02 (email alerts)
	'alert_subj' => GWF_SITENAME.': Tentativi di accesso errati',
	'alert_body' =>
		'Dear %s,'.PHP_EOL.
		PHP_EOL.
		'Il seguente IP ha tentato, fallendo, di accedere al suo account: %s.'.PHP_EOL.
		PHP_EOL.
		'Verrà avvisato ad ogni tentativo di accesso fallito.'.PHP_EOL.
		PHP_EOL.
		'Cordiali saluti,<br/>'.PHP_EOL.
		PHP_EOL.
		'Il team di '.GWF_SITENAME,
	
	#monnino fixes
	'cfg_send_alerts' => 'Invia avvertimenti',
	'err_already_logged_in' => 'Ha già effettuato l\'accesso.',
);
?>
