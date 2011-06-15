<?php
$lang = array(
	'title' => 'Deine Aufgabe...',
	'info' => 
		'Ist diese Zeile Code zu reparieren, welche eine XSS Schwachstelle enthält:'.PHP_EOL.
		'[code=PHP title=htmlspecialchars.php]%1%[/code]'.PHP_EOL.
		'[url=%2%]Common::getPost[/url] gibt nur einen string aus den [url=%3%]$_POST Variablen[/url] zurück, und wendet [url=%4%]stripslashes()[/url] darauf an, falls [url=%5%]magic_quotes_gpc()[/url] aktiviert ist.'.PHP_EOL.
		'Du kannst [url=%2%]Common::getPost[/url] ignorieren, und es durch $_POST[\'input\'] ersetzen, und davon ausgehen, dass [url=%5%]magic_quotes_gpc()[/url] deaktiviert ist.'.PHP_EOL.
		PHP_EOL.
		'Unter dem Eingabekasten findest du den Ausgabekasten, um deine Angriffe zu testen.'.PHP_EOL.
		'Du wirst eh versagen, da ich [url=%6%]htmlspecialchars()[/url] verwendet habe, um XSS Angriffen vorzubeugen.'.PHP_EOL.
		PHP_EOL.
		'[i]gizmore - 23. März 2009[/i]',
		
	'input_title' => 'Eingabekasten',
	'input_info' =>
		'<form action="" method="post">'.PHP_EOL.
		'<div>%2%</div>'.PHP_EOL.
		'<div>Input: <input type="text" name="input" size="60" value="%1%" /></div>'.PHP_EOL.
		'<div><input type="submit" name="exploit" value="Exploit It" /></div>'.PHP_EOL.
		'</form>'.PHP_EOL,
	
	'output_title' => 'Ausgabekasten',
	'click_me' => 'Klick mich',
	'output_info' =>
		'Hier ist die Ausgabe für deine Eingabe:<br/>'.PHP_EOL.
		PHP_EOL.
		'%1%',
		
	'solve_note' => 'Die Lösung ist die selbe Zeile Code, aber mit einer einfachen Ergänzung um es gegen XSS abzusichern.',
		
	'fun_msg_1' => 'Ja! Du hast es repariert!',
	'fun_msg_2' => 'Nein, mal im ernst: Vielleicht solltest du die Zeile ändern bevor du deine Antwort absendest.',
	'msg_close' => 'Du scheinst nahe an der Lösung zu sein. :)',
	'err_wrong' => 'Nein, das sieht Falsch aus. Versuche vielleicht etwas leichteres um das Script abzusichern.',
);
?>