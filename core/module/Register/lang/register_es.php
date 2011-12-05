<?php
$lang = array(
	'pt_register' => 'Registrarse en '.GWF_SITENAME,
	'title_register' => 'Registro',
	'th_username' => 'Nombre de usuario',
	'th_password' => 'Contraseña',
	'th_email' => 'Email',
	'th_birthdate' => 'Fecha de nacimiento',
	'th_countryid' => 'País',
	'th_tos' => 'Estoy de acuerdo con los<br/>Términos de Uso',
	'th_tos2' => 'Estoy de acuerdo con los<br/><a href="%s">Términos de Uso</a>',
	'th_register' => 'Registro',
	'btn_register' => 'Registro',
	'err_register' => 'Ocurrió un error durante el proceso de registro.',
	'err_name_invalid' => 'Nombre de usuario no válido.',
	'err_name_taken' => 'Nombre de usuario ya en uso.',
	'err_country' => 'País no válido.',
	'err_pass_weak' => 'Su contraseña es muy débil. También, <b>no reutilice contraseñas importantes.</b>',
	'err_token' => 'Código de activación incorrecto. Quizá ya esté activado.',
	'err_email_invalid' => 'Email inválido.',
	'err_email_taken' => 'Email ya en uso.',
	'err_activate' => 'Ocurrió un error durante la activación.',
	'msg_activated' => 'Cuenta activada. Por favor, intente acceder.',
	'msg_registered' => 'Gracias por registrarse.',

	'regmail_subject' => 'Registro en '.GWF_SITENAME,
	'regmail_body' =>
		'Hola %s'.PHP_EOL.
	'Gracias por registrarse en '.GWF_SITENAME.'.'.PHP_EOL.
	'Para completar el registro, tiene que activar la cuenta primero, visitando el siguiente enlace.'.PHP_EOL.
	'Si no se registró en '.GWF_SITENAME.', por favor, ignore este email o contacte con nosotros en '.GWF_SUPPORT_EMAIL.'.'.PHP_EOL.
	''.PHP_EOL.
	'%s'.PHP_EOL.
	''.PHP_EOL.
	'%s'.PHP_EOL.
	'Atentamente,'.PHP_EOL.
	'El personal de '.GWF_SITENAME.'',
	
	'err_tos' => 'Debe aceptar el Acuerdo de Licencia del Usuario Final (EULA).',

	'regmail_ptbody' =>
		'Sus datos de acceso son:'.PHP_EOL.
		'<b>Nombre de usuario: %s'.PHP_EOL.
		'Contraseña: %s</b>'.PHP_EOL.
		''.PHP_EOL.
		'Es una buena idea borrar este email y guardar la contraseña en otro sitio.'.PHP_EOL.
		'No guardamos su contraseña en texto plano, y usted tampoco debería.'.PHP_EOL,

	### Admin Config ###
	'cfg_auto_login' => 'Acceder automáticamente después de activación',
	'cfg_captcha' => 'Captcha para registro',
	'cfg_country_select' => 'Mostrar selección de país',
	'cfg_email_activation' => 'Activación por email',
	'cfg_email_twice' => 'Registrar mismo email dos veces',
	'cfg_force_tos' => 'Mostrar Terminos del Servicio',
	'cfg_ip_usetime' => 'Tiempo por IP para multiregistros',
	'cfg_min_age' => 'Edad mínima / Selector de cumpleaños',
	'cfg_plaintextpass' => 'Enviar contraseña en texto plano por email',
	'cfg_activation_pp' => 'Activaciones por cada página de administración',
	'cfg_ua_threshold' => 'Tiempo para completar registro',
	'err_birthdate' => 'Fecha de nacimiento no válida.',
	'err_minage' => 'Lo sentimos, pero no tiene edad suficiente para registrarse. Necesita tener al menos %s años.',
	'err_ip_timeout' => 'Alguien registró una cuenta con esta IP recientemente.',
	
	'th_token' => 'Token',
	'th_timestamp' => 'Tiempo de registro',
	'th_ip' => 'Registrar IP',
	'tt_username' => 'Nombre de usuario debe empezar por una letra.'.PHP_EOL.'Sólo puede contener letras, dígitos y guión bajo. Length has to be 3 - %s chars.',
	'tt_email' => 'Se requiere un email válido para el registro.',
	'info_no_cookie' => 'Su navegador no soporta cookies o no las permite para '.GWF_SITENAME.', pero las cookies son necesarias para acceder.', 

	# v2.01 (fixes)
	'msg_mail_sent' => 'Se le ha enviado un correo con instrucciones para activar su cuenta.',

	# v2.02 (Detect Country)
	'cfg_reg_detect_country' => 'Auto-detectar país siempre',

	# v2.03 (Links)
	'btn_login' => 'Login',
	'btn_recovery' => 'Recuperar contraseña',
	# v2.04 (Fixes)
	'tt_password' => 'Your password can be chosen freely. Please do not re-use important passwords. Consider a short phrase as password.',
	# v2.05 (Blacklist)
	'err_domain_banned' => 'Your email provider is on the blacklist.',
);
?>
