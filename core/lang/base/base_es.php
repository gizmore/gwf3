<?php
$lang = array(
	'ERR_DATABASE' => 'Error de la base de datos en el archivo %s línea %s.',
	'ERR_FILE_NOT_FOUND' => 'Archivo no encontrado: %s',
	'ERR_MODULE_DISABLED' => 'El módulo %s está actualmente deshabilitado.',
	'ERR_LOGIN_REQUIRED' => 'Necesita acceder a su cuenta para ejecutar esta acción.',
	'ERR_NO_PERMISSION' => 'Permiso denegado.',
	'ERR_WRONG_CAPTCHA' => 'Tiene que escribir las letras de la imagen correctamente.',
	'ERR_MODULE_MISSING' => 'No se pudo encontrar el módulo %s.',
	'ERR_COOKIES_REQUIRED' => 'El tiempo de su sesión expiró o necesita activar las cookies en su navegador.<br />Por favor, intente actualizar la página.',
	'ERR_UNKNOWN_USER' => 'El usuario es desconocido.',
	'ERR_UNKNOWN_GROUP' => 'El grupo es desconocido.',
	'ERR_UNKNOWN_COUNTRY' => 'El país es desconocido.',
	'ERR_UNKNOWN_LANGUAGE' => 'Ese idioma es desconocido.',
	'ERR_METHOD_MISSING' => 'Método desconocido: %s en módulo %s.',
	'ERR_GENERAL' => 'Error indefinido en %s línea %s.',
	'ERR_WRITE_FILE' => 'No se puede escribir archivo: %s.',
	'ERR_CLASS_NOT_FOUND' => 'Clase desconocida: %s.',
	'ERR_MISSING_VAR' => 'Variable HTTP POST perdida: %s.',
	'ERR_MISSING_UPLOAD' => 'Tiene que subir un archivo.',
	'ERR_MAIL_SENT' => 'Ocurrió un error al enviarle un email.',
	'ERR_CSRF' => 'Su token de formulario es incorrecto. Quizá lo envió dos veces, o durante el proceso se terminó el tiempo de su sesión.',
	'ERR_HOOK' => 'Un gancho devolvió valor falso: %s.',
	'ERR_PARAMETER' => 'Argumento no válido en %s línea %s. El argumento de la función %s no es válido.',
	'ERR_DEPENDENCY' => 'Dependencia sin resolver: core/module/%s/method/%s requiere módulo %s v%s.',
	'ERR_SEARCH_TERM' => 'El término de búsqueda debe tener entre %s y %s carácteres de longitud.',
	'ERR_SEARCH_NO_MATCH' => 'Su búsqueda de "%s" no encontró resultados.',
	'ERR_POST_VAR' => 'Variable POST inesperada: %s.',
	'ERR_DANGEROUS_UPLOAD' => 'Your uploaded file contains &quot;&lt;?&quot; which is considered dangerous and denied.',

	# GWF_Time
	'unit_sec_s' => 's',
	'unit_min_s' => 'm',
	'unit_hour_s' => 'h',
	'unit_day_s' => 'd',
	'unit_month_s' => 'M',
	'unit_year_s' => 'A',
	'M1' => 'Enero',
	'M2' => 'Febrero',
	'M3' => 'Marzo',
	'M4' => 'Abril',
	'M5' => 'Mayo',
	'M6' => 'Junio',
	'M7' => 'Julio',
	'M8' => 'Agosto',
	'M9' => 'Septiembre',
	'M10' => 'Octubre',
	'M11' => 'Noviembre',
	'M12' => 'Diciembre',
	'm1' => 'Ene',
	'm2' => 'Feb',
	'm3' => 'Mar',
	'm4' => 'Abr',
	'm5' => 'May',
	'm6' => 'Jun',
	'm7' => 'Jul',
	'm8' => 'Ago',
	'm9' => 'Sep',
	'm10' => 'Oct',
	'm11' => 'Nov',
	'm12' => 'Dic',
	'D0' => 'Domingo',
	'D1' => 'Lunes',
	'D2' => 'Martes',
	'D3' => 'Miércoles',
	'D4' => 'Jueves',
	'D5' => 'Viernes',
	'D6' => 'Sábado',
	'd0' => 'Dom',
	'd1' => 'Lun',
	'd2' => 'Mar',
	'd3' => 'Mie',
	'd4' => 'Jue',
	'd5' => 'Vie',
	'd6' => 'Sab',
	'ago_s' => 'hace %s segundos',
	'ago_m' => 'hace %s minutos',
	'ago_h' => 'hace %s horas',
	'ago_d' => 'hace %s días', 

	###
	### TODO: GWF_DateFormat, is problematic, because en != en [us/gb]
	###
	### Here you have to specify how a default dateformats looks for different languages.
	### You have the following substitutes:
	### Year:   Y=1990, y=90
	### Month:  m=01,   n=1,  M=January, N=Jan
	### Day:    d=01,   j=1,  l=Tuesday, D=Tue
	### Hour:   H:23    h=11
	### Minute: i:59
	### Second: s:59
	'df4' => 'Y', # 2009
	'df6' => 'M Y', # January 2009
	'df8' => 'D, M j, Y', # Tue, January 9, 2009
	'df10' => 'M d, Y - H:00', # January 09, 2009 - 23:00
	'df12' => 'M d, Y - H:i',  # January 09, 2009 - 23:59
	'df14' => 'M d, Y - H:i:s',# January 09, 2009 - 23:59:59

	'datecache' => array(
		array('Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'),
		array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'),
		array('Dom','Lun','Mar','Mie','Jue','Vie','Sab'),
		array('Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'),
		array(4=>'Y', 6=>'M Y', 8=>'D, M j, Y', 10=>'M d, Y - H:00', 12=>'M d, Y - H:i', 14=>'M d, Y - H:i:s'),
	),

	# GWF_Form
	'th_captcha1' => '<a href="http://es.wikipedia.org/wiki/Captcha">Captcha</a>', # Click en la imagen para recargar.', 
	'th_captcha2' => 'Escriba las 5 letras de la imagen Captcha',
	'tt_password' => 'Las contraseñas deben tener al menos 8 carácteres de longitud.',
	'tt_captcha1' => 'Clic en la imagen Captcha para obtener una nueva.',
	'tt_captcha2' => 'Redigite la imagen para probar que es humano.',
	# GWF_Category 
	'no_category' => 'Todas las categorías',
	'sel_category' => 'Seleccione categoría',
	# GWF_Language
	'sel_language' => 'Seleccione un idioma',
	'unknown_lang' => 'Idioma desconocido',
	# GWF_Country
	'sel_country' => 'Seleccione un país',
	'unknown_country' => 'País desconocido',
	'alt_flag' => '%s',
	# GWF_User#gender
	'gender_male' => 'Masculino',
	'gender_female' => 'Femenino',
	'gender_no_gender' => 'Sexo desconocido',
	# GWF_User#avatar
	'alt_avatar' => 'Ávatar de %s',
	# GWF_Group 
	'sel_group' => 'Seleccione grupo de usuario',
	# Date select 
	'sel_year' => 'Seleccione año',
	'sel_month' => 'Seleccione mes',
	'sel_day' => 'Seleccione día',
	'sel_older' => 'Mayor que',
	'sel_younger' => 'Menor que',
	### General Bits! ###
	'guest' => 'Invitado',
	'unknown' => 'Desconocido',
	'never' => 'Nunca',
	'search' => 'Buscar',
	'term' => 'Término',
	'by' => 'por',
	'and' => 'y',
	
	'alt_flag' => 'Bandera de %s',

	# v2.01 (copyright)
	'copy' => '&copy; %s '.GWF_SITENAME.'. Todos los derechos reservados.',
	'copygwf' => GWF_SITENAME.' está usando <a href="http://gwf.gizmore.org">GWF</a>, the BSD-Like Website Framework.',

	# v2.02 (recaptcha+required_fields)
	'form_required' => '%s es requerido.',

	# v2.03 BBCode
	'bbhelp_b' => 'negrilla',
	'bbhelp_i' => 'cursiva',
	'bbhelp_u' => 'subrayado',
	'bbhelp_code' => 'El código va acá',
	'bbhelp_quote' => 'Este texto es una cita',
	'bbhelp_url' => 'Texto del enlace',
	'bbhelp_email' => 'Texto del enlace del email',
	'bbhelp_noparse' => 'Deshabilitar decodificación BB acá.',
	'bbhelp_level' => 'Texto que necesita un nivel mínimo de usuario para ser visto.',
	'bbhelp_spoiler' => 'Texto invisible que es mostrado con un clic.',

	# v2.04 BBCode3
	'quote_from' => 'Cita de %s',
	'code' => 'código',
	'for' => 'para',

	# 2.05 Bits
	'yes' => 'Sí',
	'no' => 'En',

	# 2.06 spoiler
	'bbspoiler_info' => 'Click para revelar',

	# 3.00 Filesize
	'filesize' => array('B','KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'YB', 'ZB'),
	'err_bb_level' => 'You need a userlevel of %s to see this content.',
);
?>