<?php
$lang = array(
	'title' => 'Crypto - GPG',
	'info' =>
		'Dans ce challenge, votre but est de mettre en place le cryptage GPG pour vos e-mails.<br/>'.PHP_EOL.
		'Pour ce faire, générez votre paires de clef localement et stockez votre clef publique sur wechall.<br/>'.PHP_EOL.
		'Par la suite, tous les mails envoyés par wechall seront cryptés.<br/>'.PHP_EOL.
		'Pour activer le cryptage GPG, aller sur <a href="%1$s">Paramètres du compte</a>.<br/>'.PHP_EOL.
		'Lorsque vous aurez terminé, cliquez sur le bouton ci-dessous pour vous envoyer un e-mail.<br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'Bon challenge!',

	'btn_send' => 'Envoyez-moi un e-mail s\'il vous plait.',
	'err_login' => 'Vous devez vous connecter pour résoudre ce challenge!',
	'err_server' => 'Ce server ne supporte pas le cryptage GPG dans les e-mails php.',
	'err_no_gpg' => 'Activez le cryptage GPG dans <a href="%1$s">Paramètres du compte</a>.',

	'mail_s' => 'WeChall: Challenge GPG',
	'mail_b' =>
		'Cher %1$s,'.PHP_EOL.
		PHP_EOL.
		'Je voulais juste vous donner la solution du challenge GPG.'.PHP_EOL.
		'Qui est: %2$s'.PHP_EOL.
		PHP_EOL.
		'Cordialement,'.PHP_EOL.
		'Le Bot Wechall!',
		
	'msg_mail_sent' => 'Nous vous avons envoyé un e-mail crypté à %1$s lequel contient la solution.',
);
?>