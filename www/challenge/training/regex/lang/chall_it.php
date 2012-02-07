<?php
$lang = array(
	'title' => 'Addestramento Regex (Livello %1$s)',

	'err_wrong' => 'La tua risposta è sbagliata o esiste una soluzione più corta al problema.',
	'err_no_match' => 'Il tuo pattern non identifica &quot;%1$s&quot;.',
	'err_matching' => 'Il tuo pattern identifica &quot;%1$s&quot;, ma non dovrebbe.',
	'err_capturing' => 'Il tuo pattern catturerebbe una stringa ma questo non è necessario. Utilizza un gruppo non catturante.',
	'err_not_capturing' => 'Il tuo pattern non cattura la stringa voluta correttamente.',
	'err_too_long' => 'Il tuo pattern è più lungo della soluzione di riferimento con %1$s caratteri.',

	'msg_next_level' => 'Corretto, vediamo se riesci a trovare un pattern per il prossimo problema.',
	'msg_solved' => 'Ben fatto, questo è abbastanza per la primissima lezione sulle espressioni regolari. Missione compiuta.',
	
	# Levels
	'info_1' =>
		'Il tuo obbiettivo in questa sfida è di imparare ad utilizzare le Espressioni Regolari.<br/>'.PHP_EOL.
		'Le Espressioni Regolari sono un potente strumento per aiutarti a perfezionare le tue capacità di programmazione, per cui dovresti essere in grado di risolvere questa sfida, perlomeno!<br/>'.PHP_EOL.
		'La soluzione ad ogni compito è l\'espressione regolare più corta possibile.<br/>'.PHP_EOL.
		'Ricorda che devi inserire anche dei delimitatori del pattern. Esempio pattern: <b>/joe/i</b>. Il separatore deve essere <b>/</b><br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'La tua prima lezione è semplice: invia una espressione regolare che identifichi solo e soltanto una stringa vuota.<br/>',

	'info_2' => 
		'Molto semplice. Il tuo prossimo compito è di inviare una espressione regolare che identifichi solo la stringa "wechall" senza virgolette.',

	'info_3' => 
		'Ok, identificare stringhe statiche non è lo scopo per cui le espressioni regolare sono state ideate.<br/>'.PHP_EOL.
		'Il tuo prossimo compito è di inviare una espressione che identifichi dei nome di file validi per certe immagini.<br/>'.PHP_EOL.
		'Il tuo pattern deve identificare tutte le immagini con nome wechall.ext o wechall4.ext e una valida estensione per immagini.<br/>'.PHP_EOL.
		'Le estensioni per immagini valide sono .jpg, .gif, .tiff, .bmp e .png.<br/>'.PHP_EOL.
		'Ecco alcuni esempio di nomi di file validi: wechall4.tiff, wechall.png, wechall4.jpg, wechall.bmp',

	'info_4' =>
		'Adesso che possiamo cattuarare immagini valide, potresti catturare il nome del file, sebnza estensione? Sarebbe veramente utile.<br/>'.PHP_EOL.
		'Ad esempio: il pattern, applicato su wechall4.jpg, dovrebbe catturare e ritornare wechall4.',

	'info_5' => 
		'Stai facendo bene. Il tuo prossimo compito è di identificare URL http e https validi.<br/>'.PHP_EOL. #but only roughly <- what?
		'Un esempio di url valido è https://abc.de o http://abc.foobar/blub<br/>'.PHP_EOL.
		'Aiuto: C\'è un carattere che puoi sicuramente escludere dal tuo pattern.',
);
?>