<?php
$lang = array(
	# You need to branch these in a new langfile for adding default titles!
	'titles' => array(
		'0' => 'La preghiamo di selezionare un titolo',
		'website' => 'Ho problemi ad usare il sito',
		'order' => 'Ho pagato per un ordine, ma non ho ricevuto l\'oggetto',
		'trans' => 'Ho rilevato degli errori nella traduzione',
		'error' => 'Ho incotrato un errore sul sito',
		'other' => 'Altro problema:',
	),

	'pt_helpdesk' => 'Helpdesk ',
	'pi_helpdesk' => 'Benvenuto all\'helpdesk. Si senta libero di crea nuovi tickets, per poter risolvere l\'errore che ha incontrato.',
	
	'pt_new_ticket' => 'Helpdesk - Crea un nuovo ticket',
	'pi_new_ticket' => 'la preghiamo di inviarci quanti più dati possibili relativi all\'errore incontrato. Che cosa stava cercando di fare? Che cosa si aspettava accadesse?', 

	'pt_faq' => 'FAQ (Domande frequenti)',
	'pi_faq' => 'Visualizza le domande più frequenti che sono state generate dai ticket inviati all\'helpdesk.',
	
	'ft_new_ticket' => 'Crea un nuovo ticket',
	'ft_reply' => 'Replica al ticket',
	'ft_add_faq' => 'Aggiungi una domanda alle FAQ',
	'ft_edit_faq' => 'Modifica una domanda delle FAQ',
	
	'btn_reply' => 'Replica',
	'btn_new_ticket' => 'Nuovo Ticket',
	'btn_my_tickets' => 'Il mio Tickets',
	'btn_staffdesk' => 'Area Staff',
	'btn_work' => 'Reclama Ticket', 
	'btn_faq' => 'Permetti',
	'btn_nofaq' => 'Vieta',
	'btn_close' => 'Chiudi Ticket (risolto)',
	'btn_unsolve' => 'Chiudi Ticket (irrisolvibile)',
	'btn_infaq' => 'Inserisci nelle FAQ',
	'btn_noinfaq' => 'Nascondi dalle FAQ',
	'btn_show_open' => 'Aperto',
	'btn_show_work' => 'Richiesto',
	'btn_show_closed' => 'Chiuso',
	'btn_show_unsolved' => 'Irrisolto',
	'btn_show_own' => 'Miei',
	'btn_show_all' => 'Tutti',
	'btn_show_faq' => 'FAQ ',
	'btn_add_faq' => 'Aggiungi FAQ',
	'btn_edit_faq' => 'Modifica FAQ',
	'btn_rem_faq' => 'Rimuovi FAQ',
	'btn_gen_faq' => 'Genera FAQ',
	
	'err_token' => 'Il token non corrisponde.',
	'err_not_open' => 'Il ticket non è aperto.',
	'err_ticket' => 'Questo ticket è sconosciuto.',
	'err_message' => 'Il messaggio deve avere una lunghezza compresa tra %s e %s caratteri.',
	'err_no_other' => 'La preghiamo di specificare un titolo quando si seleziona un altro titolo.',
	'err_other_len' => 'Il titolo è troppo lungo. Al massimo %s caratteri.',
	'err_title' => 'La preghiamo di selezionare un titolo valido per "Altro problema:" e di specificarne uno.',
	'err_priority' => 'La priorità deve essere compresa tra %s e %s.',
	'err_tmsg' => 'Il messaggio per questo ticket non è stato trovato.',
	'err_two_workers' => 'Il ticket è già stato assegnato ad un lavoratore.',
	'err_no_faq' => 'Questo utente non vuole avere questo elemento aggiunto alle FAQ.',
	'err_question' => 'La domanda deve avere una lunghezza compresa tra %s e %s caratteri.',
	'err_answer' => 'La risposta deve avere una lunghezza compresa tra %s e %s caratteri.',
	'err_faq' => 'L\'elemento delle FAQ non è stato trovato.',
	'err_confirm_delete' => 'La preghiamo di selezionare la casella per la cancellazione per procedere con la cancellazione.',
	
	'msg_created' => 'Il suo ticket è stato creato.',
	'msg_assigned' => 'Il Ticket #%s è ora assegnato a %s.',
	'msg_raised' => 'La priorità è stato alzata di %s.',
	'msg_lowered' => 'La priorità è stata abbassata di %s.',
	'msg_replied' => 'Ha rispostao al ticket.',
	'msg_read' => 'Il messaggio è stato impostato come letto.',
	'msg_faq' => 'Il ticket è stato autorizzato ad essere visualizzato nelle FAQ.',
	'msg_nofaq' => 'Non è possibile visualizzare il ticket nelle FAQ.',
	'msg_infaq' => 'Il ticket è ora visibile nelle FAQ.',
	'msg_noinfaq' => 'Il ticket non è visibile nelle FAQ.',
	'msg_solve_solved' => 'Il ticket è ora impostato come chiuso.',
	'msg_solve_unsolved' => 'Il ticket è ora chiuso e impostato come irrisolvibile.',
	'msg_mfaq_0' => 'Il messaggio non è più parte delle FAQ.',
	'msg_mfaq_1' => 'Il messaggio fa ora parte delle FAQ.',
	'msg_new_faq' => 'Il ticket è stato aggiunto alle FAQ.',
	'msg_rem_faq' => 'Il ticket è stato rimosso dalla FAQ.',
	'msg_faq_add' => 'Una nuova domanda è stata aggiunta alle FAQ.',
	'msg_faq_del' => 'La domanda è stata cancellata alle FAQ.',
	'msg_faq_edit' => 'La domanda è stata modificata.',
	
	'th_tid' => '# ',
	'th_prio' => 'Pri ',
	'th_creator' => 'Creato da',
	'th_worker' => 'Assegnato a',
	'th_status' => 'Stato',
	'th_title' => 'Titolo',
	'th_other' => 'Titolo personalizzato',
	'th_email_me' => 'Invia una E-Mail quando un ticket è aggiornato',
	'th_allow_faq' => 'Permetti di inserire il ticket tra le FAQ',
	'tt_allow_faq' => 'Se selezioanto, permetterai l\'utilizzo delle tue domande e messaggi nelle pagina delle FAQ. Può dare l\'autorizzazione anche in seguito.',
	'th_message' => 'Il tuo messaggio',
	'th_priority' => 'Priorità',
	'th_unread' => 'Nuovo messaggio',
	'th_lang' => 'Lingua',
	'tt_lang' => 'Lasci vuoto per tutti i messaggi.',
	'th_question' => 'Domanda',
	'th_answer' => 'Risposta',
	'th_confirm_del' => 'Cancella',
	
	'info_ticket_faq' => 'Questo utente permette l\'utilizzo del suo ticket nella FAQ.',
	'info_ticket_nofaq' => 'Questo utente non permette l\'utilizzo del suo ticket nella FAQ.',
	'info_ticket_infaq' => 'Questo ticket è visualizzato nelle FAQ.',
	'info_ticket_noinfaq' => 'Questo ticket non è visualizzato nelle FAQ.',
	'info_msg_faq' => 'Questo messaggio è visualizzato nelle FAQ.',
	'info_msg_nofaq' => 'Questo messaggio non è visualizzato nelle FAQ.',
	
	'status_open' => 'Aperto',
	'status_working' => 'In risoluzione',
	'status_solved' => 'Chiuso',
	'status_unsolved' => 'Irrisolvibile',
	
	### EMails ###
	'subj_nt' => 'Nuovo ticket #%s su '.GWF_SITENAME,
	'body_nt' =>
		'Caro %s, '.PHP_EOL.
		PHP_EOL.
		'Un nuovo ticket dell\'helpdesk è stato creato su '.GWF_SITENAME.'.'.PHP_EOL.
		'Da: %s'.PHP_EOL.
		'Titolo: %s'.PHP_EOL.
		'Messaggio:'.PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'Puoi richiedere di lavorare su questo ticket immediatamente visitando il link sottostante:'.PHP_EOL.
		'%s'.PHP_EOL,
		
	'subj_nmu' => 'Ticket #%s su '.GWF_SITENAME,
	'body_nmu' =>
		'Caro %s, '.PHP_EOL.
		PHP_EOL.
		'Qualcuno ha replicato al suo ticket dell\'helpdesk.'.PHP_EOL.
		PHP_EOL.
		'Da: %s'.PHP_EOL.
		'Messaggio:'.PHP_EOL.
		PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'Se è soddisfatto della risposta e il problema è risolto, la preghiamo di chiudere il ticket visitando il link sottostante:'.PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'Altrimenti, imposto il messaggio come letto visitando il link sottostante:'.PHP_EOL.
		'%s'.PHP_EOL,

	'subj_nms' => ' Ticket #%s '.GWF_SITENAME,
	'body_nms' =>
		'Salve %s, '.PHP_EOL.
		PHP_EOL.
		'Qualcuno ha replicato al ticket dell\'helpdesk.'.PHP_EOL.
		'Da: %s'.PHP_EOL.
		'Messaggio:'.PHP_EOL.
		PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'La preghiamo di impostare il messaggio come letto visitando il link sottostante:'.PHP_EOL.
		'%s'.PHP_EOL,
		
);
?>