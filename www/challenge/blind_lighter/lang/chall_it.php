<?php
$lang = array(
	'title' => 'Blinded by the lighter ',
	'info' =>
		'Questa sfida è il seguito di &quot;Blinded by the light&quot;.<br/>'.PHP_EOL.
		'La tua missione è ancora quella di estrarre dal database una hash md5.<br/>'.PHP_EOL.
		'Questa volta il limite per questa blind sql injection è %s query.<br/>'.PHP_EOL.
		'Inoltre, devi portare a termine questo compito per %s volte consecutive, per dimostrare che hai risolto lo sfida.<br/>'.PHP_EOL.
		'Ti viene dato il <a href="%s">codice sorgente</a> dello script vulnerabile, anche in <a href="%s">versione evidenziata</a>.<br/>'.PHP_EOL.
		'Per far ripartire la sfida, puoi <a href="%s">eseguire un reset</a>.<br/>'.PHP_EOL.
		'%s<br/>'.PHP_EOL.
		'Grazie a %s per il suo aiuto nello sviluppo e nel testing della sfida.<br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'Buona fortuna!',

	'msg_reset' => 'La tua password è stata cambiata per ragioni di sicurezza.',
	'msg_logged_in' => 'Bentornato, utente. Hai effettuato il login dopo %s tentativi errati.',
	'msg_consec_success' => 'Wow, sei stato capace di recuperare l\'hash corretta restando nei limiti della sfida. Devi completare la missione ancora %s volte per risolvere la sfida.',
	'msg_old_pass' => 'Siamo spiacenti di vedere che ti sei arreso così presto. Per aiutarti, ecco la tua ultima hash: %s.',
		
	'err_too_slow' => 'Sei stato troppo lento questa volta. Puoi fare più in fretta.',
	'err_login' => 'La password è errata, utente. Questo era il tuo tentativo sbagliato numero %s!',
	'err_attempt' => 'Siamo spiacenti ma hai impiegato %s tentativi per recuperare l\'hash. Il limite è %s.',
	'err_wrong' => 'La risposta è sbagliata. Questo era il tuo %s tentativo!',
		
	'th_injection' => 'Password ',
	'th_thehash' => 'Soluzione',
	'btn_inject' => 'Inietta',
	'btn_submit' => 'Invia',
);
?>