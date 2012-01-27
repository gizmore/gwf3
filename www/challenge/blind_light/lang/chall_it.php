<?php
$lang = array(
	'title' => 'Blinded by the light ',
	'info' =>
		'La tua missione è di estrarre la password, una hash md5, dal database.<br/>'.PHP_EOL.
		'Il tuo limite per questa Blind SQL Injection è %s query.<br/>'.PHP_EOL.
		'Ti è ancora fornito il <a href="%s">codice sorgente</a> dello script vulnerabile, anche come <a href="%s">versione evidenziata</a>.<br/>'.PHP_EOL.
		'Per far ripartire la sfida, sei autorizzato ad <a href="%s">eseguire un reset</a>.<br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'%s'. # Easteregg
		'<br/>'.PHP_EOL.
		'Buona fortuna!',

	'msg_reset' => 'La tua password è stata cambiata per ragioni di sicurezza.',
	'msg_logged_in' => 'bentornato, utente. Hai effettuato il login dopo %s tentativi errati.',
	'err_login' => 'La tua password è errata, utente. Questo è stato il tuo tentativo sbagliato numero %s!',
	'err_attempt' => 'Siamo spiacenti ma hai impiegato %s tentativi per recuperare l\'hash. Il limite è %s.',
	'err_wrong' => 'La risposta è sbagliata. Questo era il tuo %s tentativo!',

	'th_injection' => 'Password ',
	'th_thehash' => 'Soluzione',
	'btn_inject' => 'Inietta',
	'btn_submit' => 'Invio',
);
?>