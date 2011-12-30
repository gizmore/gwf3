<?php
$lang = array(
	'msg_sent_mail' => 'Hemos enviado un email a %s. Por favor, siga las instrucciones que contiene.',
	'err_not_found' => 'Usuario no encontrado. Por favor, introduzca su email o nombre de usuario.',
	'err_not_same_user' => 'Usuario no encontrado. Por favor, introduzca su email o nombre de usuario.', 
# same message! no spoiled connection from uname=>email 
	'err_no_mail' => 'Lo sentimos, pero no tiene un email vinculado a su cuenta. :(',
	'err_pass_retype' => 'Las contraseñas no coinciden.',
	'msg_pass_changed' => 'Su contraseña ha sido cambiada.',
	'pt_request' => 'Pedir nueva contraseña',
	'pt_change' => 'Cambiar contraseña',
	'info_request' => 'Aquí puede pedir una nueva contraseña para su cuenta.<br/>Introduzca su email <b>o</b> nombre de usuario y se le enviarán instrucciones detalladas por email.',
	'info_change' => 'Puede introducir una nueva contraseña para su cuenta, %s.',
	'title_request' => 'Pedir nueva contraseña',
	'title_change' => 'Cambiar contraseña',
	'btn_request' => 'Pedir',
	'btn_change' => 'Cambiar',
	'th_username' => 'Nombre de usuario',
	'th_email' => 'Correo',
	'th_password' => 'Nueva contraseña',
	'th_password2' => 'Repetir contraseña',
	# The email
	'mail_subj' => GWF_SITENAME.': Cambiar contraseña',
	'mail_body' => 
		'Estimado/a %1$s,'.PHP_EOL.
		''.PHP_EOL.
		'Usted pidió un cambio de contraseña en '.GWF_SITENAME.'.'.PHP_EOL.
		'Para llevarse a cabo, debe visitar el enlace que aparece más abajo.'.PHP_EOL.
		'Si no pidió el cambio, ignore este mensaje o contáctenos en %2$s.'.PHP_EOL.
		''.PHP_EOL.
		'%3$s'.PHP_EOL.
		''.PHP_EOL.
		'Atentamente,'.PHP_EOL.
		'El personal de '.GWF_SITENAME.PHP_EOL.
		'',

	# v2.01 (fixes)
	'err_weak_pass' => 'Tu contraseña es demasiado débil. El mínimo son %s caracteres.',
);
?>
