<?php

$lang = array(
## SCOREVOTE ##

	# votebuttons.php
	'alt_button' => 'votación %s',
	'title_button' => 'votación %s',

	# Errors
	'err_votescore' => 'Mesa de votación que no se encuentra para ese elemento.',
	'err_score' => 'Usted puntuación votado no es válido.',
	'err_expired' => 'La votación ha finalizado.',
	'err_disabled' => 'Registro de votación está actualmente bloqueada.',
	'err_vote_ip' => 'Este tema ya ha sido votada por usted IP.',
	'err_no_guest' => 'Los invitados no pueden votar sobre este tema.',
	'err_title' => 'El título tiene que ser entre %s y %s caracteres.',
	'err_options' => 'Su opción de Encuesta(s) %s es / son errorneous y probablemente no dentro de los límites  %s de %s caracteres.',
	'err_no_options' => 'Usted no ha indicado las opciones.',

	# Messages
	'msg_voted' => 'Votación registrada.',

	## POLLS ##

	'poll_votes' => '%s Votos',
	'votes' => 'votos',
	'voted' => 'votado',
	'vmview_never' => 'Nunca',
	'vmview_voted' => 'Tras la votación',
	'vmview_allways' => 'Siempre',

	'th_date' => 'Fecha',
	'th_votes' => 'Votos',
	'th_title' => 'Título',
	'th_multi' => '¿Permitir múltiples opciones?',
	'th_option' => 'Opción %s',
	'th_guests' => '¿Invitado votos?',
	'th_mvview' => 'Mostrar resultado',
	'th_vm_public' => '¿Mostrar en la barra lateral?',
	'th_enabled' => '¿Habilitado?',
	'th_top_answ' => 'Respuesta superior(s)',

	'th_vm_gid' => 'Limitar a los grupos',		
	'th_vm_level' => 'Restringir por nivel',

	'ft_edit' => 'Edite usted encuesta',
	'ft_add_poll' => 'Asignar una de sus encuestas',
	'ft_create' => 'Crear una nueva encuesta',

	'btn_edit' => 'Editar',
	'btn_vote' => 'Votación',
	'btn_add_opt' => 'Añadir Opción',
	'btn_rem_opts' => 'Eliminar todas las opciones',
	'btn_create' => 'Crear encuesta',

	'err_multiview' => 'El punto de vista de bandera para esta encuesta no es válido.',
	'err_poll' => 'La encuesta es desconoce.',
	'err_global_poll' => 'No usted les permite añadir una encuesta mundial.',
	'err_option_empty' => 'Opción está vacía.',
	'err_option_twice' => 'Opción aparece varias veces.',
	'err_no_options' => 'Tú olvidó especificar una opción para encuesta.',
	'err_no_multi' => 'Sólo puede elegir una opción.',
	'err_poll_off' => 'Esta encuesta está actualmente desactivada.',
	
	'msg_poll_edit' => 'Usted encuesta ha sido editado con éxito.',
	'msg_mvote_added' => 'Usted encuesta ha sido agregado con éxito.',


	# v2.01 Staff
	'th_vs_id' => 'ID',
	'th_vs_name' => 'llama',
	'th_vs_expire_date' => 'Expira',
	'th_vs_min' => 'Min',
	'th_vs_max' => 'Max',
	'th_vs_avg' => 'Med',
	'th_vs_sum' => 'Sum',
	'th_vs_count' => 'Contar',

	# v2.02
	'th_reverse' => '¿Reversible?',
	'err_irreversible' => 'Tu ya has votado este artículo y los votos para este artículo no son reversibles.',
	'err_pollname_taken' => 'Este nombre de encuesta ya está en uso.',
);
?>