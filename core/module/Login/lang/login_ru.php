<?php # Login translation by Ens
$lang = array(
	'pt_login' => 'Вход на '.GWF_SITENAME,
	'title_login' => 'Вход',
	'th_username' => 'Имя',
	'th_password' => 'Пароль',
	'th_login' => 'Вход',
	'btn_login' => 'Вход',
	'btn_register' => 'Register',
	'btn_recovery' => 'Recovery',

	'err_login' => 'Неизвестное имя пользователя',
	'err_login2' => 'Неверный пароль. У Вас есть %s попыток до того, как Вас заблокирует на %s.',
	'err_blocked' => 'Пожалуйста подождите %s, пока Вы сможете попробовать ещё.',
	 
	'welcome' => 
	'Добро пожаловать на '.GWF_SITENAME.', %s.<br/><br/>'.
	'Мы надеемся, что Вам понравится наш сайт.<br/>'.
	'В случае возникновения вопросов, не стесняйтесь спрашивать нас!',
	 
	'welcome_back' => 
	'Добро пожаловать назад на '.GWF_SITENAME.', %s.<br/><br/>'.
	'Ваша последняя активность была %s с этого IP: %s.',
	 
	'logout_info' => 'Сеанс закрыт. Приходите ещё!',
	 
	# Admin Config
	'cfg_captcha' => 'Использовать Captcha?',   
	'cfg_max_tries' => 'Максимальное количество попыток входа',   
	'cfg_try_exceed' => 'в течение этого срока',
	 
	'info_no_cookie' => 'Ваш браузер не поддерживает cookies или не принимает их с '.GWF_SITENAME.', но cookies необходимы для входа.',
	
	'th_bind_ip' => 'Привязать сессию к этому IP',
	'tt_bind_ip' => 'Защитная система, которая препятствует краже cookies.',
	 
	'err_failures' => 'Было %s неудачных попыток входа, и возможно, Вы стали объектом неудачной или запланированной атаки.',
	 
	# v1.01 (login failures)
	'cfg_lf_cleanup_i' => 'Очистить список неудачных попыток после входа?',
	'cfg_lf_cleanup_t' => 'Очистить список старых неудачных попыток по истечении времени',
	 
	# v2.00 (login history)
	'msg_last_login' => 'Ваш последний вход был %s с %s (%s).<br/>Вы также можете <a href="%s">просмотреть вашу историю сеансов здесь</a>.',
	'th_loghis_time' => 'Дата',
	'th_loghis_ip' => 'IP',
	'th_hostname' => 'Имя хоста',
	 
	# v2.01 (clear hist)
	'ft_clear' => 'Очистить список предыдущих сеансов',
	'btn_clear' => 'Очистить',
	'msg_cleared' => 'Ваша история сеансов была очищена.',
	'info_cleared' => 'Ваша история сеансов последний раз была очищена %s с IP: %s / %s',

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
	'cfg_send_alerts' => 'Send alerts',
	'err_already_logged_in' => 'You are already logged in.',
);
?>