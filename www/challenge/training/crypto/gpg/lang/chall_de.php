<?php
$lang = array(
	'title' => 'Crypto - GPG',
	'info' =>
		'Das Ziel dieser Aufgabe ist es GPG Verschlüsselung für deine Emails einzurichten.<br/>'.PHP_EOL.
		'Dazu musst du ein Schlüsselpaar auf deinem Rechner generieren, und den öffentlichen Schlüssel auf WeChall hochladen.<br/>'.PHP_EOL.
		'Dann sind Deine Emails die Du von WeChall bekommst alle verschlüsselt.<br/>'.PHP_EOL.
		'Um GPG uzu aktivieren, begebe Dich zu Deinen <a href="%1$s">Konto-Einstellungen</a>.<br/>'.PHP_EOL.
		'Wenn Du fertig bist, clicke den Knopf unten um dir eine Email zu senden.<br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'Happy Challenging!',

	'btn_send' => 'Sende mir eine Email, bitte.',
	'err_login' => 'Du musst Dich einloggen um diese Aufgabe zu lösen!',
	'err_server' => 'Dieser Server unterstützt keine PHP-GPG verschlüsselung.',
	'err_no_gpg' => 'Bitte aktiviere zuerst GPG Verschlüsselung in deinen <a href="%1$s">Konto-Einstellungen</a>.',

	'mail_s' => 'WeChall: GPG Aufgabe',
	'mail_b' =>
		'Hallo %1$s,'.PHP_EOL.
		PHP_EOL.
		'Ich will Dir nur schnell die Lösung für die GPG Aufgabe mitteilen.'.PHP_EOL.
		'Sie lautet: %2$s'.PHP_EOL.
		PHP_EOL.
		'Freundliche Grüße,'.PHP_EOL.
		'Der WeChall Bot!',
		
	'msg_mail_sent' => 'Wir haben dir eine verschlüsselte Email an %s gesendet welche die Lösung enthält.',
);
?>