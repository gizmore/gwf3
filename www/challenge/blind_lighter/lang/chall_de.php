<?php
$lang = array(
	'title' => 'Geblendet vom Feuerzeug',
	'info' =>
		'Dieses Challenge ist der Nachfolger des &quot;Blinded by the light&quot; Challenge.<br/>'.PHP_EOL.
		'Wieder ist deine Aufgabe einen md5 Hash aus der Datenbank zu extrahieren.<br/>'.PHP_EOL.
		'Dieses mal ist dein Limit für diese &quot;blinde&quot; Sicherheitslücke jedoch auf nur %s Anfragen angesetzt.<br/>'.PHP_EOL.
		'Um zu beweisen das du diese Aufgabe lösen kannst, musst du dies ausserdem %s mal erfolgreich hintereinander schaffen, ohne dir einen Schnitzer zu leisten.<br/>'.PHP_EOL.
		'Natürlich darfst du dir wieder <a href="%s">den Quelltext ansehen</a>, gerne auch <a href="%s">mit Syntax Highlighting</a>.<br/>'.PHP_EOL.
		'Um die Aufgabe neu zu starten kannst du einen <a href="%s">Reset ausführen</a>.<br/>'.PHP_EOL.
		'%s<br/>'.PHP_EOL.
		'Vielen Dank an %s für seine Hilfe beim Entwickeln und Testen der Challenge.<br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'Viel Erfolg!',

	'msg_reset' => 'Dein Passwort wurde aus Sicherheitsgründen verwürfelt.',
	'msg_logged_in' => 'Willkommen zurück, User. Du wärst nun nach %s Anfragen erfolgreich eingeloggt.',
	'msg_consec_success' => 'Wow, du hast es geschafft den richtigen Hash zu extrahieren. Du benötigst nun %s weitere(n) Erfolg(e) um das Challenge zu knacken.',
	'msg_old_pass' => 'Schade, dass du so schnell aufgibst. Als kleine Hilfe decken wir deinen Hash nun auf: %s.',
		
	'err_too_slow' => 'Du warst zu langsam für diesen Hash. Das geht auch schneller!',
	'err_login' => 'Dein Passwort ist falsch, User. Dies war deine %s. Anfrage!',
	'err_attempt' => 'Es tut uns leid, aber du hast %s Anfragen benötigt um den Hash zu extrahieren. Das Limit ist aber %s.',
	'err_wrong' => 'Deine Antwort ist leider falsch. Dies war deine %s. Anfrage!',

	'th_injection' => 'Passwort',
	'th_thehash' => 'Lösung',
	'btn_inject' => 'Injecten',
	'btn_submit' => 'Absenden',
);
?>