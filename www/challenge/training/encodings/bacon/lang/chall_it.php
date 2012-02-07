<?php
$lang = array(
	'title' => 'Codifiche - Baconiano',
	'info' =>
		'In questa sfida di allenamento, il tuo obiettivo è rivelare il messaggio nascosto in un altro messaggio.<br/>'.
		'Sappiamo che il messaggio è nascosto tramite il <a href="http://en.wikipedia.org/wiki/Bacon%27s_cipher">cifrario di Bacon</a> (link in inglese).<br/>'.
		'<br/>'.
		'Come al solito, la soluzione cambia ad ogni sessione e consiste in 12 caratteri casuali.<br/>'.
		'<br/>'.
		'Enjoy!',
	
	'msg_title' => 'Il messaggio',
	'message' =>
		'Il cifrario di Bacon è un metodo steganografico (un metodo di nascondere un messaggio a differenza di crittarlo) ideato da Francis Bacon. Un messaggio è nascosto nella presentazione del testo, invece che nel suo contenuto.'.PHP_EOL.
		'Per codificare un messaggio, ogni lettera del test è rimpiazzata da un gruppo di cinque lettere \'A\' o \'B\'. Questo rimpiazzo è fatto sulla base dell\'alfabeto del cifrario, mostrato qui sotto.'.PHP_EOL.
		'Nota: Una seconda versione del cifrario di Bacon utilizza un codice unico per ogni lettera. In altre parole, I e J hanno un loro pattern specifico.'.PHP_EOL.
		'Lo scrittore deve utilizzare due font diversi per questo cifrario. Dopo aver preparato un falso messaggio con lo stesso numero di lettere A e B nel vero messaggio segreto, due font diversi sono scelti, uno per rappresentare le A, l\'altro per le B. Quindi ogni lettera del falso messagio deve essere presentata con il font appropriato, a seconda del fatto che rappresenti un A o una B.'.PHP_EOL.
		'Per decodificare il messaggio si applica il metodo inverso. Ogni lettera con il primo font nel falso messagigo è rimpiazzata con una A ed ogni lettera con il secondo font è rimpiazzata con una B. Dopodichè si utilizza l\'alfabeto baconiano per recuperare il messaggio originale.'.PHP_EOL.
		'Qualsiasi metodo di scrittura del messaggio che permette due distinte rappresentazioni per ogni carattere può essere usato per il cifrario di Bacon. Francis Bacon ha preparato lui stesso un alfabeto Bilaterale[2] per lettere maiuscole e minuscole scritte a mano aventi due forme alternative, una da usare per le A, l\'altra per le B. Questo è stato pubblicato come una tavola illustrata nel suo De Augmentis Scientiarum (L\'avanzamento del sapere).'.PHP_EOL.
		'Siccome qualsiasi messaggio della lunghezza giusta può essere utilizzato per nascondervi il messaggio, quest\'ultimo è realmente nascosto in piena vista. Il falso messaggio può riguardare qualsiasi cosa e quindi può ingannare una persona che stesse cercando il vero messaggio.',

	'hidden' => 'Ben fatto compagno hacker ecco la soluzione %1$s',
);
?>