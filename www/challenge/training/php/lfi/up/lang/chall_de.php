<?php
$lang = array(
	'title' => 'PHP - Einbinden Lokaler Dateien',
	'info' =>
		'Deine Aufgabe ist es dieses Script zu missbrauchen, welches offensichtlich eine <a href="http://en.wikipedia.org/wiki/Local_File_Inclusion">LFI Schwachstelle</a> aufweist:<br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'<code>%1$s</code><br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'Es steht etwas Wichtiges in <a href="%2$s">../solution.php</a>, also bitte führe das Script aus und binde die Datei ein.<br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'Hier sind ein paar Beispiele wie das Script benutzt wird. (Die Ausgabe ist in der Box darunter):<br/>'.PHP_EOL.
		'<a href="%5$s">%5$s</a><br/>'.PHP_EOL.
		'<a href="%6$s">%6$s</a><br/>'.PHP_EOL.
		'<a href="%7$s">%7$s</a><br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'Für leichtere Fehlersuche darfst du den <a href="%3$s">Quelltext ansehen</a>, auch <a href="%4$s">mit Syntax Highlighting</a>.<br/>'.PHP_EOL.
		'',

	'example_title' => 'Das verwundbare Script in Aktion',
	'err_basedir' => 'Dieses Verzeichnis ist nicht Teil dieser Aufgabe.',
	'credits' => 'Vielen Dank an %s für das Alpha-Testing, tolle Ideen und Motivation!',
	'msg_solved' => 'Gut gemacht. Wenn du eine LFI Lücke findest kann man oft leicht den Rechner übernehmen.',
);
?>