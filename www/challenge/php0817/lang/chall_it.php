<?php
$lang = array(
	'title' => 'PHP-0817 ',
	'info' =>
		'Ho scritto un sistema per includere risorse nelle pagine dinamiche ma sembra sia vulnerabile a LFI (Local File Inclusion).<br/>'.
		'Ecco il codice:<br/>'.
		'%1$s<br/>'.
		'La tua missione è di includere il file <a href="%2$s">solution.php</a>.<br/>'.
		'Ecco lo script in azione: <a href="%3$s">Novità</a>, <a href="%4$s">Forum</a>, <a href="%5$s">Guestbook</a>.<br/>'.
		'<br/>'.
		'Buona fortuna!<br/>',

	'msg_solved' => 'Ben fatto, troppo semplice... Sai perché questo è possibile?',
	'err_security' => 'Siccome il codice è molto vulnerabile, punti (.) e slash (/) non sono consentiti.',
);
?>