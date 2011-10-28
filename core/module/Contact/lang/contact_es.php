<?php

$lang = array(

	'page_title' => 'Contacta con '.GWF_SITENAME,
	'page_meta' => 'Foo',

	'contact_title' => 'Contacto',
	'contact_info' =>
		'Aquí usted puede contactarnos por correo electrónico. Por favor proveanos con un correo válido, así podremos enviarte una respuesta, si es necesario.<br/>'.
		'También puede enviarnos un correo electrónico a <a href="mailto:%1$s">%1$s</a> con cualquier otro programa de correo.',
	'form_title' => 'Contáctenos',
	'th_email' => 'Su EMail',
	'th_message' => 'Su Mensaje',
	'btn_contact' => 'Envíanos un EMail',

	'mail_subj' => GWF_SITENAME.': Nuevo contacto',
	'mail_body' => 
		'Un nuevo Email ha sido enviado por el formulario de contacto..<br/>'.
		'De: %1$s<br/>'.
		'Mensaje:<br/>'.
		'%2$s<br/>'.
		'',

	'info_skype' => '<br/>También puede contactar con nosotros a través de Skype : %1$s.',

	'err_email' => 'Su Email no es válido. Puede dejar el campo en blanco si desea.',
	'err_message' => 'Su mensaje es demasiado corto o demasiado largo.',

	# Admin Config
	'cfg_captcha' => 'Usar Captcha',	
	'cfg_email' => 'Enviar mensajes a (email)',
	'cfg_icq' => 'Datos de contacto ICQ',
	'cfg_skype' => 'Datos de contacto Skype',
	'cfg_maxmsglen' => 'Máx. longitud del mensaje',

	# Sendmail
	'th_user_email' => 'Su correo',
	'ft_sendmail' => 'Enviar correo a %1$s',
	'btn_sendmail' => 'Enviar correo',
	'err_no_mail' => 'Este usuario no desea recibir correos.',
	'msg_mailed' => 'Un correo ha sido enviado a %1$s.',
	'mail_subj_mail' => GWF_SITENAME.': EMail de %1$s',
	'mail_subj_body' => 
		'Hola %1$s'.PHP_EOL.
		PHP_EOL.
		'%2$s te ha enviado un correo por el sitio web '.GWF_SITENAME.':'.PHP_EOL.
		PHP_EOL.
		PHP_EOL.
		'%3$s',

	# V2.01 (List Admins)
	'list_admins' => 'Administradores: %1$s.',
	'cfg_captcha_member' => 'Show captcha for members?',
);

?>