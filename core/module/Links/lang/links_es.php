<?php
$lang = array(
    # Admin Config
    'cfg_link_guests' => 'Permitir a los invitados agregar enlaces',
    'cfg_link_guests_captcha' => 'Mostrar CAPTCHA a los invitados?',
    'cfg_link_guests_mod' => 'Moderar enlaces de los invitados?',
    'cfg_link_guests_votes' => 'Permitir a los invitados votar?',
    'cfg_link_long_descr' => 'Usar una segunda descripción larga?',
    'cfg_link_cost' => 'Calificación por enlace',
    'cfg_link_max_descr2_len' => 'Máx Longitud Descr. Larga.',
    'cfg_link_max_descr_len' => 'Máx Longitud Descr. Pequeña.',
    'cfg_link_max_tag_len' => 'Máx Longitud Etiqueta',
    'cfg_link_max_url_len' => 'Máx Longitud URL',
    'cfg_link_min_descr2_len' => 'Mín Longitud Descr. Larga.',
    'cfg_link_min_descr_len' => 'Mín Longitud Descr. Pequeña.',
    'cfg_link_min_level' => 'Nivel mínimo para agregar Enlace',
    'cfg_link_per_page' => 'Enlaces por página',
    'cfg_link_tag_min_level' => 'Nivel mínimo para agregar Etiqueta',
    'cfg_link_vote_max' => 'Puntuación máxima',
    'cfg_link_vote_min' => 'Puntuación mínima',
    'cfg_link_guests_unread' => 'Duración del nuevo enlace para los invitados',

    # Info`s
//	'pi_links' => '',
    'info_tag' => 'Especifica por lo menos una etiqueta. Separa las etiquetas por coma. Prueba usando estas etiquetas:',
    'info_newlinks' => 'Hay %s nuevos enlaces para usted.',
    'info_search_exceed' => 'Tu búsqueda excedió los limites de %s.',

    # Titles
    'ft_add' => 'Agregar un enlace',
    'ft_edit' => 'Editar enlace',
    'ft_search' => 'Buscar los enlaces',
    'pt_links' => 'Todos los enlaces',
    'pt_linksec' => '%s enlaces',
    'pt_new_links' => 'Nuevos enlaces',
    'mt_links' => GWF_SITENAME.', Enlace, Listar, Todos los enlaces',
    'md_links' => 'Todos los enlaces en '.GWF_SITENAME.'.',
    'mt_linksec' => GWF_SITENAME.', Enlace, Listar, Enlaces acerca de %s',
    'md_linksec' => '%s enlaces en '.GWF_SITENAME.'.',

    # Errors
    'err_gid' => 'El grupo de usuario es inválido.',
    'err_score' => 'Valor inválido para la calificación.',
    'err_no_tag' => 'Por favor especifica al menos una etiqueta.',
    'err_tag' => 'La etiqueta %s es inválida y fue removida. La etiqueta debe ser %s - %s bytes.',
    'err_url' => 'La URL parece inválida.',
    'err_url_dup' => 'La URL ya se encuentra listada acá.',
    'err_url_down' => 'La URL no es accesible.',
    'err_url_long' => 'La URL es demasiado larga. Máx %s bytes.',
    'err_descr1_short' => 'La descripción es demasiado corta. Mín %s bytes.',
    'err_descr1_long' => 'La descripción es demasiado larga. Máx %s bytes.',
    'err_descr2_short' => 'La descripción detallada es demasiado corta. Mín %s bytes.',
    'err_descr2_long' => 'La descripción detallada es demasiado larga. Mín %s bytes.',
    'err_link' => 'Enlace no encontrado.',
    'err_add_perm' => 'No estás autorizado para agregar un enlace.',
    'err_edit_perm' => 'No estás autorizado para editar este enlace.',
    'err_view_perm' => 'No estás autorizado para ver este enlace.',
    'err_add_tags' => 'No estás autorizado para agregar nuevas etiquetas.',
    'err_score_tag' => 'Tu nivel de usuario (%s) no es lo suficientemente alto para agregar otra etiqueta. Nivel requerido: %s.',
    'err_score_link' => 'Tu nivel de usuario (%s) no es lo suficientemente alto para agregar otro enlace. Nivel requerido: %s.',
    'err_approved' => 'El enlace ya fue aprobado. Por favor usa la sección de staff para tomar acciones.',
    'err_token' => 'El token es inválido.',

    # Messages
//	'msg_redirecting' => 'Redirecting you to %s.',
    'msg_added' => 'Tu enlace fue agregado a la base de datos.',
    'msg_added_mod' => 'Tu enlace fue agregado a la base de datos, pero debe ser primero verificado por un Moderador.',
    'msg_edited' => 'El enlace ha sido editado.',
    'msg_approved' => 'El enlace ha sido aprobado y ahora es mostrado.',
    'msg_deleted' => 'El enlace ha sido eliminado.',
    'msg_counted_visit' => 'Tu clic ha sido contado.',
    'msg_marked_all_read' => 'Todos los enlaces marcados como leídos.',
    'msg_fav_no' => 'El enlace ha sido removido de tu lista de favoritos.',
    'msg_fav_yes' => 'El enlace ha sido puesto en tu lista de favoritos.',

    # Table Headers
    'th_link_score' => 'Calificación',
    'th_link_gid' => 'Grupo',
    'th_link_tags' => 'Etiquetas',
    'th_link_href' => 'HREF',
    'th_link_descr' => 'Descripción',
    'th_link_descr2' => 'Descripción detallada',
    'th_link_options&1' => 'Sticky?',
    'th_link_options&2' => 'En moderación?',
    'th_link_options&4' => 'No mostrar nombre de usuario?',
    'th_link_options&8' => 'Mostrar solo a miembros?',
    'th_link_options&16' => 'Este enlace es privado?',
    'th_link_id' => 'ID',
    'th_showtext' => 'Enlace',
    'th_favs' => 'Favoritos',
    'th_link_clicks' => 'Visitas',
    'th_vs_avg' => 'Prom',
    'th_vs_sum' => 'Suma',
    'th_vs_count' => 'Votos',
    'th_vote' => 'Votar',
    'th_link_date' => 'Insertar fecha',
    'th_user_name' => 'Nombre de usuario',
    'th_link_lang' => 'Seleccione un lenguaje',

    # Tooltips
    'tt_link_gid' => 'Restringir enlace a un grupo de usuarios (o dejar en blanco)',
    'tt_link_score' => 'Especificar el nivel mínimo de usuario (0 - NNNN)',
    'tt_link_href' => 'Enviar la URL completa, empezando con http://',

    # Buttons
    'btn_add' => 'Agregar enlace',
    'btn_delete' => 'Eliminar enlace',
    'btn_edit' => 'Editar enlace',
    'btn_search' => 'Buscar',
    'btn_preview' => 'Vista previa',
    'btn_new_links' => 'Nuevos enlaces',
    'btn_mark_read' => 'Marcar todos como leídos',
    'btn_favorite' => 'Marcar como enlace favorito',
    'btn_un_favorite' => 'Desmarcar enlace favorito',
    'btn_search_adv' => 'Búsqueda avanzada',

    # Staff EMail
    'mail_subj' => GWF_SITENAME.': Nuevo enlace',
    'mail_body' =>
        'Querido Staff,'.PHP_EOL.
        PHP_EOL.
        'Un nuevo enlace que necesita moderación ha sido publicado por un invitado:'.PHP_EOL.
        PHP_EOL.
        'Descripción: %s'.PHP_EOL.
        'Descripción detallada.: %s'.PHP_EOL.
        'HREF / URL : %s'.PHP_EOL.
        PHP_EOL.
        'Usted puede: '.PHP_EOL.
        '1) Aprobar este enlace visitando %s'.PHP_EOL.
        'Or:'.PHP_EOL.
        '2) Eliminar este enlace visitando %s'.PHP_EOL.
        PHP_EOL.
        'Saludos,'.PHP_EOL.
        'El Script '.GWF_SITENAME.PHP_EOL,

    # v2.01 (SEO)
    'pt_search' => 'Buscar enlaces',
    'md_search' => 'Buscar enlaces en el sitio '.GWF_SITENAME,
    'mt_search' => 'Búsqueda,'.GWF_SITENAME.',Enlaces',

    # v2.02 (permitted)
    'permtext_in_mod' => 'Este enlace se encuentra en moderación',
    'permtext_score' => 'Necesitas un nivel de usuario de %s para ver este enlace',
    'permtext_member' => 'Este enlace es solo para miembros',
    'permtext_group' => 'Necesitas pertenecer al grupo %s para ver este enlace',
    'cfg_show_permitted' => 'Mostrar razón para enlace prohibido?',

    # v3.00 (fixes)
    'cfg_link_check_amt' => 'Cantidad UpDownChecker',
    'cfg_link_check_int' => 'Intervalo UpDownChecker',
);
