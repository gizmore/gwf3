<?php

$lang = array(
	'info' => '
Ciao, immagina questa situazione.<br/>
C\'è un canale IRC #wechall su irc.idlemonkeys.net.<br/>
<br/>
Il server invia un messaggio a tutte le persone nel canale, ed inoltre ne invia uno al mittente.<br/>
Se ogni minuto una persona si unisce e dice \'Ciao\',
quanti messaggi &quot;Ciao&quot; sarebbero inviati in totale su questo canale dopo 0xfffbadc0ded minuti?<br/>
Nessuno lascia mai il canale, quindi ci sono 0xfffbadc0ded persone alla fine ;)<br/>
<br/>
Un\'ulteriore spiegazione per 3 minuti:<br/>
il canale è vuoto, quindi sono stati inviati 0 messaggi
- la prima pesona si unisce, invia \'Ciao\' e il server invia \'Ciao\' a 1 persona.<br/>
- la seconda pesona si unisce, invia \'Ciao\' e il server invia \'Ciao\' a 2 persone.<br/>
- la terza persona si unisce, invia \'Ciao\' e il server invia \'Ciao\' a 3 persone.<br/>
<br/>
Minuto 1: 2 messaggi inviati<br/>
Minuto 2: 3 messaggi inviati<br/>
Minuto 3: 4 messaggi inviati<br/>
Sommando il tutto, per 3 minuti, abbiamo un totale di 9 messaggi inviati.<br/>
<br/>
Note sulla conversione: 0xfffbadc0ded è un numero esadecimale che equivale a 17.591.026.060.781 (All\'incirca 20 trilioni di minuti).'.
'Invia la tua soluzione in formato decimale.',

);

?>