<?php
$lang = array(
	'title' => 'Il est temps de Reset',
	'info' =>
		'J\'ai parcouru ma todo-liste et codé un challenge.<br/>'.PHP_EOL.
		'Dans ce challenge, vous devez soumettre le jeton de reset de mot de passe pour l\'utilisateur admin@wechall.net<br/>'.PHP_EOL.
		'Notez que votre jeton est lié à votre session.<br/>'.PHP_EOL.
		'Vous aurez probablement envie de jetez un oeil au <a href="%s" title="Code source du challenge TTR">code source</a>, disponible aussi en <a href="%s" title="Code source coloré pour le challenge TTR">version colorée</a><br/>'.PHP_EOL.
		'<p style="color:#eefeef" id="hint">L\'indice ci-dessus est suffisant.</p>'.PHP_EOL.
		'Bonne chance !<br/>'.PHP_EOL,

	'err_email' => 'Votre email semble invalide.',
		
	'ft_reset' => 'Demander un reset de mot de passe',
	'th_email' => 'Votre email',
	'btn_reset' => 'Reset',
		
	'mail_subj' => 'TTR : Reset le mot de passe',
	'mail_body' =>
		'Cher Utilisateur,'.PHP_EOL.
		''.PHP_EOL.
		'Vous avez demandé un jeton de reset de mot de passe, celui-ci est : %s'.PHP_EOL.
		''.PHP_EOL.
		'Bye !'.PHP_EOL.
		'Lamb3'.PHP_EOL,
		
	'msg_mail_sent' => 'Nous vous avons probablement envoyé un email.',
		
	'msg_reset_own' => 'Waw, vous avez réussi à récupérer le jeton de reset de %s !',
);
?>
