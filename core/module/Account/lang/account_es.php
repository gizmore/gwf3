<?php
$lang = array(
	# Titles
	'form_title' => 'Configuración de la cuenta',
	'chmail_title' => 'Ingrese su nuevo email',
	# Headers
	'th_username' => 'Nombre de usuario',
	'th_email' => 'Email de contacto',
	'th_demo' => 'Opciones demográficas: Puede cambiarlas sólo una vez en %1$s.',
	'th_countryid' => 'País',
	'th_langid' => 'Idioma principal',
	'th_langid2' => 'Idioma secundario',
	'th_birthdate' => 'Fecha de nacimiento',
	'th_gender' => 'Sexo',
	'th_flags' => 'Opciones - Puede cambiarlas cuando desee',
	'th_adult' => 'Deseo ver contenido para adultos',
	'th_online' => 'Deseo ocultar mi estado de conexión',
	'th_show_email' => 'Deseo mostrar mi email al público',
	'th_avatar' => 'Ávatar',
	'th_approvemail' => '<b>Su email<br/>no está aprobado</b>',
	'th_email_new' => 'Nuevo email',
	'th_email_re' => 'Redigite su email',
	# Buttons
	'btn_submit' => 'Guardar cambios',
	'btn_approvemail' => 'Aprobar email',
	'btn_changemail' => 'Establecer nuevo email',
	'btn_drop_avatar' => 'Eliminar ávatar',
	# Errors
	'err_token' => 'Token no válido.',
	'err_email_retype' => 'Los emails no coinciden.',
	'err_delete_avatar' => 'Ocurrió un error eliminando su ávatar.',
	'err_no_mail_to_approve' => 'No tiene email establecido para aprobar.',
	'err_already_approved' => 'Su email ya está aprobado.',
	'err_no_image' => 'Su archivo cargado no es una imagen o es muy pequeña.',
	'err_demo_wait' => 'Cambió sus opciones demográficas recientemente. Por favor, espere %1$s.',
	'err_birthdate' => 'Su fecha de nacimiento no es válida.',
	# Messages
	'msg_mail_changed' => 'Su email de contacto ha sido cambiado a <b>%1$s</b>.',
	'msg_deleted_avatar' => 'Su imagen de ávatar ha sido eliminada.',
	'msg_avatar_saved' => 'Su nueva imagen de ávatar ha sido guardada.',
	'msg_demo_changed' => 'Sus opciones demográficas han sido cambiadas.',
	'msg_mail_sent' => 'Le hemos enviado un email para ejecutar los cambios. Por favor, siga las instrucciones que contiene.',
	'msg_show_email_on' => 'Su email ahora está visible al público.',
	'msg_show_email_off' => 'Su email ahora está oculto al público.',
	'msg_adult_on' => 'Su cuenta ahora puede ver contenido para adultos.',
	'msg_adult_off' => 'Su cuenta ahora no puede ver contenido para adultos.',
	'msg_online_on' => 'Su estado en línea ahora no es visible.',
	'msg_online_off' => 'Su estado en línea ahora es visible.',
	
	# Admin Config
	'cfg_avatar_max_x' => 'Anchura máxima del ávatar',
	'cfg_avatar_max_y' => 'Altura máxima del ávatar',
	'cfg_avatar_min_x' => 'Anchura mínima del ávatar',
	'cfg_avatar_min_y' => 'Altura mínima del ávatar',
	'cfg_adult_age' => 'Edad mínima para ver contenido de adultos',
	'cfg_demo_changetime' => 'Tiempo entre cambios demográficos',
	'cfg_mail_sender' => 'Cambiar remitente de email de la cuenta',
	'cfg_show_adult' => 'Página con contenido para adultos',
	'cfg_show_gender' => 'Mostrar selección de sexo',
	'cfg_use_email' => 'Requerir email para hacer cambios en cuenta',
	'cfg_show_avatar' => 'Mostrar cargador de ávatar',
	############################ # --- EMAIL BELOW HERE --- #
	# CHANGE MAIL A 
	'chmaila_subj' => GWF_SITENAME.': Cambio de email',
	'chmaila_body' =>
		'Estimado/a %1$s,'.PHP_EOL.
		PHP_EOL.
		'Usted pidió cambiar su email en '.GWF_SITENAME.'.'.PHP_EOL.
		'Para hacerlo, debe visitar el enlace que aparece a continuación.'.PHP_EOL.
		'En caso de no haber solicitado el cambio de su dirección de email, puede ignorar este email o avisarnos sobre ello.'.PHP_EOL.
		PHP_EOL.
		'%2$s'.PHP_EOL.
		PHP_EOL.
		'Atentamente'.PHP_EOL.
		'El personal de '.GWF_SITENAME.
		'',
	# CHANGE MAIL B
	'chmailb_subj' => GWF_SITENAME.': Confirmación de email',
	'chmailb_body' =>
		'Estimado/a %1$s,'.PHP_EOL.
		PHP_EOL.
	'Para usar esta dirección de email como su principal dirección de contacto, deberá confirmarlo visitando el enlace de abajo:'.PHP_EOL.
	'%2$s'.PHP_EOL.
	PHP_EOL.
	'Atentamente'.PHP_EOL.
	'El personal de '.GWF_SITENAME.'', 
	
	# CHANGE DEMO 
	'chdemo_subj' => GWF_SITENAME.': Cambio de configuración demográfica',
	'chdemo_body' => 
		'Estimado/a %1$s'.PHP_EOL.
		PHP_EOL.'Ha pedido actualizar o cambiar su configuración demográfica.'.PHP_EOL.
		'Puede hacerlo sólo una vez en %2$s, por lo tanto, por favor, asegúrese de que su configuración es correcta antes de continuar.'.PHP_EOL.
		PHP_EOL.
		'Sexo: %3$s'.PHP_EOL.
		'País: %4$s'.PHP_EOL.
		'Idioma principal: %5$s'.PHP_EOL.
		'Idioma secundario: %6$s'.PHP_EOL.
		'Fecha de nacimiento: %7$s'.PHP_EOL.
		PHP_EOL.
		'Si quiere mantener esta configuración, visite el siguiente enlace:'.PHP_EOL.
		'%8$s'.PHP_EOL.
		'Atentamente'.PHP_EOL.
		'El personal de '.GWF_SITENAME.'',

	# New Flags
	'th_allow_email' => 'Permitir que usuarios le envien emails',
	'msg_allow_email_on' => 'La gente puede ahora enviarle emails sin conocer su dirección.',
	'msg_allow_email_off' => 'Contacto por email deshabilitado.',
	'th_show_bday' => 'Mostrar cumpleaños',
	'msg_show_bday_on' => 'Tu cumpleaños es ahora anunciado a los usuarios que lo habiliten.',
	'msg_show_bday_off' => 'Tu cumpleaños no será anunciado nunca mas.',
	'th_show_obday' => 'Mostrar cumpleaños de otros',
	'msg_show_obday_on' => 'Ahora podrá ver cumpleaños de otros usuarios.',
	'msg_show_obday_off' => 'Ignorar los cumpleaños de otros usuarios.',
		
	# v2.02 Account Deletion
	'pt_accrm' => 'Borrar su cuenta',
	'mt_accrm' => 'Borrar su cuenta en '.GWF_SITENAME,
	'pi_accrm' =>
		'Parece que quiere borrar su cuenta en '.GWF_SITENAME.'.<br/>'.
		'Estamos tristes por escuchar eso, su cuenta no será borrada, sólo será desactivada.<br/>'.
		'Todos los enlaces a su nombre de usuario, perfiles, etcétera, pasarán a ser inusables o renombrados a invitado. Esto es irreversible.<br/>'.
		'Antes de continuar la deshabilitación de su cuenta, puede dejarnos un mensaje con la(s) razón(es) que le han llevado a ello.<br/>',
	'th_accrm_note' => 'Mensaje',
	'btn_accrm' => 'Borrar cuenta',
	'msg_accrm' => 'Su cuenta se marcó para la eliminación y todas las referencias serán borradas.<br/>Ha sido deslogeado.',
	'ms_accrm' => GWF_SITENAME.': Borrado de cuenta de %1$s ',
	'mb_accrm' =>
		'Estimado Staff'.PHP_EOL.
		''.PHP_EOL.
		'El usuario %1$s acaba de borrar su cuenta y dejó esta nota (puede estar vacía):'.PHP_EOL.PHP_EOL.
		'%2$s',

	# v2.03 Email Options
	'th_email_fmt' => 'Formato de EMail preferido',
	'email_fmt_text' => 'Texto Plano',
	'email_fmt_html' => 'HTML Simple',
	'err_email_fmt' => 'Por favor selecciona un formato de Email válido.',
	'msg_email_fmt_0' => 'Ahora recibirás emails en formato HTML simple.',
	'msg_email_fmt_4096' => 'Ahora recibirás emails en formato de texto plano.',
	'ft_gpg' => 'Instalacion de Encriptación PGP/GPG',
	'th_gpg_key' => 'Subir tu clave pública',
	'th_gpg_key2' => 'O pegala aquí',
	'tt_gpg_key' => 'Cuando hayas definido una clave GPG todos los correos enviados a ti por los scripts son encriptados con tu clave pública.',
	'tt_gpg_key2' => 'O pega aquí tu clave pública, o sube tu archivo con la clave pública.',
	'btn_setup_gpg' => 'Subir clave',
	'btn_remove_gpg' => 'Quitar clave',
	'err_gpg_setup' => 'O sube un archivo que contenga su clave pública ó pega tu clave pública en el textbox.',
	'err_gpg_key' => 'Tu clave pública parece que es inválida.',
	'err_gpg_token' => 'Tu huella digital GPG no coincide con nuestros registros.',
	'err_no_gpg_key' => 'El usuario %1$s no ha enviado una clave pública todavía.',
	'err_no_mail' => 'No tienes una direccion de email de contacto aprobada.',
	'err_gpg_del' => 'No tienes una clave GPG valida para borrar.',
	'err_gpg_fine' => 'Ya tienes una clave GPG. Por favor borrala primero.',
	'msg_gpg_del' => 'Tu clave GPG ha sido borrada satisfactoriamente.',
	'msg_setup_gpg' => 'Tu GPG has sido guardado y esta en uso ahora.',
	'mails_gpg' => GWF_SITENAME.': Instalación Encriptación GPG',
	'mailb_gpg' => 'Querido/a %1$s,
Has decidido activar la encriptación GPG para los emails enviados por este robot
Para ello, sigue el siguiente enlace:
%2$s
Saludos 
El personal de '.GWF_SITENAME,
		
	# 204
	'th_change_pw' => '<a href="%1$s">Cambia tu contraseña</a>',
	'err_gpg_raw' => 'WeChall solo soporta  el formato ASCII para tu clave pública GPG.',
	# v2.05 (fixes)
	'btn_delete' => 'Delete Account',
	'err_email_invalid' => 'Your email looks invalid.',
	# v3.00 (fixes3)
	'err_email_taken' => 'This email address is already in use.',
);
?>