<?php

$lang = array(

	# Errors
	'err_board' => 'El foro es desconocido, o no tiene permisos para acceder a él.',
	'err_thread' => 'El tema es desconocido, o no tiene permisos para acceder a él.',
	'err_post' => 'La publicación es desconocida.',
	'err_parentid' => 'El foro padre es desconocido.',
	'err_groupid' => 'El grupo es desconocido.',
	'err_board_perm' => 'No se le permite el acceso a este foro.',
	'err_thread_perm' => 'No se le permite el acceso a este tema.',
	'err_post_perm' => 'No se le permite la lectura de esta publicación.',
	'err_reply_perm' => 'No se le permite responder a este tema. <a href="%s">Clic aquí para volver al tema</a>.',
	'err_no_thread_allowed' => 'No hay temas permitidos en este foro.',
	'err_no_guest_post' => 'Invitados no pueden escribir en este foro.',
	'err_msg_long' => 'Su mensaje es demasiado largo. Se permiten %s caracteres máximo.',
	'err_msg_short' => 'Olvidó escribir el mensaje.',
	'err_descr_long' => 'Su descripción es demasiado larga. Se permiten %s caracteres máximo.',
	'err_descr_short' => 'Olvidó escribir la descripción.',
	'err_title_long' => 'Su título es demasiado largo. Se permiten %s caracteres máximo.',
	'err_title_short' => 'Olvidó escribir el título.',
	'err_sig_long' => 'Su firma es demasiado larga. Se permiten %s caracteres máximo.',
	'err_subscr_mode' => 'Modo de suscripción desconocido.',
	'err_no_valid_mail' => 'No tiene un email aprobado para suscribirse a los foros.',
	'err_token' => 'El token no es válido.',
	'err_in_mod' => 'Este tema está actualmente en moderación.',
	'err_board_locked' => 'El foro está temporalmente bloqueado.',
	'err_no_subscr' => 'No puede suscribirse manualmente a este tema. <a href="%s">Clic aquí para volver al tema</a>.',
	'err_subscr' => 'Ocurrió un error. <a href="%s">Clic aquí para volver al tema</a>.',
	'err_no_unsubscr' => 'No puede anular la suscripción a este tema. <a href="%s">Clic aquí para volver al tema</a>.',
	'err_unsubscr' => 'Ocurrió un error. <a href="%s">Clic aquí para volver al tema</a>.',
	'err_sub_by_global' => 'No se suscribió al tema manualmente, sino mediante opciones globales.<br/><a href="/forum/options">Use las opciones del foro</a> para cambiar sus preferencias.',
	'err_thank_twice' => 'Ya agradeció este post.',
	'err_thanks_off' => 'Actualmente no está disponible la opción de agradecer las entradas.',
	'err_votes_off' => 'Los mensajes de votación están actualmente deshabilitados.',
	'err_better_edit' => 'Por favor, edite su mensaje y no lo publique repetido. Puede activar la opción &quot;Marcar-NoLeido&quot; en caso de que haya hecho cambios significativos.<br/><a href="%s">Clic aquí para volver al tema</a>.',


	# Messages
	'msg_posted' => 'Su mensaje ha sido publicado.<br/><a href="%s">Clic aquí para ver su mensaje</a>.',
	'msg_posted_mod' => 'Su mensaje ha sido publicado, pero será revisado antes de mostrarse.<br/><a href="%s">Clic aquí para volver al tablón</a>.',
	'msg_post_edited' => 'Su entrada ha sido editada.<br/><a href="%s">Clic aquí para ver su mensaje</a>.',
	'msg_edited_board' => 'El foro ha sido editado.<br/><a href="%s">Clic aquí para volver al foro</a>.',
	'msg_board_added' => 'El nuevo foro ha sido añadido correctamente. <a href="%s">Clic aquí para volver al foro</a>.',
	'msg_edited_thread' => 'El tema ha sido editado correctamente.',
	'msg_options_changed' => 'Sus opciones han sido cambiadas.',
	'msg_thread_shown' => 'El tema ha sido aprobado y ya es mostrado.',
	'msg_post_shown' => 'El mensaje ha sido aprobado y ya es mostrado.',
	'msg_thread_deleted' => 'El tema ha sido borrado.',
	'msg_post_deleted' => 'El mensaje ha sido borrado.',
	'msg_board_deleted' => '¡El foro entero ha sido borrado!',
	'msg_subscribed' => 'Se suscribió al tema y recibirá emails cuando haya nuevos mensajes.<br/><a href="%s">Clic aquí para volver al tema</a>.',
	'msg_unsubscribed' => 'Anuló la suscripción para este tema y no recibirá más emails.<br/><a href="%s">Clic aquí para volver al tema</a>.',
	'msg_unsub_all' => 'Anuló la suscripción por email de todos los temas.',
	'msg_thanked_ajax' => 'Su agradecimiento ha sido guardado.',
	'msg_thanked' => 'Su agradecimiento ha sido guardado.<br/><a href="%s">Clic aquí para volver al mensaje</a>.',
	'msg_thread_moved' => 'El tema %s ha sido movido a %s.',
	'msg_voted' => 'Gracias por su voto.',
	'msg_marked_read' => '%s temas marcados como leídos satisfactoriamente.',

	# Titles
	'forum_title' => 'Foro de '.GWF_SITENAME,
	'ft_add_board' => 'Añadir nuevo foro',
	'ft_add_thread' => 'Añadir nuevo tema',
	'ft_edit_board' => 'Editar foro existente',
	'ft_edit_thread' => 'Editar tema',
	'ft_options' => 'Configurar opciones del foro',
	'pt_thread' => '%2$s ['.GWF_SITENAME.']->%1$s',
	'ft_reply' => 'Responder al tema',
	'pt_board' => '%s',
	//'pt_board' => '%s ['.GWF_SITENAME.']',
	'ft_search_quick' => 'Búsqueda rápida',
	'ft_edit_post' => 'Editar su mensaje',
	'at_mailto' => 'Enviar email a %s',
	'last_edit_by' => 'Última edición por %s - %s',

	# Page Info
	'pi_unread' => 'Temas no leidos para usted',

	# Table Headers
	'th_board' => 'Foro',
	'th_threadcount' => 'Tema',
	'th_postcount' => 'Mensajes',
	'th_title' => 'Título',
	'th_message' => 'Mensaje',
	'th_descr' => 'Descripción',	
	'th_thread_allowed' => 'Temas permitidos',	
	'th_locked' => 'Bloqueado',
	'th_smileys' => 'Deshabilitar smileys',
	'th_bbcode' => 'Deshabilitar BBCode',
	'th_groupid' => 'Restringir a grupo',
	'th_board_title' => 'Título del foro',
	'th_board_descr' => 'Descripción del foro',
	'th_subscr' => 'Suscripción por email',
	'th_sig' => 'Su firma para foros',
	'th_guests' => 'Permitir mensajes de invitados',
	'th_google' => 'No incluir Javascript Google/Traductor',
	'th_firstposter' => 'Creador',
	'th_lastposter' => 'Respuesta de',
	'th_firstdate' => 'Primer mensaje',
	'th_lastdate' => 'Último mensaje',
	'th_post_date' => 'Fecha de mensaje',
	'th_user_name' => 'Nombre de usuario',
	'th_user_regdate' => 'Registrado',
//	'th_unread_again' => '',
	'th_sticky' => 'Importante',
	'th_closed' => 'Cerrado',
	'th_merge' => 'Fusionar tema',
	'th_move_board' => 'Mover foro',
	'th_thread_thanks' => 'Agradecer',
	'th_thread_votes_up' => 'Voto positivo',
	'th_thanks' => 'Gracias',
	'th_votes_up' => 'Voto positivo',

	# Buttons
	'btn_add_board' => 'Crear nuevo foro',
	'btn_rem_board' => 'Borrar foro',
	'btn_edit_board' => 'Editar foro actual',
	'btn_add_thread' => 'Añadir tema',
	'btn_preview' => 'Previsualizar',
	'btn_options' => 'Editar configuración del foro',
	'btn_change' => 'Cambiar',
	'btn_quote' => 'Cita',
	'btn_reply' => 'Responder',
	'btn_edit' => 'Editar',
	'btn_subscribe' => 'Suscribirse',
	'btn_unsubscribe' => 'Anular suscripción',
	'btn_search' => 'Buscar',
	'btn_vote_up' => 'Buen mensaje!',
	'btn_vote_down' => 'Mal mensaje!',
	'btn_thanks' => '¡Gracias!',
	'btn_translate' => 'Google/Traductor',

	# Selects
	'sel_group' => 'Seleccionar grupo',
	'subscr_none' => 'Nada',
	'subscr_own' => 'Donde yo he escrito',
	'subscr_all' => 'Todos los temas',

	# Config
	'cfg_guest_posts' => 'Permitir mensajes a invitados',	
	'cfg_max_descr_len' => 'Longitud máxima de la descripción',	
	'cfg_max_message_len' => 'Longitud máxima del mensaje',
	'cfg_max_sig_len' => 'Longitud máxima de la firma',
	'cfg_max_title_len' => 'Longitud máxima del título',
	'cfg_mod_guest_time' => 'Tiempo de automoderación',
	'cfg_num_latest_threads' => 'Número de últimos temas',
	'cfg_num_latest_threads_pp' => 'Temas por página',
	'cfg_posts_per_thread' => 'Mensajes por tema',
	'cfg_search' => 'Permitir búsquedas',
	'cfg_threads_per_page' => 'Temas por foro',
	'cfg_last_posts_reply' => 'Temas mostrados al responder',
	'cfg_mod_sender' => 'Enviar email al moderar',
	'cfg_mod_receiver' => 'Recibir email para moderar',
	'cfg_unread' => 'Activar temas como no leídos',
	'cfg_gtranslate' => 'Activar traductor de Google',	
	'cfg_thanks' => 'Activar agradecimientos',
	'cfg_uploads' => 'Activar subidas',
	'cfg_votes' => 'Activar votos',
	'cfg_mail_microsleep' => 'EMail Microsleep :/ .. ???',	
	'cfg_subscr_sender' => 'Enviar email al suscribir',

	# show_thread.php
	'posts' => 'Mensajes',
	'online' => 'El usuario está conectado',
	'offline' => 'El usuario está desconectado',
	'registered' => 'Registrado el',
	'watchers' => '%s personas están viendo el tema ahora mismo.',
	'views' => 'Este tema ha sido visto %s veces.',

	# forum.php
	'latest_threads' => 'Últimas actividades',

	# Moderation EMail
	'modmail_subj' => GWF_SITENAME.': Moderación de mensajes',
	'modmail_body' =>
		'Estimado Staff'.PHP_EOL.
		PHP_EOL.
		'Hay un nuevo mensaje o tema en los foros de '.GWF_SITENAME.' que necesita moderación.'.PHP_EOL.
		PHP_EOL.
		'Foro: %s'.PHP_EOL.
		'Tema: %s'.PHP_EOL.
		'De: %s'.PHP_EOL.
		PHP_EOL.
		'%s'.PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		PHP_EOL.
		'Para eliminar el mensaje use este enlace:'.PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'Para permitirlo use este enlace:'.PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		PHP_EOL.
		'El mensaje será automaticamente mostrado en %s'.PHP_EOL.
		PHP_EOL.
		'Atentamente'.PHP_EOL.
		'El equipo de '.GWF_SITENAME.''.PHP_EOL,

	# New Post EMail
	'submail_subj' => GWF_SITENAME.': Nuevo mensaje: %s',
	'submail_body' => 
		'Estimado/a %s'.PHP_EOL.
		PHP_EOL.
		'Hay %s nuevo(s) mensaje(s) en el foro de '.GWF_SITENAME.''.PHP_EOL.
		PHP_EOL.
		'Tablón: %s'.PHP_EOL.
		'Tema: %s'.PHP_EOL.
		PHP_EOL.
		'<hr/>'.PHP_EOL.
		PHP_EOL.
		'%s'.PHP_EOL. # Multiple msgs possible
		PHP_EOL.
		PHP_EOL.
		'To view the thread please visit this page:'.PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'Para anular la suscripción de este tema, siga el enlace siguiente:'.PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'Para anular la suscripción del tablón entero, siga el enlace siguiente:'.PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'Atentamente'.PHP_EOL.
		'El equipo de '.GWF_SITENAME.''.PHP_EOL,
		
	'submail_body_part' =>  # that`s the %s above
		'De: %s'.PHP_EOL.
		'Título: %s'.PHP_EOL.
		'Mensaje:'.PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'<hr/>'.PHP_EOL.
		PHP_EOL,

	# v2.01
	'last_seen' => 'Última vez visto: %s',

	# v2.02
	'btn_mark_read' => 'Marcar todo como leído',
	'msg_mark_aread' => 'Marcó %s los temas como leídos',

	# v2.03 (Merge)
	'msg_merged' => 'Los temas han sido añadidos.',
	'th_viewcount' => 'Vistas',
	
	# v2.04 (Polls)
	'ft_add_poll' => 'Asignar una de sus encuestas',
	'btn_assign' => 'Asignar',
	'btn_polls' => 'Encuestas',
	'btn_add_poll' => 'Añadir encuesta',
	'msg_poll_assigned' => 'Su encuesta fue asignada satisfactoriamente.',
	'err_poll' => 'Encuesta desconocida.',
	'th_thread_pollid' => 'Su encuesta',
	'pi_poll_add' => 'Aquí puede asignar una encuesta a su hilo, o crear una nueva.<br/>Depués de crearla, necesitará asignar su encuesnta a su hilo de nuevo desde aquí.',
	'sel_poll' => 'Seleccionar una encuesta',

	# v2.05 (refinish)
	'th_thread_viewcount' => 'Vistas',
	'th_unread_again' => 'Marcar como no leído de nuevo',
	'cfg_doublepost' => 'Permitir entradas dobles/seguidas para un usuario',
	'cfg_watch_timeout' => 'Marcar tiempo de visionado de tema en N segundos',             
	'th_hidden' => 'Está escondido',
	'th_guest_view' => 'Es visible por anónimo',
	'pt_history' => 'historia del foro - Página %s / %s',
	'btn_unread' => 'Temas Nuevos',
		
	# v2.06 (Admin Area)
	'th_approve' => 'Aprobar',
	'th_delete' => 'Borrar',
	
	# v2.07 rerefinish
	'btn_pm' => 'PM',
	'permalink' => 'link',

	# v2.08 (attachment)
	'cfg_postcount' => 'Contador de publicaciones',
	'msg_attach_added' => 'Su adjunto ha sido subido. <a href="%s">Clic aquí para volver a su publicación.</a>',
	'msg_attach_deleted' => 'Su adjunto ha sido borrado. <a href="%s">Clic aquí para volver a su publicación.</a>',
	'msg_attach_edited' => 'Su adjunto ha sido editado. <a href="%s">Clic aquí para volver a su publicación.</a>',
	'msg_reupload' => 'Su adjunto ha sido reemplazado.',
	'btn_add_attach' => 'Agregar adjunto',
	'btn_del_attach' => 'Borrar adjunto',
	'btn_edit_attach' => 'Editar adjunto',
	'ft_add_attach' => 'Agregar adjunto',
	'ft_edit_attach' => 'Editar adjunto',
	'th_attach_file' => 'Archivo',
	'th_guest_down' => 'Descargable por invitados',
	'err_attach' => 'Adjunto desconocido.',
	'th_file_name' => 'Archivo',
	'th_file_size' => 'Tamaño',
	'th_downloads' => 'Descargas',
		
	# v2.09 Lang Boards
	'cfg_lang_boards' => 'Crear lenguaje de foros',
	'lang_board_title' => 'Foro %s',
	'lang_board_descr' => 'Para lenguaje %s',
	'lang_root_title' => 'Lenguaje extranjero',
	'lang_root_descr' => 'Foros no ingleses',
	'md_board' => 'Foros ' . GWF_SITENAME . '. %s',
	'mt_board' => GWF_SITENAME.', Foros, Publicaciones de invitados, Alternar, Foro, Software',

	# v2.10 subscribers
	'subscribers' => '%s se suscribieron a este tema y reciben emails en nuevas publicaciones.',
	'th_hide_subscr' => 'Esconder tus suscripciones',

	# v2.11 fixes11
	'txt_lastpost' => 'Ir a la última publicación',
	'err_thank_self' => 'No puedes dar las gracias en tus propias publicaciones.',
	'err_vote_self' => 'No puedes votar tus propias publicaciones.',

	# v3.00 fixes 12
	'info_hidden_attach_guest' => 'You need to login to see an attachment.',
	'msg_cleanup' => 'I have deleted %s threads and %s posts that have been in moderation.',
		
	# v1.05 (subscriptions)
	'submode' => 'Your global subscription mode is set to: &quot;%s&quot;.',
	'submode_all' => 'The whole board',
	'submode_own' => 'Where you posted',
	'submode_none' => 'Manually',
	'subscr_boards' => 'Your have manually subscribed to %s boards.',
	'subscr_threads' => 'You have manually subscribed to %s threads.',
	'btn_subscriptions' => 'Manage Subscriptions',
	'msg_subscrboard' => 'You have manually subscribed to this board and receive email on new posts.<br/>Click <a href="%s">here to return to the board</a>.',
	'msg_unsubscrboard' => 'You have unsubscribed from this board and do not receive emails for it anymore.<br/>Click <a href="%s">here to return to your subscription overview</a>.',

	# v1.06 (Post limits)
	'err_post_timeout' => 'You have just recently posted. Please wait %s.',
	'err_post_level' => 'You need a minimum userlevel of %s to post.',
	'cfg_post_timeout' => 'Minimum time between two posts',
	'cfg_post_min_level' => 'Minimum level to post',
);

?>
