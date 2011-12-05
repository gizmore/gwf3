<?php
$lang = array(
	
	# Messages
	'msg_news_added' => 'El componente Noticias ha sido añadido correctamente.',

	# Errors
	'err_title_too_short' => 'Título demasido corto.',
	'err_msg_too_short' => 'Mensaje demasiado corto.',

	# Main
	'title' => 'Noticias de '.GWF_SITENAME,
	//'info' => 'Nuestra contribución a su éxito no debería limitarse sólo a los productos.<br/>Una parte de nuestro conocimiento está disponible aquí.<br/>Algunos artículos están sólo disponibles para usuarios registrados.',
	'pt_news' => GWF_SITENAME.' Noticia de %s',
	'mt_news' => 'Noticias, '.GWF_SITENAME.', %s',
	'md_news' => 'Noticias '.GWF_SITENAME.', página %s de %s.',

	# Table Headers
	'th_email' => 'Email',
	'th_type' => 'Formato de boletín informativo',
	'th_langid' => 'Idioma de noticia',
	'th_category' => 'Categoría',
	'th_catid' => 'Categoría',
	'th_title' => 'Título',
	'th_message' => 'Mensaje',
	'th_newsletter' => 'Enviar boletín<br/>Por favor, revisar y previsualizar antes',
	'th_date' => 'Fecha',
	'th_userid' => 'Usario',

	# Preview
	'btn_preview_text' => 'Previsualizar versión texto',
	'btn_preview_html' => 'Previsualizar versión HTML',
	'preview_info' => 'Puede previsualizar boletines aquí:<br/>%s y %s.',

	# Show 
	'unknown_user' => 'Usuario desconocido',
	'title_no_news' => ' ---- ',
	'msg_no_news' => 'Todavía no hay noticias en esta categoría.',

	# Newsletter
	'newsletter_title' => GWF_SITENAME.': Noticias',
	'anrede' => 'Estimado/a %s',
	'newsletter_wrap' =>
		'%s, '.PHP_EOL.
		PHP_EOL.
		'Se inscribió al boletín informativo y hay noticias nuevas para usted.'.PHP_EOL.
		'Para anular la suscripción al boletín, siga el enlace siguiente:'.PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'El artículo del boletín es:'.PHP_EOL.
		PHP_EOL.
		'<hr/>'.PHP_EOL.
		PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'%s'.PHP_EOL,

	# Types
	'type_none' => 'Elegir formato',
	'type_text' => 'Texto plano',
	'type_html' => 'HTML simple',
		
	# Sign
	'sign_title' => 'Suscribir a las noticias',
	'sign_info_none' => 'No está conectado o no se inscribió al boletín todavía.',
	'ft_sign' => 'Suscribir a las noticias',
	'btn_sign' => 'Suscribir',
		
	# Add
	'ft_add' => 'Añadir nueva entrada',
	'btn_add' => 'Añadir noticias',
	'btn_preview' => 'Previsualizar (¡Primero!)',
		
	# Admin Config
	'cfg_newsletter_guests' => 'Permitir a los invitados suscribirse al boletín',
	'cfg_news_per_adminpage' => 'Noticias por página de administración',
	'cfg_news_per_box' => 'Noticias por inline-box',
	'cfg_news_per_page' => 'Noticias por página de noticias',
	'cfg_newsletter_mail' => 'Enviar mail de boletín',

# News v2.01 (refinish)
	'msg_translated' => 'Tradujo la noticia de \'%s\' a %s. Bien hecho.',
	'msg_edited' => 'La noticia \'%s\' de %s ha sido editada.',
	'msg_hidden_1' => 'La noticia está ahora oculta.',
	'msg_hidden_0' => 'La noticia es ahora visible.',
	'msg_mailme_1' => 'La noticia ha sido añadida a la cola de envíos de correo.',
	'msg_mailme_0' => 'La noticia ha sido eliminada de la cola de envíos de correo.',
	'msg_signed' => 'Se ha dado de alta en el boletín.',
	'msg_unsigned' => 'Se ha dado de baja del boletín.',
	'msg_changed_type' => 'Ha cambiado el formato de su suscripción al boletín.',
	'msg_changed_lang' => 'Ha cambiado su idioma preferido de su suscripción al boletín.',
		
	'cfg_newsletter_sleep' => 'Dormir N milisegundos después de cada correo',
	'cfg_news_per_feed' => 'Noticias por página',
		
	# RSS2 Feed
	'rss_title' => GWF_SITENAME.' Feed de noticias',

		
	# Edit
	'ft_edit' => 'Editar noticias (en %s)',
	'btn_edit' => 'Editar',
	'btn_translate' => 'Traducir',
	'th_transid' => 'Traducción',
	'th_mail_me' => 'Enviar como boletín',
	'th_hidden' => '¿Ocultar?',
		
	# News v2.02 (refinish 2)
	'btn_unsign' => 'Darse de baja del boletín',
	'err_email' => 'Su email no es válido.',
	'err_news' => 'Esta noticia es desconocida.',
	'err_langtrans' => 'Este idioma no es soportado.',
	'err_lang_src' => 'El idioma origen es desconocido.',
	'err_lang_dest' => 'El idioma destino es desconocido.',
	'err_equal_translang' => 'El idioma origen y destino es el mismo (Ambos %s).',
	'err_type' => 'El formato del boletín no es válido.',
	'err_unsign' => 'Ocurrió un error.',
	'sign_info_login' => 'No esta identificado, así que no podemos confirmar si ya está suscrito al boletín.',
	'sign_info_html' => 'Ya está suscrito al boletín en formato html simple.',
	'sign_info_text' => 'Ya está suscrito al boletín en formato texto plano.',		

	# V2.03 (News + Forum)
	'cfg_news_in_forum' => 'Publicar noticias en el foro',
	'board_lang_descr' => 'Noticias en %s',
	'btn_admin_section' => 'Sección Admin',
	'th_hidden' => 'Oculto',
	'th_visible' => 'Visible',
	'btn_forum' => 'Discutir en el foro',
);

?>
