<?php
$lang = array(
	'thanks' => 'Grazie a %1$s e %2$s per il beta-testing della sfida.',
	'index_info' =>
		'In questa sfida, tu sei un hacker segreto. Come sempre.<br/>'.
		'Il tuo prossimo lavoro è il seguente:<br/>'.
		'<br/>'.
		'VSA (Very Secret Agency) ha seguito un protocollo di sicurezza molto restrittivo per anni, ed è quasi impossibile ottenere l\'accesso alla loro rete.<br/>'.
		'Sfortunatamente, questo è ciò che il tuo boss vuole da te.<br/>'.
		'Dopo aver raccolto alcune informazioni tramite social engineering, sei venuto a conoscenza del fatto che VSA vuole ordinare alcuni semplici programmi dalla corporazione SoftMicro, specializzara nello sviluppo di sofware.<br/>'.
		'SoftMicro è un vecchio partner di VSA, ed ha implementato delle backdoor per un sistema operativo commerciale chiamato "Doors" per VSA.<br/>'.
		'Il software di SoftMicro è normalmente di bassa qualità, ma il loro network è molto ben difeso - grazie ai numerosi attacchi a cui è sottoposto.<br/>'.
		'Ma VSA non accetta nessun sorgente da SoftMicro direttamente, poichè impiegano una terza compagnia chiamata Anderson per validare ogni singolo sorgente che dovrà essere utilizzato da VSA.<br/>'.
		'Il tuo piano è quello di dirottare la comunicazione tra Anderson e SoftMicro, così da analizzare il programma inviato e, dopo che Anderson avrà validato il programma, tu dirotterai il traffico tra Anderson e VSA, scambierai il programma con il tuo programma maligno, ed il lavoro sarà fatto.<br/>'.
		'<br/>'.
		'Il piano è geniale, ma forse non tutto va come hai pianificato...<br/>'.
		'<br/><br/>'.
		'Il tuo primo compito è quello di dirottare la comunicazione tra il network di Anderson e quello di SoftMicro.<br/>'.   
		'<br/>'.
		'Ecco le informazioni che hai già recuperato:<br/>'.
		'Il network di SoftMicro è 207.46.197.0 <br/>'.
		'Il tuoi IP pubblico è 17.149.160.49 <br/>'.
		'<br/>'.
		'La pagina principale di Anderson è <a href="%1$s">Anderson</a><br/>'.
		'<br/>'.
		'Procedendo nella sfida, riceverai sei pezzi di un codice segreto, che ti serviranno per provare l\'effettiva risoluzione della sfida.<br/>'.
		'Per cui, non dimenticare di salvare questi pezzi di codice.<br/>',

	# router.php
	'err_router' => 'Nome utente/password invalidi.',
	'cfg_cmd' => 'Comando di configurazione',
	'router_info' =>
		'Login effettuato con successo.<br/>'.
		'Puoi configurare il router qui, la sintassi è la stessa delle macchine *NIX.<br/><br/>'.
		'Esempio: route add -net x.x.x.x netmask 255.255.255.0 gw x.x.x.x<br/><br/>',

	# upload_md5.php
	'upload_info' =>
		'Il tuo compito è quello di creare due file binari differenti, la cui md5sum è la stessa.<br/>'.
		'Il primo file binario dovrà essere inviato ad Anderson per l\'analisi del software mentre il secondo dovrà essere inviato a VSA nella prossima parte della tua missione.<br/>'.
		'<br/>'.
		'Il primo programma deve scrivere a video<br/>'. 
		'<i>"Hello VSA employee"</i><br/>'.
		'ed il secondo, quello maligno, dovrà scrivere<br/>'. 
		'<i>"I am a super VIRUS, game over."</i><br/>'.
		'<br/><br/>'.
		'Lo script verifica se i due binari fanno quello che è richeisto, e se la loro md5sum è uguale.<br/>'.
		'<br/>'.
		'Siccome gli sviluppatori di SoftMicro sono in ritardo nel finire il loro lavoro, forse puoi trovare la collisione prima che inviino il loro programma ad Anderson.<br/>'.
		'<br/>'.
		'Nota: Lo script controlla solo se il file buono ed il file maligno contengono le rispettive stringhe da mandare a video e se le md5sum sono uguali ma le hash sha1 differiscono.<br/>'.
		'Sul mio PC sono state necessarie 8 ora per trovare una collisione, ma c\'è un metodo più veloce e più intelligente...<br/>',
		'hidden_hint' => 'Aiutino nascosto: prova a fare una ricerca per md5 collision.',

	# upload_md5_file.php
	'err_file_size' => 'Il file è troppo grande.<br/>',
	'err_upload_fail' => 'Non è stato possibile caricare il file!<br/>',
	'err_wrong' => 'Errore: I file non sono diversi.<br/>',
	'err_md5' => 'Errore: Le md5sums non sono uguali.<br/>',
	'err_upload_grbge' => 'Errore: I file non fanno quello che dovrebbero fare.<br/>',
	'msg_uploaded_collision' =>
		'Buon lavoro.<br/>'.
		'La seconda parte della stringa segreta: %1$s<br/>'.
		'<br/>'.
		'Il tuo percorso continua qui:<br/>'.
		'<a href="%2$s">Fingerprinting</a>',
);
?>
