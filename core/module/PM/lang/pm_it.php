<?php # Italian PM by monnino
$lang = array(
	'hello' => 'Salve %s',
	'sel_username' => 'Scegli Username',
	'sel_folder' => 'Scegli Cartella',

	# Info
	'pt_guest' => 'PM da utenti non registrati su '.GWF_SITENAME,
	'pi_guest' => 'Su '.GWF_SITENAME.' è possibile inviare un PM ad un altro utente senza essere connessi, ma quell\'utente non potrà rispondere. Tuttavia, può essere utilizzato per notificare un bug velocemente.',
	'pi_trashcan' => 'Questo è il tuo Cestino, i messaggi non sono realmente cancellati, ma possono essere ripristinati.',
	
	# Buttons
	'btn_ignore' => 'Inserisci %s nella tua Lista Ignorati',
	'btn_ignore2' => 'Ignora',
	'btn_save' => 'Salva opzioni',
	'btn_create' => 'Nuovo PM',
	'btn_preview' => 'Anteprima',
	'btn_send' => 'Invia PM',
	'btn_delete' => 'Cancella',
	'btn_restore' => 'Ripristina',
	'btn_edit' => 'Modifica',
	'btn_autofolder' => 'Auto-Folder',
	'btn_reply' => 'Replica',
	'btn_quote' => 'Cita',
	'btn_options' => 'Opzioni PM',
	'btn_search' => 'Ricerca',
	'btn_trashcan' => 'Cestino',
	'btn_auto_folder' => 'Consenti Auto-Fold PMs',

	# Errors
	'err_pm' => 'Il PM non esiste.',
	'err_perm_read' => 'Non sei autorizzato a leggere questo PM.',
	'err_perm_write' => 'Non sei autorizzato a modificare questo PM.',
	'err_no_title' => 'Ha dimenticato il titolo del PM.',
	'err_title_len' => 'Il titolo è troppo lungo. Sono permessi al massimo %s caratteri.',
	'err_no_msg' => 'Ha dimenticato il messaggio.',
	'err_sig_len' => 'La firma è troppo lunga. Sono permessi al massimo %s caratteri.',
	'err_msg_len' => 'Il messaggio è troppo lungo. Sono permessi al massimo %s caratteri.',
	'err_user_no_ppm' => 'Questo utente non vuole ricevere PM pubblici.',
	'err_no_mail' => 'Non ha un E-Mail validata associata al suo account.',
	'err_pmoaf' => 'Il valore per l\'auto-folders non è valido.',
	'err_limit' => 'Ha raggiunto il suo limite di PM inviabili in un giorno. Può inviare un massimo di %s PMs in %s.',
	'err_ignored' => '%s vi ha messo sulla sua Lista Ignorati:<br/>%s',
	'err_delete' => 'Si è verificato un errore durante la cancellazione dei suoi messaggi.',
	'err_folder_exists' => 'La cartella esiste già.',
	'err_folder_len' => 'La lunghezza del nome della cartella deve essere compreso tra 1 e %s caratteri.',
	'err_del_twice' => 'Ha già cancellato questo PM.',
	'err_folder' => 'La cartella è sconosciuta.',
	'err_pm_read' => 'Il suo PM è già stato letto, per cui non può più essere modificato.',

	# Messages
	'msg_sent' => 'Il Pm è stato inviato con successo. Può ancora modificarlo, fino a che non sarà letto.',
	'msg_ignored' => 'Ha messo %s nella sua Lista Ignorati.',
	'msg_unignored' => 'Ha rimosso %s dalla sua Lista Ignorati.',
	'msg_changed' => 'Le sue opzioni sono state modificate.',
	'msg_deleted' => 'Ha cancellato con successo %s PMs.',
	'msg_moved' => 'Ha spostato con successo %s PMs.',
	'msg_edited' => 'Il suo PM è stato modificato.',
	'msg_restored' => 'Ha ripristinato con successo %s PMs.',
	'msg_auto_folder_off' => 'Lei non ha l\'opzione Auto-folders attivata. Il PM è stato contrassegnato come già letto.',
	'msg_auto_folder_none' => 'Ci sono solo %s messaggi da/per questo utente. Niente è stato spostato. Il PM è stato contrassegnato come già letto.',
	'msg_auto_folder_created' => 'Crea cartella %s.',
	'msg_auto_folder_moved' => '%s messaggi sono stati spostati alla cartella %s. I PM(s) sono stati contrassegnati come già letti.',
	'msg_auto_folder_done' => 'Auto-Folders eseguito.',


	# Titles
	'ft_create' => 'Scrivi a %s un nuovo PM',
	'ft_preview' => 'Anteprima',
	'ft_options' => 'Opzioni PM',
	'ft_ignore' => 'Aggiungi un utente alla Lista Ignorati',
	'ft_new_pm' => 'Scrivi un nuovo PM',
	'ft_reply' => 'Replica a %s',
	'ft_edit' => 'Modifica PM',
	'ft_quicksearch' => 'Ricerca Rapida',
	'ft_advsearch' => 'Ricerca Avanzata',

	# Tooltips
	'tt_pmo_auto_folder' => 'Se un utente le invia questo numero di messaggi, i suoi messaggi vengono messi in una cartella a parte automaticamente.',
	
	# Table Headers
	'th_pmo_options&1' => 'Invia una E-Mail ad un nuovo PM',
	'th_pmo_options&2' => 'Permetti agli utenti non registrati di inviarmi PM',
	'th_pmo_auto_folder' => 'Crea cartella utente dopo n PM',
	'th_pmo_signature' => 'Firma PM',

	'th_pm_options&1' => 'Nuovo',
	'th_actions' => '  ',
	'th_user_name' => 'Nome Utente',
	'th_pmf_name' => 'Cartella',
	'th_pmf_count' => 'Totale',
	'th_pm_id' => 'ID ',
	'th_pm_to' => 'A',
	'th_pm_from' => 'Da',
//	'th_pm_to_folder' => 'To Folder',
//	'th_pm_from_folder' => 'From Folder',
	'th_pm_date' => 'Data',
	'th_pm_title' => 'Titolo',
	'th_pm_message' => 'Messaggio',
//	'th_pm_options' => 'Options',

	# Welcome PM
	'wpm_title' => 'Benvenuto su '.GWF_SITENAME,
	'wpm_message' => 
		'Caro %s'.PHP_EOL.
		PHP_EOL.
		'Benvenuto su'.GWF_SITENAME.''.PHP_EOL.
		PHP_EOL.
		'Speriamo che le piacca il nostro sito e si possa divertire.'.PHP_EOL,
		
	# New PM Email
	'mail_subj' => GWF_SITENAME.': Nuovo PM da %s',
	'mail_body' =>
		'Salve %s'.PHP_EOL.
		PHP_EOL.
		'Le è stato inviato un PM su '.GWF_SITENAME.'.'.PHP_EOL.
		PHP_EOL.
		'Da: %s'.PHP_EOL.
		'Titolo: %s'.PHP_EOL.
		PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		PHP_EOL.
		'--------------------------------------------------------------------------'.
		PHP_EOL.
		PHP_EOL.
		'Può velocemente:'.PHP_EOL.
		'Spostare automaticamente il messaggio in una cartella (Auto-Folder):'.PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'Cancella il messaggio:'.PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'Cordiali saluti,'.PHP_EOL.
		'Il Bot di '.GWF_SITENAME.PHP_EOL,
		
	# Admin Config
	'cfg_pm_captcha' => 'Usa Captcha per gli utenti non registrati?',
	'cfg_pm_causes_mail' => 'Permetti E-Mail per i PM?',
	'cfg_pm_for_guests' => 'Permetti PM agli utenti non registrati?',
	'cfg_pm_welcome' => 'Invia PM di benvenuto?',
	'cfg_pm_limit' => 'Numero massimo di PM nell\'intervallo stabilito',
	'cfg_pm_maxfolders' => 'Cartelle Massime per Utente',
	'cfg_pm_msg_len' => 'Lunghezza Massima Messaggio',
	'cfg_pm_per_page' => 'PM per Pagina',
	'cfg_pm_sig_len' => 'Lunghezza Massima Firma',
	'cfg_pm_title_len' => 'Lunghezza Massima Titolo',
	'cfg_pm_bot_uid' => 'Mittente PM di Benveuto',
	'cfg_pm_sent' => 'Contatore PM Inviati',
	'cfg_pm_mail_sender' => 'Mittente E-mail per invio PM',
	'cfg_pm_re' => 'Pre-appendi Titolo',
	'cfg_pm_limit_timeout' => 'Intervallo per Limite PM',
	'cfg_pm_fname_len' => 'Lunghezza Massima Nome Cartella',
	
	# v2.01
	'err_ignore_admin' => 'Non può aggiungere un amministratore alla sua Lista Ignorati.',
	'btn_new_folder' => 'Nuova Cartella',
		
	# v2.02
	'msg_mail_sent' => 'Una E-Mail contente il suo messaggio è stata inviata a %s.',
		
	# v2.03 SEO
	'pt_pm' => 'PM ',
		
	# v2.04 fixes
	'ft_new_folder' => 'Crea una nuova cartella',

	# v2.05 (prev+next)
	'btn_prev' => 'Messaggio precedente',
	'btn_next' => 'Messaggio successivo',
		
	# v2.06 (icon titles+bots)
	'gwf_pm_deleted' => 'L\'altro utente ha cancellato questo PM.',
	'gwf_pm_read' => 'L\'altro utente ha letto questo PM.',
	'gwf_pm_unread' => 'L\'altro utente non ha ancora cancellato questo PM.',
	'gwf_pm_old' => 'Vecchia PM per lei.',
	'gwf_pm_new' => 'Nuovo PM per lei.',
	'err_bot' => 'I Bot non possono inviare messaggi.',

	# v2.07 (fixes)
	'err_ignore_self' => 'Non può ignorarsi.',
	'err_folder_perm' => 'Questa cartella non è sua.',
	'msg_folder_deleted' => 'La cartella %s e %s messaggi sono stati spostati nel cestino.',
	'cfg_pm_delete' => 'Permetti cancellazioni PM?',
	'ft_empty' => 'Svuota cestino',
	'msg_empty' => 'Il suo cestino (%s messaggi) è stato svuotato.<br/>%s messaggi sono stati rimossi dal database.<br/>%s messaggi sono ancora in uso da altri utenti e non sono stati cancellati.',
		
	# v2.08 (GT)
	'btn_translate' => 'Traduci con Google',
		
	# monnino fixes
	'cfg_pm_limit_per_level' => 'Limite PM per livello',
	'cfg_pm_own_bot' => 'Invia PM ',
	'th_reason' => 'Motivo',
	# v2.09 (pmo_level)
	'err_user_pmo_level' => 'This user requires you to have a userlevel of %s to send him PM.',
	'th_pmo_level' => 'Min userlevel of sender',
	'tt_pmo_level' => 'Set a minimal userlevel requirement to allow to send you PM',
);
