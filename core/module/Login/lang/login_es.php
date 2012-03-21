<?php
$lang = array(

	'pt_login' => 'Acceder a '.GWF_SITENAME,
	'title_login' => 'Acceso',
	'th_username' => 'Nombre de usuario',
	'th_password' => 'Contraseña',
	'th_login' => 'Acceso',
	'btn_login' => 'Acceder',
	'btn_register' => 'Register',
	'btn_recovery' => 'Recovery',
	'err_login' => 'Nombre de usuario desconocido.',
	'err_login2' => 'Contraseña erronea. Le quedan %s para ser bloqueado por %s.',
	'err_blocked' => 'Por favor, espere %s para intentarlo de nuevo.',
	'welcome' =>
		'Bienvenido a '.GWF_SITENAME.', %s.<br/><br/>'.
		'Esperamos que le guste nuestra página y disfrute navegando por ella.<br/>'.
		'En caso de que tenga preguntas, ¡no dude en contactar con nosotros!',

	'welcome_back' =>
		'Bienvenido de nuevo a '.GWF_SITENAME.', %s.<br/><br/>'.
		'Su última actividad fue %s desde la IP: %s.',
		
	'logout_info' => 'Está desconectado.',

	# Admin Config
	'cfg_captcha' => 'Usar Captcha',
	'cfg_max_tries' => 'Intentos máximo para acceder',
	'cfg_try_exceed' => 'Duración del bloqueo',
	
	'info_no_cookie' => 'Su navegador no soporta cookies o no las permite en '.GWF_SITENAME.', pero las cookies son necesarias para acceder.',
	'th_bind_ip' => 'Vincular sesión a esta IP',
	'tt_bind_ip' => 'Medida de seguridad para evitar robo de cookies.',

	# v1.01 (login failures)
	'err_failures' => 'Hay %s intentos fallidos de acceso y pudo haber sido sujeto de un ataque sin éxito.',
	'cfg_lf_cleanup_i' => 'Limpiar intentos fallidos luego de acceder',
	'cfg_lf_cleanup_t' => 'Limpiar viejos intentos fallidos al pasar el tiempo',

	# v2.00 (login history)
	'msg_last_login' => 'Su último inicio de sesión fue %s desde %s (%s).<br/>Puede también <a href="%s">revisar el historial de acceso desde aquí</a>.',
	'th_loghis_time' => 'Fecha',

	'th_loghis_ip' => 'IP ',
	'th_hostname' => 'Nombre Host',
	
	# v2.01 (clear hist)
	'ft_clear' => 'Limpiar historial de acceso',
	'btn_clear' => 'Limpiar',
	'msg_cleared' => 'Tu historial de acceso ha sido limpiado.',
	'info_cleared' => 'Tu historial de acceso se borró por última vez el %s desde esta IP: %s / %s',

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
