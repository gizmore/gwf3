<?php
$lang = array(
	'your_box' => 'Il tuo computer',
	'title' => 'Vai alla sfida',
	'info' =>
		'Prima di inizare la sfida ti consiglio di salvere tutte le informazioni e le soluzioni che riceverai,<br/>'.
		'poichè poi ti serviranno, molto probabilmente, nelle parti successive della sfida.<br/>'.
		'Specialmente se vedi delle password nello casella del narratore.<br/>'.
		'<br/>'.
		'<a href="%1$s" title="Start the challenge">Inizia la sfida</a>',

	### Narrator ###
	'narr_1' => 'In questa sfida impersonerai Trinity, dal famoso film Matrix: Reloaded. All\'inizio di questa sfida, la tua missione è la stessa del film: Togliere corrente all\'intera città. per iniziare l\'hack, devi eseguire un scan nmap verboso contro 10.2.2.2.<br/><br/>You can reset the challenge anytime by typing \'reset\'.',
	'narr_2' => 'Trova il servizio vulnerabile, informati sul famoso exploit, e invia il nome del file sorgente che contiene il problema di sicurezza.',
	'narr_3' => 'Buon lavoro Trinity, ora usa il famoso comando (come visto nel film) per sfruttare il servizio vulnerabile.',
	'narr_4' => 'Oops, sembra che il tuo lavoro sia diventato più arduo rispetto al film, poichè non puoi disattivare la rete elettrica da questo nodo. Il tuo prossimo compito sarà quello di attaccare il server del database MS SQL centrale. Non è raggiungibile dal tuo segmento di rete, per cui dovrai eseguire un port-forwarding dalla tua porta locale MS SQL verso 10.2.2.2 (gateway) alla porta MS SQL su 192.168.10.2 (usando il tuo nuovo account SSH). Tu sei root sulla tua macchina, per cui non devi fornire il nome utente.',
	'narr_5' => 'Inserisci la password:',
	'narr_6' => 'Sei root su 10.2.2.2 (server gateway), e hai un tunnel SSH funzionante tra localhost e il server del database (192.168.10.2). Hai inoltre aggiunto la tua chiave pubblica SSH a /root/.ssh/authenticated_keys, così da non dover ridigitare la tua password in futuro. Il tuo prossimo compito è quello di effettuare il login al database MS SQL server 2000 con il client da linea di comando di MS SQL (osql). Devi sfruttare una famosa vulnerabilità in MS SQL per farlo. E\' molto semplice.',
	'narr_7' => 'Bel lavoro, ora sei un amministratore di sistema sul server del database centrale. Il tuo prossimo compito consiste nell\'aggiungere un utente windows chiamato trinity con passowrd Z1ON0101 al sistema - tutto con un singolo comando MS SQL.',
	'narr_8' => 'Aggiungi l\'utente creato in precedenza al gruppo administrators locale - ancora con un unico comando MS SQL.',
	'narr_9' => 'Devi impostare un nuovo port-forwarding dalla tua porta locale di remote desktop alla porta di remote desktop del server del database (192.168.10.2) - attraverso il server gateway (10.2.2.2).',
	'narr_10' => 'Non è così difficile, no? :) Ora puoi accedere al desktop remoto del del server del database con "rdesktop 127.0.0.1 -u trinity -p Z1ON0101" (è già stato eseguito, questa non è la soluzione da inserire). Lanci una nuova console su localhost, e fai un nuovo port forward. Qualsiasi connessione a 10.2.2.2 (gateway) sulla porta 222 deve essere indirizzato al tuo host 164.109.44.69 sulla porta 22.',
	'narr_11' => 'Considera che il client scp è sul server del database (come su Unix), ed il server scp è sulla tua postazione locale. Il tuo compito è di copiare il file maligno /home/trinity/nasty_virus sul server del database in  c:\ directory. Nome utente: trinity, password: MyL0v315N30',
	'narr_12' => 'Oh, un prompt.',
	'narr_13' => 'Il tuo fastidioso virus sta facendo un gran bel lavoro contro la rete elettrica, ci metteranno giorni per recuperare l\'intero database - e la rete elettrica. Bel lavoro Trinity, missione compiuta :)',

	### After (prompts?) ###
	'after_1' => '', # none
	'after_2' => 
		'Starting nmap V. 2.54BETA25'.PHP_EOL.
		'Insufficient responses for TCP sequencing (3), OS detection may be less accurate'.PHP_EOL.
		'Interesting ports on 10.2.2.2:'.PHP_EOL.
		'(The 1539 ports scanned but not shown below are in state: closed)'.PHP_EOL.
		'Port    State           Service         Version'.PHP_EOL.
		'22/tcp  open            ssh             OpenSSH 2.2.0 (protocol 1.0)'.PHP_EOL.
		'...'.PHP_EOL.
		'No exact OS matches for host'.PHP_EOL.
		'...'.PHP_EOL.
		'Nmap run completed -- 1 IP address (1 host up) scanneds'.PHP_EOL,
	'after_3' => 'Right :)',
	'after_4' =>
		'Connecting to 10.2.2.2:ssh ... successful.'.PHP_EOL.
		'Attempting to exploit SSHv1 CRC32 ... successful.'.PHP_EOL.
		'Reseting root password to "Z1ON0101".'.PHP_EOL.
		'System open: Access Level <9>'.PHP_EOL,
	'after_5' => 'Password:',
	'after_6' => 'Welcome to the gateway server, root.',
	'after_7' => 'Welcome to MSSQL. We put the screws in your database!',
	'after_8' => 'Added user trinity.',
	'after_9' => 'Added user trinity to group administrators',
	'after_10' => 'Port Forward 1 done.',		
	'after_11' => 'Port Forward 2 done.',
	'after_12' => 'Password:',
	'after_13' => 'OWNED',

	'cmd_help' => 'Questa non è una Shell. E\' più simile a trivia - un gioco di domande e risposte. Buon divertimento con la ricerca.',
);
?>