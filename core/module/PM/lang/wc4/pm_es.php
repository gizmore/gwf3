<?php

$lang = array(
	'hello' => 'Hola %1$s',
	'sel_username' => 'Elija usuario',
	'sel_folder' => 'Elija carpeta',

	# Info
	'pt_guest' => GWF_SITENAME.' PM de invitado',
	'pi_guest' => 'En '.GWF_SITENAME.' es también posible enviar un mensaje privado a alguien sin estar conectado a una cuenta, pero no es posible recibir contestación. Sin embargo, puede ser usado para informar de errores rápidamente.',
	'pi_trashcan' => 'Esta es su papelera, no puede borrar mensajes completamente, pero puede restaurarlos.',
	
	# Buttons
	'btn_ignore' => 'Poner a %1$s en la Lista de Ignorados',
	'btn_ignore2' => 'Ignorar',
	'btn_save' => 'Guardar opciones',
	'btn_create' => 'Nuevo PM',
	'btn_preview' => 'Previsualizar',
	'btn_send' => 'Enviar PM',
	'btn_delete' => 'Borrar',
	'btn_restore' => 'Restaurar',
	'btn_edit' => 'Editar',
	'btn_autofolder' => 'Autoarchivar',
	'btn_reply' => 'Responder',
	'btn_quote' => 'Citar',
	'btn_options' => 'Opciones de PM',
	'btn_search' => 'Buscar',
	'btn_trashcan' => 'Su papelera',
	'btn_auto_folder' => 'Archivar PM automáticamente',

	# Errors
	'err_pm' => 'Ese PM no existe.',
	'err_perm_read' => 'No puede leer este PM.',
	'err_perm_write' => 'No puede editar este PM.',
	'err_no_title' => 'Olvidó el título de PM.',
	'err_title_len' => 'Título muy largo. Se permiten %1$s carácteres máximo.',
	'err_no_msg' => 'Olvido escribir el mensaje.',
	'err_sig_len' => 'Su firma es demasiado larga. Se permiten %1$s carácteres máximo.',
	'err_msg_len' => 'Su mensaje es demasiado largo. Se permiten %1$s carácteres máximo.',
	'err_user_no_ppm' => 'Este usuario no quiere recibir PMs.',
	'err_no_mail' => 'No tiene un email aprobado asociado a su cuenta.',
	'err_pmoaf' => 'El valor para autoarchivar no es válido.',
	'err_limit' => 'Alcanzó su límite de PM hoy. Puede enviar un máximo de %1$s PMs en %2$s.',
	'err_ignored' => '%1$s se agregó a su Lista de Ignorados.',
	'err_delete' => 'Ocurrió un error cuando se borraban sus mensajes.',
	'err_folder_exists' => 'La carpeta ya existe.',
	'err_folder_len' => 'La longitud del nombre de carpeta tiene que tener entre 1 y %1$s carácteres.',
	'err_del_twice' => 'Ya ha borrado este PM.',
	'err_folder' => 'Carpeta desconocida.',
	'err_pm_read' => 'El PM ya ha sido borrado, así que ya no puedes editarlo.',

	# Messages
	'msg_sent' => 'Su PM fue enviado correctamente. Puede todavía editarlo, hasta que sea leído.',
	'msg_ignored' => 'Puso a %1$s en la Lista de Ignorados.',
	'msg_unignored' => 'Eliminó a %1$s de la Lista de Ignorados.',
	'msg_changed' => 'Sus opciones han sido cambiadas.',
	'msg_deleted' => 'Eliminó correctamente %1$s PMs.',
	'msg_moved' => 'Movió correctamente %1$s PMs.',
	'msg_edited' => 'Su PM ha sido editado.',
	'msg_restored' => 'Restauró correctamente %1$s PMs.',
	'msg_auto_folder_off' => 'No tiene autoarchivar activado. El PM ha sido marcado como leído.',
	'msg_auto_folder_none' => 'Hay sólo %1$s mensajes de/para este usuario. Nada movido. El PM ha sido marcado como leído.',
	'msg_auto_folder_created' => 'Carpeta %1$s creada.',
	'msg_auto_folder_moved' => 'Movió %1$s mensaje(s) a la carpeta %2$s. Los PMs fueron marcados como leídos.',
	'msg_auto_folder_done' => 'Autoarchivado correctamente.',


	# Titles
	'ft_create' => 'Escribir a %1$s un nuevo PM',
	'ft_preview' => 'Previsualizar',
	'ft_options' => 'Sus opciones de PM',
	'ft_ignore' => 'Poner a alguien en Lista de Ignorados',
	'ft_new_pm' => 'Escribir nuevo PM',
	'ft_reply' => 'Responder a %1$s',
	'ft_edit' => 'Editar PM',
	'ft_quicksearch' => 'Búsqueda rápida',
	'ft_advsearch' => 'Búsqueda avanzada',

	# Tooltips
	'tt_pmo_auto_folder' => 'Si un usuario le envía esta cantidad de mensajes, serán archivados en una carpeta propia automáticamente.',
	
	# Table Headers
	'th_pmo_options&1' => 'Recibir correo si hay nuevos PMs',
	'th_pmo_options&2' => 'Permitir a invitados escribirme',
	'th_pmo_auto_folder' => 'Crear carpetas de usuario tras n mensajes',
	'th_pmo_signature' => 'Firma para PM',

	'th_pm_options&1' => 'Nuevo',
	'th_actions' => '',
	'th_user_name' => 'Nombre de usuario',
	'th_pmf_name' => 'Carpeta',
	'th_pmf_count' => 'Contador',
	'th_pm_id' => 'ID ',
	'th_pm_to' => 'Para',
	'th_pm_from' => 'De',
//	'th_pm_to_folder' => 'A carpeta',
//	'th_pm_from_folder' => 'De carpeta',
	'th_pm_date' => 'Fecha',
	'th_pm_title' => 'Título',
	'th_pm_message' => 'Mensaje',
//	'th_pm_options' => 'Opciones',

	# Welcome PM
//	'wpm_title' => 'Bienvenido/a a '.GWF_SITENAME,
//	'wpm_message' => 
//		'Estimado/a %1$s'.PHP_EOL.
//		PHP_EOL.
//		'Bienvenido/a a '.GWF_SITENAME.''.PHP_EOL.
//		PHP_EOL.
//		'Esperamos que le guste nuestro sitio y disfrute con él.'.PHP_EOL,
		
	# New PM Email
	'mail_subj' => GWF_SITENAME.'Nuevo PM de %1$s',
	'mail_body' =>
		'Hola %1$s'.PHP_EOL.
		PHP_EOL.
		'Hay un nuevo PM para ti en '.GWF_SITENAME.'.'.PHP_EOL.
		PHP_EOL.
		'De: %2$s'.PHP_EOL.
		'Título: %3$s'.PHP_EOL.
		PHP_EOL.
		'%4$s'.PHP_EOL.
		PHP_EOL.
		PHP_EOL.
		'--------------------------------------------------------------------------'.
		PHP_EOL.
		PHP_EOL.
		'Usted puede rápidamente:'.PHP_EOL.
		'Autoarchivar este PM:'.PHP_EOL.
		'%5$s'.PHP_EOL.
		PHP_EOL.
		'Borrar este PM:'.PHP_EOL.
		'%6$s'.PHP_EOL.
		PHP_EOL.
		'Atentamente,'.PHP_EOL.
		'El Robot de '.GWF_SITENAME.''.PHP_EOL,
		
	# Admin Config
	'cfg_pm_captcha' => 'Usar Captcha para invitados',
	'cfg_pm_causes_mail' => 'Enviar email al recibir PM',
	'cfg_pm_for_guests' => 'Permitir mandar PM a los invitados',
	'cfg_pm_welcome' => 'Enviar mensaje de bienvenida',
	'cfg_pm_limit' => 'Máximo de PM en tiempo límite',
	'cfg_pm_maxfolders' => 'Carpetas máximas por usuario',
	'cfg_pm_msg_len' => 'Longitud máxima mensaje',
	'cfg_pm_per_page' => 'PMs por página',
	'cfg_pm_sig_len' => 'Longitud máxima firma',
	'cfg_pm_title_len' => 'Longitud máxima título',
	'cfg_pm_bot_uid' => 'Emisor de PM de bienvenida',
	'cfg_pm_sent' => 'Contador de PM enviados',
	'cfg_pm_mail_sender' => 'Enviar email al recibir PM',
	'cfg_pm_re' => 'Prepend título',
	'cfg_pm_limit_timeout' => 'PM limit  timeout',
	'cfg_pm_fname_len' => 'Longitud máxima nombre de carpeta',

    # v2.01
	'err_ignore_admin' => 'No puede poner a un administrador en su lista de ignorados.',
	'btn_new_folder' => 'Nueva carpeta',

    # v2.02
	'msg_mail_sent' => 'Un correo ha sido enviado a %1$s con su mensaje original.',		
		
	# v2.03 SEO
	'pt_pm' => 'PM ',
	# v2.04 fixes
	'ft_new_folder' => 'Crear una carpeta nueva',
	# v2.05 (prev+next)
	'btn_prev' => 'Mensaje anterior',
	'btn_next' => 'Siguiente Mensaje',
	# v2.06 (icon titles+bots)
	'gwf_pm_deleted' => 'El otro usuario ha borrado este pm.',
	'gwf_pm_read' => 'El otro usuario ha leído tu pm.',
	'gwf_pm_unread' => 'El otro usuario aún no ha leído tu mensaje.',
	'gwf_pm_old' => 'Este pm es antiguo para tí.',
	'gwf_pm_new' => 'Nuevo pm para tí.',
	'err_bot' => 'No está permitodo a los Robots enviar mensajes.',
	# v2.07 (fixes)
	'err_ignore_self' => 'No puedes ignorarte a ti mismo.',
	'err_folder_perm' => 'Esta carpeta no es tuya.',
	'msg_folder_deleted' => 'La carpeta %1$s y %2$s mensaje(s) se trasladó a la papelera.',
	'cfg_pm_delete' => '¿Permitir borrar PM?',
	'ft_empty' => 'Vaciar Papelera',
	'msg_empty' => 'Tu Papelera (%1$s mensajes) ha sido vaciada.<br/>%2$s mensajes han sido borrados de nuestra base de datos.<br/>%3$s mensajes estan aún en uso y no han sido borrados.',

	# v2.08 (GT)
	'btn_translate' => 'Translate with Google',
		
	# Welcome PM
	'wpm_title' => 'Bienvenido/a a '.GWF_SITENAME,
	'wpm_message' =>
		'Dear Challenger, Welcome to WeChall.'.PHP_EOL.
		PHP_EOL.
		'The site\'s ultimate goal is to provide an universal ranking for the hacker challenge sites.'.PHP_EOL.
		'That\'s why you have to [url=/linked_sites]link your challenge site accounts[/url] to WeChall.'.PHP_EOL.
		'You can do this under Account -> Linked Sites.'.PHP_EOL.
		'There are also some [url=/challs]WeChall challenges[/url], and your account is already linked to WeChall itself.'.PHP_EOL.
		'If you like our site, don\'t forget to frequently visit it and [url=/linked_sites]update your progress[/url].'.PHP_EOL.
		'If you are new to challenge sites, feel free to ask in the Forum, we will help you.'.PHP_EOL.
		'If you have any other question or suggestion, please provide feedback to us.'.PHP_EOL.
		PHP_EOL.PHP_EOL.
		'Here are a few hints how to setup your account (press the [url=/account]Account[/url] button in menu for that):'.PHP_EOL.
		'1) It\'s about solving challenges. so solve a few riddles on the [url=/active_sites]sites[/url] and link to your account. If you encounter problems, please tell.'.PHP_EOL.
		'2) You can toggle [url=/forum/options]Forum Settings[/url], [url=/pm/options]PM Settings[/url] and [url=/profile_settings]Change profile options[/url] if you would like to allow getting contacted. All contacting is off by default.'.PHP_EOL.
		'3) [b]WeChall is capable of SSL[/b], but does not force it anywhere. However you should be able to use SSL all over the site.'.PHP_EOL.
		PHP_EOL.
		'Happy Challenging'.PHP_EOL.
		'The WeChall Team'.PHP_EOL,
);

?>