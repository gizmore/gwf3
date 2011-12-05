<?php
$lang = array(
	# page.php
	'pt_chat' => 'Sala de chat',
	'pi_chat' => 'Bienvenido a la sala de charla ' . GWF_SITENAME . '.',
	'ft_chat' => 'Enviar mensaje',
	'mt_chat' => GWF_SITENAME.', Realtime, Web, Chat, Firefox, Ajax, BSD',
	'md_chat' => GWF_SITENAME.'. Webchat en tiempo real basado en Ajax, BDS-Like. Necesita JavaScript y funciona mejor con Netscape.',

	# history.php
	'pt_history' => 'Historial de charla',
	'pi_history' => 'Historial de charla ' . GWF_SITENAME,
	'mt_history' => GWF_SITENAME.', Chat, Javascript, Realtime, HTTP push, Firefox, Netscape, HTTP, Ajax, Chat',
	'md_history' => 'Historial de charla',
	
	# Buttons
	'btn_history' => 'Mostrar el historial',

	# Errors
	'err_msg_short' => 'Olvidó su mensaje.',
	'err_msg_long' => 'Su mensaje excede la longitud máxima de %s.',
	'err_private' => 'Los mensajes privados estan actualmente deshabilidatos.',
	'err_guest_public' => 'Los invitados no tienen permiso para publicar en el canal público.',
	'err_guest_private' => 'Los invitados no pueden enviar mensajes a otros usuarios.',
	'err_target' => ' Destino desconocido. Deja en blanco para mensajes públicos.',
	'err_target_invalid' => 'El destino no es válido. No está autorizado para enviar mensajes a ti mismo.',
	'err_nick_syntax' => 'Su apodo escogido no es válido.', # we could be more verbose
	'err_nick_taken' => 'Su apodo escogido ya está en uso.',
	'err_nick_tamper' => 'Por favor, no trate de cambiar su apodo de invitado, estúpido!',
	
	# Messages
	'msg_posted' => 'Su mensaje ha sido enviado.',

	# Table Headers
	'th_yournick' => 'Apodo',
	'th_message' => 'Mensaje',
	'th_target' => 'Destinatario',

	# Tooltips
	'tt_target' => 'Dejar en blanco para el canal',

	'btn_post' => 'Enviar',

	# v2.01 (Mibbit+finish)
	'cfg_bbcode' => 'Permitir BBCode',
	'cfg_chat_menu' => 'Mostrar en el menú',
	'cfg_chat_submenu' => 'Mostrar en el submenú',
	'cfg_guest_private' => 'Permitir a los invitados mensajes privados',
	'cfg_guest_public' => 'Permitir a los invitados mensajes públicos',
	'cfg_mibbit' => 'Usar Mibbit',
	'cfg_private' => 'Permitir charla privada',
	'cfg_chanmsg_per_page' => 'Mensajes públicos por página',
	'cfg_histmsg_per_page' => 'Mensajes por página de historial',
	'cfg_msg_len' => 'Longitud máxima del mensaje',
	'cfg_privmsg_per_page' => 'Mensajes privados por página',
	'cfg_mibbit_channel' => 'Canal Mibbit',
	'cfg_mibbit_server' => 'Servidor Mibbit',
	'cfg_chat_lag_ping' => 'Actualizar después de N segundos',
	'cfg_message_peak' => 'Los mensajes desaparecen después de ',
	'cfg_online_time' => 'Tiempo de espera en línea',

	'btn_webchat' => 'Web-Chat ',
	'btn_ircchat' => 'IRC-Chat ',
	'btn_ircchat_full' => 'IRC Pantalla completa',
	'pt_irc_chat' => 'IRC Chat',
	'pi_irc_chat' => 'IRC WebChat patrocinado por <a>Mibbit</a>.',
	'mt_irc_chat' => GWF_SITENAME.',IRC,Chat,WebChat',
	'md_irc_chat' => 'Habla con '.GWF_SITENAME.' visitantes y miembros.',
	'err_iframe' => 'Su navegador no soporta iframes.',

	# v2.02 (fixes)
	'cfg_gwf_chat' => 'Usar Webchat GWF',

	# v2.03 (Mibbit SSL)
	'cfg_mibbit_ssl' => 'Usar SSL para el Chat IRC Mibbit',
	'cfg_mibbit_port' => 'Puerto para el Chat IRC Mibbit',
);
?>