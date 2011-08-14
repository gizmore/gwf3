<?php

$lang = array(
	'info' =>
		'Hi, Stell dir vor:<br/>'.PHP_EOL.
		'Es gibt einen IRC channel #wechall auf irc.idlemonkeys.net.<br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'Der Server versendet die Nachrichten an alle Teilnehmer im channel, auch zurück zum Absender.<br/>'.PHP_EOL.
		'Wenn jede Minute ein weiterer Teilnehmer hinzukommt, und &quot;Hi&quot; sagt,<br/>'.PHP_EOL.
		'Wieviele &quot;Hi&quot; Nachrichten wurden nach 0xfffbadc0ded Minuten gesendet?<br/>'.PHP_EOL.
		'Niemand verlässt den channel, also nehmen am Ende 0xfffbadc0ded Personen an der Unterhaltung teil.<br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'Beispiel für 3 Minuten:<br/>'.PHP_EOL.
		'Der #channel ist leer und es wurden 0 Nachrichten gesendet.<br/>'.PHP_EOL.
		'1. Person kommt hinzu, schreibt &quot;hi&quot;, der Server sendet &quot;hi&quot; zurück an eine Person.<br/>'.PHP_EOL.
		'2. Person kommt hinzu, schreibt &quot;hi&quot;, der Server sendet &quot;hi&quot; zurück an zwei Personen.<br/>'.PHP_EOL.
		'3. Person kommt hinzu, schreibt &quot;hi&quot;, der Server sendet &quot;hi&quot; zurück an drei Personen.<br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'Minute 1: 2 Nachrichten gesendet<br/>'.PHP_EOL.
		'Minute 2: 3 Nachrichten gesendet<br/>'.PHP_EOL.
		'Minute 3: 4 Nachrichten gesendet<br/>'.PHP_EOL.
		'Zählt man diese zusammen erhält man als Lösung 9 Nachrichten gesendet nach drei Minuten.<br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'Hinweis zur Umrechnung: 0xfffbadc0ded ist Hexadezimal. Umgerechnet in das Dezimalsystem ergibt sich 17.591.026.060.781 (ca. 20 Billionen Minuten).<br/>'.
		'Bitte gib deine Lösung im Dezimalsystem an.',
);

?>