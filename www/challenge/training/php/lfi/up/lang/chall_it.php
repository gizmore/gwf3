<?php
$lang = array(
	'title' => 'PHP - Local File Inclusion ',
	'info' =>
		'La tua missione è quella di sfruttare questo codice, che ha una ovvia <a href="http://it.wikipedia.org/wiki/Remote_File_Inclusion">vulnerabilità LFI</a>:<br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'<code>%1$s</code><br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'Ci sono molte cose importanti in <a href="%2$s">../solution.php</a>, per cui includi ed esegui questo file per noi.<br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'Ecco alcuni esempi dello script in azione (nel box sottostante):<br/>'.PHP_EOL.
		'<a href="%5$s">%5$s</a><br/>'.PHP_EOL.
		'<a href="%6$s">%6$s</a><br/>'.PHP_EOL.
		'<a href="%7$s">%7$s</a><br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'Per effettuare del debugging, puoi dare un occhiata al <a href="%3$s">codice sorgente</a>, anche come <a href="%4$s">versione evidenziata</a>.<br/>'.PHP_EOL.
		'',

	'example_title' => 'Lo script vulnerabile in azione',
	'err_basedir' => 'Questa cartella non è parte della sfida.',
	'credits' => 'Grazie a %1$s per l\'alpha testing, le grandi idee e la motivazione!',
	'msg_solved' => 'Ben fatto. Se trovi una vulnerabilità come questa, un hacker può prendere il controllo completo della macchina in pochi minuti.',
);
?>