<?php
$lang = array(
	'err_create_config' => 'Per favore, crea il file &quot;protected/config.php&quot; e garantisci i permessi di scrittura sul file al web-server.',
	'err_no_config' => 'Il file &quot;protected/config.php&quot; non esiste.',
	'err_no_db' => 'Non è possibile creare una connessione al database.',
	'err_config_value' => 'Nel file config.php, il valore definito per &quot;%s&quot; è invalido. E\' stato ripristinato il valore di default.',
	'err_unknown_type' => 'Tipo variabile (vartype) sconosciuto per la variabile di configurazione: %s.',
	'err_unknown_var' => 'Variabile di configurazione sconosciuta: %s.',
	'err_text' => 'La variabile \'%s\' deve essere una stringa.',
	'err_int8' => 'La variabile \'%s\' deve essere un numero ottale.',
	'err_int10' => 'La variabile \'%s\' deve essere un numero decimale.',
	'err_bool' => 'La variabile \'%s\' deve essere o true o false.',
	'err_script' => 'La variabile \'%s\' ha un valore di default invalido.',
	'err_no_smarty' => 'La libreria Smarty non è stato trovata.',
	'err_no_mods_selected' => 'Seleziona altri moduli.',
	'err_htaccess' => 'Non è stato possibile scrivere il file .htaccess.',
	'err_copy' => 'Non è stato possibile copiare %s.',
	'err_clear_smarty' => 'Non è stato possibile ripulire la cache smarty.',
		
	'msg_copy' => 'La copia di %s è avvenuta con successo.',
	'msg_copy_untouched' => 'La tua copia di %s non è stato toccata.',
	'msg_htaccess' => 'Il file .htaccess è stato scritto con successo.',
	
	'pt_wizard' => 'GWF - Installazione guidata',
	'mt_wizard' => 'GWF,Installazione,Guidata',
	'md_wizard' => 'Installazione guidata di GWFv4. Non dovresti vedermi ;)',

	'foot_progress' => 'Percentuale installazione: %0.02f%%',
	'license' => 'GWF3 è &copy; di gizmore.<br/>GWF3 è correntemente senza licenza. Una licenza compitibile con la licenza MIT è in programma.<br/>GWF3 shall be free as in beer.',
	'pagegen' => 'Pagina generata in %.03fs.',

	'menu_0' => 'Stato',
	'menu_1' => 'Scrivi Config',
	'menu_2' => 'Testa Config',
	'menu_3' => 'Tabelle Principali',
	'menu_4' => 'Locali',
	'menu_5' => 'Robots ',
	'menu_6' => 'Moduli',
	'menu_7' => 'Esempi',
	'menu_8' => 'HTAccess ',
	'menu_9' => 'Admins ',
	'menu_10' => 'Backup ',
	'menu_11' => 'Cache ',
	'menu_12' => 'Proteggi',

	'title_long' => 'Framework per Siti Web di Space &amp; Gizmore',
	'title_step' => 'Installazione guidata - Passo %d',
	
	'wizard' => 'Installazione guidata',
	'step' => 'Passo %s',
	'yes' => 'si',
	'no' => 'no ',
	'ok' => 'OK. ',
	'error' => 'ERRORE: ',
	'no_cfg_file' => 'Il file config non esiste',

	'step_0'    => 'Controlla requisiti',
	'step_0_0'  => 'Benventuto all\'installazione guidata di GWF.<br/>Ti preghiamo di creare un database prima di procedere con l\'installazione.<br/>Ecco i comandi MySQL per creare un database:',
	'step_0_0a' => 'Prima di tutto, assicurati che i campi marcati con (*) siano tutti verdi.',
	'step_0_1'  => 'Hai protetto la cartella &quot;protected/&quot; tramite .htaccess?',
	'step_0_2'  => 'Il server dispone dei permessi di scrittura per il file .htaccess alla radice?(*)',
	'step_0_3'  => 'Il server può scrivere il file &quot;protected/config.php&quot;?(*)',
	'step_0_4'  => 'Esiste il file config.php?',
	'step_0_5'  => 'Il server dispone dei permessi di scrittura per la directory &quot;dbimg/&quot;?(*)',
	'step_0_6'  => 'Il server dispone dei permessi di scrittura per la directory &quot;extra/temp/&quot;?(*)',
	'step_0_7'  => 'Il server dispone dei permessi di scrittura per la directory &quot;protected/logs/&quot;?(*)',
	'step_0_8'  => 'Il server dispone dei permessi di scrittura per la directory &quot;protected/rawlog/&quot;?(*)',
	'step_0_9'  => 'Il server può connettersi al database?',
	'step_0_10' => 'E\' installata la libreria PHP \'hash\'?(*)',
	'step_0_11' => 'E\' installata la libreria PHP \'ZipArchive\'?',
	'step_0_12' => 'E\' installata la libreria PHP \'curl\'?',
	'step_0_13' => 'E\' disponibile \'Fileinfo\' o \'mime_content_type\', per PHP, disponibile?',
	'step_0_14' => 'Sono abilitate le seguenti funzioni potenzialmente nocive: exec,system,passthru,pcntl_exec,proc_open,shell_exec,popen,link? (Se sono abilitate e non vengono utilizzate si consiglia di disabilitarle)',
	'step_0_15' => 'Sono disponibili le funzioni GnuPG?',

	'step_1' => 'Crea &quot;protected/config.php&quot;',

	'step_1a' => 'Testa la connessione al database',
	'step_1a_0' => 'Cerco il file di configurazione protected/config.php... %s.',
	'step_1a_1' => 'Cerco di connettermi al database... %s.',
	'step_1b' => 'Scrivi &quot;protected/config.php&quot;',
	'step_1b_0' => 'Scrivo il file di configurazione... %s.',

	'step_2' => 'Testa &quot;protected/config.php&quot;',
	'step_2_0' => 'La tua configurazione sembra solida. Ora puoi provare ad installare le tabelle princiapali.',

	'step_3' => 'Installa le tabella princiapali',
	'create_table' => 'Creo le tabella per la classe %s... ',
	'step_3_0' => 'Ora creerò le tabella per le classi principali.<br/>Puoi trovarle nella cartella &quot;core/inc/&quot;.<br/>Ogni classe si occupa di una tabella del database.',

	'step_4' => 'Installa tabelle Nazione+Lingua',
	'step_4_0' => 'Ora puoi installare le tabelle nazione/lingua con o senza il mapping ip2country.<br/>Per installare il mapping IP2country potrebbero essere necessari alcuni minuti.',
	'step_4_1' => 'Installa tabelle Nazione+Lingua',
	'step_4_2' => 'Installa tabelle Nazione+Lingua+ip2country',

	'step_5' => 'Installa tabella useragent',
	'step_5_0' => 'Ora puoi installare il database degli useragent o procedere alla fase successiva.<br/>Siccome, per il momento, il database degli useragent è inutilizzato, ti consigliamo di procedere alla fase successiva.',
	'step_5_1' => 'Installa database useragent',

	'step_6' => 'Installa moduli',
	'step_6_0' => 'Ora potrai scegliere quali moduli installare.',
	'step_6_1' => 'Installo i moduli',

	'step_7' => 'Copia i file dinamici di esempio',

	'step_8' => 'Crea .htaccess',

	'step_9' => 'Create account amministrativi',

	'step_10' => 'Create Backup Folders',
	'step_10_0' => 'You should add the following to your crontab:<br/><br/>%s<br/>%s<br/><br/>You will find data here: %s.<br/><br/>Backup strategy is important!',

	'step_11' => 'Ripulisci la Cache',
	'step_11_0' => 'L\'installazione è finita.<br/>Tutte le cache sono state ripulite.<br/>Puoi effettuare il login ora o migliorare la protezione della cartella di installazione.',

	'step_12' => 'Proteggi la cartella di installazione',
	'step_12_0' => 'La tua cartella di installazione dovrebbe essere protetta, rispondendo con errori 404 ad ogni richiesta.',
	
	'msg_all_done' => 'Congratulazioni, la tua installazione è completa!<br/>Grazie per aver scelto GWF3<br/>Speriamo che sia di tuo gradimento.<br/><br/>gizmore e spaceone',
);
