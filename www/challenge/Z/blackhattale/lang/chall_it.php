<?php
$lang = array(
	'info' =>
		'Ti sei svegliato ed è un\'altra brutta giornata; inoltre, il tuo account bancario è vuoto, da mesi. Ti servono dei soldi facili, quindi vai su una "darknet" irc per parlare con persone che hanno dei lavoretti "non proprio legali" da darti. Il tuo nuovo boss vuole che ti introduca nella rete di una piccola banca e trasferica dei soldi da un account ad un altro. Un semplice lavoretto, no?<br/>'.
		'<br/>'.
		'Porti il tuo forguncino davanti all\'ufficio principale della banca e lanci il tuo programma di sniffing preferito. Wow, sembra che stiano usando una reta WPA. Intercettiamo <a href="%1$s">qualche trasmissione</a> e proviamo a recuperare la password WPA con un dictionary attack.<br/>'.
		'<br/>'.
		'<br/>'.
		'Attenzione Bug: alcune vecchia versione di ***crack-*g sono incapaci di crackare la password, per cui assicurati di utilizzare una versione recente (la rc1 funziona).',
	'input' => 'Per favore, inserisci la chiave WPA qui',
	'bad' => 'Sbagliato',

	'info_login' =>
		'Ora puoi intercettare i dati inviati sulla rete. '.
		'Sembra che gli amministratori stiano usando PSA InsecurID per autenticarsi al PSA ACE server. '.
		'La buona notiziona è che stanno utilizzando delle connessioni HTTP in chiaro. '.
		'Forse gli amministratori pensavano che WPA fosse sicuro, per cui non hanno introdotto un secondo livello di sicurezza. '.
		'Ora puoi utilizzare arp cache poisoning, <a href="%1$s">intercettare dei dati relativi all\'autenticazione</a> (nome utente e la one time password generata dal token PSA InsecurID) ed inviarlo nuovamente alla pagina di autenticazione.<br/>'.
		'Hai tre secondi per fare ciò.<br/>'.
		'<br/>'.
		'invia il testo a %2$s<br/>'.
		'Il tempo limite è %3$s secondi.',

	'failed' => 'Login fallito, nome utente o password invalidi.',
	'not_sniffed_yet' => 'Errore: non hai ancora intercettato niente.',

	'info_2' =>
		'Buon lavoro. Ora hai caricato con successo le <a href="%1$s">nuove informazioni sul token</a> per l\'account bancario della vittima. La base per il nome del file è il numero seriale del token e il seed (segreto) è d4e3f9eb36c9ebf3. Fai attenzione al fatto che è un vecchio formato di PSA InsecurID, i nuovi utilizzando file XML firmati digitalmente e seed più grandi.<br/>'.
		'<br/>'.
		'Dopo aver caricato le nuove informazioni sul token, devi generare una one time password valida per quel token valida per il 27. di Luglio, 2012 14:24 GMT+1',

	'info_final' =>
		'Bel lavoro, hai effettuato il login all\'account della vittima con successo, utilizzando le informazioni di autenticazione, e puoi trasferire i soldi ad un altro account. Ben fatto. La tua ultima missione è spendere i soldi ricevuti dal tuo boss :)',
);
?>
