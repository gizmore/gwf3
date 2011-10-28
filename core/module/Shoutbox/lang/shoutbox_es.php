<?php
$lang = array(
	# Box
	'box_title' => GWF_SITENAME.' Shoutbox',

	# History
	'pt_history' => GWF_SITENAME.' Shoutbox Historia (Page %1$s / %2$s)',
	'pi_history' => 'The '.GWF_SITENAME.' Shoutbox',
	'mt_history' => GWF_SITENAME.', Shoutbox, Historia',
	'md_history' => 'The '.GWF_SITENAME.' shoutbox es para pequeños mensajes que no valen hilo de un foro.',

	# Errors
	'err_flood_time' => 'Por favor, espere antes de gritar de nuevo.',
	'err_flood_limit' => 'Ha superado usted límite de mensajes al día.',
	'err_message' => 'Usted mensaje tiene que ser entre %1$s y el %2$s caracteres de largo.',
	
	# Messages
	'msg_shouted' => 'Grito con éxito.<br/>Go back to <a href="%1$s">%1$s</a>.',
	'msg_deleted' => 'Un mensaje ha sido borrado.',

	# Table Heads
	'th_shout_date' => 'Fecha',
	'th_shout_uname' => 'Usario',
	'th_shout_message' => 'Mensaje',

	# Buttons
	'btn_delete' => 'Borrar',
	'btn_shout' => 'Shout!',

	# Admin config
	'cfg_sb_guests' => 'Postes de la invitado',	
	'cfg_sb_ipp' => 'Propia historia',
	'cfg_sb_ippbox' => 'Objetos por línea',
	'cfg_sb_maxlen' => 'Max. mensaje de longitud',
	'cfg_sb_maxdayg' => 'Máximo de mensajes por día para los invitados',
	'cfg_sb_maxdayu' => 'Máximo de mensajes al día para los miembros',
	'cfg_sb_timeout' => 'Tiempo de espera de entre 2 mensajes',

	# v1.01 (EMail moderation)
	'cfg_sb_email_moderation' => 'EMail moderation',
	'emod_subj' => GWF_SITENAME.': New shoutbox entry',
	'emod_body' =>
		'Dear staff,'.PHP_EOL.
		''.PHP_EOL.
		'There is a new entry in the shoutbox.'.PHP_EOL.
		''.PHP_EOL.
		'From: %1$s'.PHP_EOL.
		'%2$s'.PHP_EOL.
		''.PHP_EOL.
		'You can delete it via %3$s'.PHP_EOL.
		''.PHP_EOL.
		'Regards'.PHP_EOL.
		'The GWF3 script',
);
?>
