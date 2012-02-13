<?php
$lang = array(
	'title' => 'The Travelling Customer ',
	'info' =>
		'In questa sfida di programmazione devi risolvere il seguente problema:<br/>'.
		'Ti viene presentata un menù, un NumOggetti e una Somma, insieme ad un parametro di Stock.<br/>'.
		'Il tuo compito consiste nel selezionare <i>NumOggetti</i> oggetti spendendo la somma data.<br/>'.
		'Non potrai scegliere più di <i>Stock</i> oggetti di ogni tipo.<br/>'.
		'<br/>'.
		'Esempio:<br/>'.
		'Patatine=4<br/>'.
		'Uova=2<br/>'.
		'<br/>'.
		'NumOggetti=5<br/>'.
		'Somma=14<br/>'.
		'Stock=3<br/>'.
		'Livello=1<br/>'.
		'<br/>'.
		'Una risposta accettabili sarebbe: 2Patatine3Uova<br/>'.
		'<br/>'.
		'Visita <a href="%1$s">%1$s</a> per richiedere un nuovo problema.<br/>'.
		'Invia le tue risposte a <a href="%2$s">%2$s?answer=[risposta]</a> con il formato NNomeoggettoNNomeoggetto.<br/>'.
		'Devi risolvere %3$s problemi ed il tempo limite per ogni problema è %4$s secondi.<br/>'.
		'<br/>'.
		'Buona fortuna!',

	'err_item' => 'Oggetto sconosciuto: %s',
	'err_price' => 'Il tuo prezzo totale è %s ma ti serve %s.',
	'err_item_count' => 'La tua risposta utilizza %s oggetti conosciuti ma te ne servono %s.',
	'err_reset' => 'Devi ripartire dal livello 1.',
	'err_timout' => 'Hai impiegato %s secondi ma ne avevi a disposizione solo %s.',
	'err_item_num' => 'Il totale inviato per l\'oggetto %s è invalido. Deve essere >= 1.',
	'err_item_stock' => 'Vuoi comprare %s %s, ma ci sono solo %s %2$s disponibili.',
	'err_no_prob' => 'Non hai ancora richiesto un problema. Può essere che tu abbia inviato in modo erroneo il cookie di identificazione.',
	'err_format' => 'Il formato di input è invalido. Prova ?answer=3Polli4Fanta.',
	'err_timeout' => 'Il tempo limite per il problema è di %2$s secondi, ma ne hai impiegati %1$s secondi.',
	'msg_next_level' => 'Corretto. Ora sei al livello %s.',
	'msg_solved' => 'Corretto. Hai risolto la sfida.',

	'credits_title' => 'Crediti',
	'credits_body' => 'Grazie a XKCD, l\'autore di %s.<br/>Le strisce comiche sono di grande ispirazione.',
);
?>