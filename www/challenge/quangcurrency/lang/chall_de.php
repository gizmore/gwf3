<?php
$lang = array(
	# Main Page
	'err_login' => 'Für dieses Challenge müssen Sie angemeldet sein.',
	'title' => 'Beschreibung',
	'info' =>
		'Ihre Aufgabe ist es, 10 Items <a href="%1$s">zu erwerben</a>, aber Ihr Kontostand lässt dies nicht zu.<br/>'.
		'Wenn Sie <a href="%2$s">hier klicken</a> erhalten sie einen Cent für den Klick, aber sie dürfen nur 50 mal klicken.<br/>'.
		'Wenn Sie <a href="%3$s">hier klicken</a> wird Ihr Konto zurückgesetzt.<br/>'.
		'Sie können sich <a href="%4$s">Ihr Konto hier ansehen</a>.<br/><br/>'.
		'Viel Erfolg!', #<br/><br/>'.
		#'<i>Notiz: Ändern sie bitte nicht Ihre userid. Die userid wird benötigt, da ich session_start() nicht aufrufe.<br/>Die userid entspricht ihrer WeChall userid. Sie können daher auch andere Konten ausspähen und mit ihnen spielen. Dies ist für das Challenge allerdings nicht erforderlich (Wird repariert!).</i>',

	# Reset
	'reset_info' => 'Ihr Konto wurde zurückgesetzt. Viel Erfolg!',

	# Stats
	'stats_title' => 'Ihr Konto',
	'stats_info' =>
		'Guthaben: %1$s<br/>'.
		'Anzahl Klicks: %2$s<br/>'.
		'Items gekauft: %3$s',

	# Buy
	'err_money' => 'Sie haben nicht genug Geld auf dem Konto.',
	'msg_buy' => 'Vielen Dank für den Kauf eines Items. Sie haben nun %1$s Items auf Lager.',
	'msg_solved' => 'Was zum Teufel?!? Wie haben sie 10 Items erhalten?!?<br/>Naja, ... Das Challenge wurde als gelöst markiert und ihr Konto wurde zurückgesetzt.',

	# Click
	'err_max_clicks' => 'Sie haben das maximum an Klicks erreicht. Bitte setzen Sie Ihr Konto zurück.',
	'msg_click_1' => 'Überprüfe den Klick auf gültigkeit...',
	'msg_click_2' => 'Anzahl der Klicks ist ok...',
	'msg_click_3' => 'Überprüfe Timeout...',
	'msg_clicked' => 'Vielen Dank für Ihren Klick. Wir haben Sie mit %1$s Cents belohnt!',

);
?>