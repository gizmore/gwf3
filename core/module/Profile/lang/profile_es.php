<?php

$lang = array(
	# Page Titles
	'pt_profile' => '%s`s perfil',
	'pt_settings' => 'Configuración del perfil',

	# Meta Tags
	'mt_profile' => '%s`s perfil, '.GWF_SITENAME.', %s, Perfil',
	'mt_settings' => GWF_SITENAME.', perfil, Configuracion, Editar, Contacto, Data',

	# Meta Description
	'md_profile' => '%s`s perfil en '.GWF_SITENAME.'.',
	'md_settings' => 'Usted configuracion del perfil en'.GWF_SITENAME.'.',

	# Info
	'pi_help' =>
		'Para subir una imagen, utilice la configuración de la cuenta principal.<br/>'.
		'Para añadir una firma a los mensajes del foro, usa el foro ajustes.<br/>'.
		'También módulos PM y otros tienen sus propias páginas, separadas de establecimiento.<br/>'.
		'<b> Todos los ajustes son visibles a los seres humanos </b>.<br/>'.
		'Si oculta usted email, revise usted configuración de la cuenta, ya que hay una bandera mundial email también.<br/>'.
		'Es posible ocultar usted perfil de clientes o de los motores de búsqueda.',

	# Errors
	'err_hidden' => 'El Usuario `s perfil está oculto.',
	'err_firstname' => 'Usted llama no es válida. Longitud máxima: %s caracteres.',
	'err_lastname' => 'Usted Nombre de última no es válida. Longitud máxima: %s caracteres.',
	'err_street' => 'Usted calle no es válido. Longitud máxima: %s caracteres.',
	'err_zip' => 'Usted código postal no es válida. Longitud máxima: %s caracteres.',
	'err_city' => 'Usted ciudad no es válida. Longitud máxima: %s caracteres.',
	'err_tel' => 'Usted número de teléfono no es válido. Longitud máxima: %s caracteres.',
	'err_mobile' => 'Usted Número de teléfono móvil no es válida.',
	'err_icq' => 'Usted ICQ UIN no es válida. Longitud máxima: 16 números.',
	'err_msn' => 'Usted MSN es válido.',
	'err_jabber' => 'Usted Jabber no es válido.',
	'err_skype' => 'Usted Skype nombre es válido. Longitud máxima: %s caracteres.',
	'err_yahoo' => 'Usted Yahoo! no es válido. Longitud máxima: %s caracteres.',
	'err_aim' => 'Usted AIM no es válida. Longitud máxima: %s caracteres.',
	'err_about_me' => 'Usted &quot;About Me&quot; no es válido. Longitud máxima: %s caracteres.',
	'err_website' => 'Usted sitio web es accesible o no existe.',

	# Messages
	'msg_edited' => 'Usted perfil ha sido editado.',

	# Headers
	'th_user_name' => 'Usario',
	'th_user_level' => 'Nivel',
	'th_user_avatar' => 'Avatar',
	'th_gender' => 'Género',
	'th_firstname' => 'Nombre',
	'th_lastname' => 'Apellido',
	'th_street' => 'Calle',
	'th_zip' => 'Código postal',
	'th_city' => 'Ciudad',
	'th_website' => 'Página web',
	'th_tel' => 'Teléfono',
	'th_mobile' => 'Móvil',
	'th_icq' => 'ICQ',
	'th_msn' => 'MSN',
	'th_jabber' => 'Jabber',
	'th_skype' => 'Skype',
	'th_yahoo' => 'Yahoo!',
	'th_aim' => 'AIM',
	'th_about_me' => 'Acerca de ti mismo',
	'th_hidemail' => '¿Ocultar email en el perfil?',
	'th_hidden' => 'Ocultar Perfil de invitados',
	'th_level_all' => 'Min Nivel Todos',
	'th_level_contact' => 'Min Nivel Contacto',
	'th_hidecountry' => '¿Ocultar tu país?',
	'th_registered' => 'Registro Fecha',
	'th_last_active' => 'Última actividad',
	'th_views' => 'Vistas de perfil',

	# Form Titles
	'ft_settings' => 'Edita tu perfil',

	# Tooltips
	'tt_level_all' => 'Mínimo Nivel de Usuario para ver usted perfil',
	'tt_level_contact' => 'Mínimo Nivel de Usuario para ver sus datos de contacto',

	# Buttons
	'btn_edit' => 'Edita tu perfil',

	# Admin Config
	'cfg_prof_hide' => 'Permitir ocultar perfiles?',
	'cfg_prof_max_about' => 'Longitud máxima de &quot;About Me&quot;',

	# V2.01 (Hide Guests)
	'th_hideguest' => '¿Ocultar de invitados?',

	# v2.02 (fixes)
	'err_level_all' => 'Tu nivel mínimo de usuario para ver tu perfil es inválido.',
	'err_level_contact' => 'Tu nivle de usuario mínimo para ver tus datos de contacto es inválido.',
	# v2.03 (fixes2)
	'title_about_me' => 'Sobre %s',
	# v2.04 (ext. profile)
	'th_user_country' => 'País',
	'btn_pm' => 'PM',
	# v2.05 (more fixes)
	'at_mailto' => 'Enviar email a %s',
	'th_email' => 'EMail',
	# v2.06 (birthday)
	'th_age' => 'Edad',
	'th_birthdate' => 'Cumpleaños',
	# v2.07 (IRC+Robots)
	'th_irc' => 'IRC ',
	'th_hiderobot' => '¿Ocultar de buscadores web?',
	'tt_hiderobot' => 'Marca esto si no quieres que tu perfil sea indexado por los buscadores.',
	'err_no_spiders' => '¿Ocultar de buscadores?',

	# monnino fixes
	'cfg_prof_level_gb' => 'Minimum level to create a guestbook in the profile',

	# v2.08 (POI)
	'ph_places' => 'Points of Interest',
	'msg_white_added' => 'Successfully added %s to your POI whitelist.',
	'msg_white_removed' => 'Successfully removed %s user(s) from your POI whitelist.',
	'msg_pois_cleared' => 'All your Point of Interest data has been cleared.',
	'msg_white_cleared' => 'Your whitelist has been wiped.',
	'err_poi_read_perm' => 'You are not allowed to see POI.',
	'err_poi_exceed' => 'You cannot add more POI yet.',
	'err_self_whitelist' => 'You cannot whitelist yourself.',
	'prompt_rename' => 'Please enter a description.',
	'prompt_delete' => 'Do you want to remove this Point of Interest?',
	'th_poi_score' => 'Minimum user level to see your POI',
	'tt_poi_score' => 'You can hide your Points of Interest from users whose user level is too low.',
	'th_poi_white' => 'Use <a href="%s">whitelist</a> for POI',
	'tt_poi_white' => 'Instead of level based restrictions use your own POI whitelist.',
	'ft_add_whitelist' => 'Add a user to your whitelist',
	'ft_clear_pois' => 'Remove all POI you have created or clear the whitelist.',
	'th_date_added' => 'added on',
	'btn_clear_pois' => 'Clear POI data',
	'btn_clear_white' => 'Clear whitelist',
	'btn_add_whitelist' => 'Add user',
	'btn_rem_whitelist' => 'Remove user',
	'poi_info' => 'This page shows POI entered by the users.<br/>You are allowed to add %s/%s Points Of Interest.<br/>You can protect your POI by either <a href="%s">requirering a minimum userlevel</a>, or by using a <a href="%s">personal whitelist</a>.<br/>By default your POI are public.',
	'poi_usage' => 'Usage',
	'poi_usage_data' => array(
		'A click on an empty space adds a new POI.',
		'A doubleclick on your own POI deletes them.',
		'A click on your own POI renames them.',
		'Please do not add the homes of other users by any means.',
	),
	'poi_helper' => 'Places Application',
	'btn_poi_init' => 'Start Places',
	'btn_poi_init_sensor' => 'Start Places with my current location',
	'ph_poi_jump' => 'Jump to an address',
	'err_poi_jump' => 'The address could not been found.',
	'poi_privacy_t' => 'Privacy gotchas',
	'poi_privacy' => 'I bet some are worried about privacy and refuse to use this page.<br/>Your country coordinates currently occur in apache and gwf logfiles.<br/>Google probably records your requests as well.<br/>Beside these evil problems this server is trying to not make a connection to your location.<br/>gwf logfiles are removed from the server regularly and the apache logs only connect IPs with your requests.<br/>The POI database only stores your POI data you can choose on your own and nothing else.',
	'poi_stats_t' => 'POI Statistics',
	'poi_stats' => 'There are %s POI in the database wheras %s are visible to you.',
);
