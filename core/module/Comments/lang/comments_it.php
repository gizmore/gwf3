<?php
$lang = array(
	'info_comments' => '<br/><a href="%s">%s commenti ...</a>',

	'err_message' => 'La lunghezza del messaggio deve essere compreso tra %s e %s caratteri.',
	'err_comment' => 'Il commento non esiste.',
	'err_comments' => 'Questo commenti non esistono.',
	'err_disabled' => 'I commenti sono temporaneamente disabilitati.',
	'err_hashcode' => 'Permesso negato.',
	'err_email' => 'l\'E-Mail sembra invalita.',
	'err_www' => 'Il sito web sembra invalido.',
	'err_username' => 'Il nome utente è invalido e deve avere una lunghezza compresa tra %s e %s caratteri.',

	'msg_commented' => 'Il commento è stato aggiunto.',
	'msg_commented_mod' => 'Il commento è stato aggiunto, ma deve essere approvato prima di essere visualizzato.',
	'msg_hide' => 'Il commento è stato nascosto.',
	'msg_visible' => 'Il commento è ora visibile.',
	'msg_deleted' => 'Il commento è stato cancellato.',
	'msg_edited' => 'Il commento è stato modificato.',

	'ft_reply' => 'Lascia un commento',
	'btn_reply' => 'Invia',

	'btn_hide' => 'Nascondi',
	'btn_show' => 'Mostra',

	'ft_edit_cmt' => 'Modifica commenti',
	'ft_edit_cmts' => 'Modifica commenti del thread',

	'btn_edit' => 'Modifica',

	'btn_delete' => 'Cancella',

	'th_message' => 'Il suo messaggio',
	'th_www' => 'Il suo sito',
	'th_email' => 'Il suo indirizzo E-Mail',
	'th_username' => 'Il suo nome utente',
	'th_showmail' => 'Mostra E-mail al pubblico',

	# Moderation #
	'subj_mod' => GWF_SITENAME.': Nuovo commento',
	'body_mod' =>
		'Salve %s, '.PHP_EOL.
		PHP_EOL.
		'E\' stato pubblicato un commento su '.GWF_SITENAME.'.'.PHP_EOL.
		'Da: %s'.PHP_EOL.
		'E-Mail: %s'.PHP_EOL.
		'WWW: %s'.PHP_EOL.
		'Messaggio:'.PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'Può approvare velocemente il commento visitando: <a href="%6$s">%6$s</a>'.PHP_EOL.
		PHP_EOL.
		'Oppure può eliminarlo visitando: <a href="%7$s">%7$s</a>'.PHP_EOL.
		PHP_EOL.
		'Cordiali saluti,'.PHP_EOL.
		'Gli script di '.GWF_SITENAME,
		
	'subj_cmt' => GWF_SITENAME.': Nuovo commento',
	'body_cmt' =>
		'Salve %s, '.PHP_EOL.
		PHP_EOL.
		'E\' stato pubblicato un commento su '.GWF_SITENAME.'.'.PHP_EOL.
		'Da: %s'.PHP_EOL.
		'E-Mail: %s'.PHP_EOL.
		'WWW: %s'.PHP_EOL.
		'Messaggio:'.PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'Oppure può eliminarlo visitando: <a href="%7$s">%7$s</a>'.PHP_EOL.
		PHP_EOL.
		'Cordiali saluti,'.PHP_EOL.
		'Gli script di '.GWF_SITENAME,

	#monnino fixes
	'cfg_guest_captcha' => 'Captcha per utenti non registrati?',
	'cfg_member_captcha' => 'Captcha per membri?',
	'cfg_moderated' => 'Modera commenti?',
	'cfg_max_msg_len' => 'Lunghezza massima messaggio',
);
?>
