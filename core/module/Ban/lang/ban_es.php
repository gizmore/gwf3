<?php
$lang = array(
	# Form Titles
	'ft_add_ban' => 'Vetar / Advertir a usuario',
	'fi_add_ban' => 'Advertir o vetar a un usuario. Para vetar, marque la casilla vetar, y elija veto permanente o la fecha de finalización.',

	# Table Headers
	'th_user_name' => 'Nombre de usuario',		
	'th_ban_msg' => 'Mensaje',
	'th_ban_ends' => 'Finalización',
	'th_ban_perm' => 'Permanente',
	'th_ban_type' => 'Tipo',
	'th_ban_type2' => 'Vetar',
	'th_ban_date' => 'Fecha',

	# Tooltips
	'tt_ban_ends' => 'Sólo es necesario para la prohibición temporal. Tiene que chequear la casilla de verificación.',
	'tt_ban_perm' => 'Permanente, ignorar fecha finalización',
	'tt_ban_type' => 'Advertir o activar para vetar',

	# Buttons
	'btn_add_ban' => 'Vetar / Advertir',

	# Errors
	'err_perm_or_date' => 'Elija fecha de finalización o haga permanente el veto.',
	'err_msg' => 'Olvidó el mensaje.',
	'err_ends' => 'La fecha de finalización es incorrecta.',

	# Messages
	'msg_permbanned' => 'El usuario% 1% se vetó de manera permanente.',
	'msg_tempbanned' => 'El usuario% 1% se veta hasta %2$s',
	'msg_warned' => 'El usuario %1$s fue advertido.',
	'msg_marked_read' => 'El mensaje ha sido marcado como leído.',

	# Info
	'info_warning' => 'Has sido advertido!<br/>%1$s<br/><a href="%2$s">Clic aquí para marcarlo como leido</a>.',
	'info_tempban' => 'Has sido vetado hasta %1$s!<br/>%2$s',
	'info_permban' => 'Has sido vetado permanentemente:<br/>%1$s',
	
	# Admin Config
	'cfg_ban_ipp' => 'Registros por página',

	# Bits
	'type_1' => 'Vetar',
	'type_2' => 'Advertir',
);
?>