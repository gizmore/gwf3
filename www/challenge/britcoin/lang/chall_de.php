<?php
$lang = array(
	'title' => 'Britcoin',
	'subtitle' => 'Lesen und Textverständnis',
	'err_nounce_fmt' => 'Ungültige nounce. 32 HEX-Großbuchstaben sind erforderlich.',
	'msg_nice_nounce' => 'Nette Nounce,... aber das Ergebnis passt nicht.',
	'info' =>
		'gizmore unlimited(tm) und sabrefilms(rg) haben in Kryptowährungen investiert. (Storylinescherz!)<br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'Nun wollen wir unseren eigenen Coin am Markt platzieren.<br/>'.
		'<br/>'.PHP_EOL.
		'Aber bevor wir loslegen wollen wir erstmal die Krypto hinter unseren Algorithmen testen.<br/>'.
		'<br/>'.PHP_EOL.
		'Du sollst einen Hash mit einer Nounce hashen, der ein gültiges Prove of Work nach den <a href="%s">Spezifikationen</a> abliefert.<br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'Bevor ich`s vergesse; Das ist der initial block:<br/>'.PHP_EOL.
		'%s'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'Und das ist die &quotnounce zero&quot;: <b>%s</b><br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'Dein Hash muss mit %s anfangen.<br/>'.PHP_EOL.
		'Deine Lösung is eine passende Nounce, 32 Groß-Hexbuchstaben.<br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'Viel Erfolg!<br/>'.PHP_EOL.
		'gizmore',
		# @translators: Feel free to replace this fake json with greetings to your friends and other players.
		# @translators: IMPORTANT is to keep the %s data somewhere (sessid)
		'payload' => '{initial_trust:null,transactions:[{"from":null,"to":"%s","amt":1,note:"Mining success"},{"from":null,"to":"livinskull",amt:1},{"from":null,"to":"sabretooth",amt:1},{"from":null,"to":"Mettbroetchen","amt":0.05},{from:"livinskull",to:"sabretooth","amt":0.000000001,"note":"Microtransaction check"}]}',
);
