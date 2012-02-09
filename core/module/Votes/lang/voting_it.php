<?php

$lang = array(
## SCOREVOTE ##

	# votebuttons.php
	'alt_button' => 'Vota %s',
	'title_button' => 'Vota %s',

	# Errors
	'err_votescore' => 'Tabella dei voti non trovata per questo elemento.',
	'err_score' => 'Il punteggio votata non è valido.',
	'err_expired' => 'I voti per questo elemento sono scaduti.',
	'err_disabled' => 'I voti per questo elemento sono momentaneamente disabilitati.',
	'err_vote_ip' => 'Questo elemento è già stato votato dal tuo IP.',
	'err_no_guest' => 'Gli utenti non registrati non sono autorizzati a votare questo elemento.',
	'err_title' => 'Il titolo deve essere compreso tra %s e %s caratteri.',
	'err_options' => 'Le opzioni del sondaggio %s sono erronee e probabilmente non rientrano nell\'intervallo limite di caratteri (%s-%s).',
	'err_no_options' => 'Non hai specificato alcuna opzione.',

	# Messages
	'msg_voted' => 'Voto registrato. <a href="%s">Clicca qui</a> per tornare alla pagina precedente.',

	## POLLS ##

	'poll_votes' => '%s Voti',
	'votes' => 'voti',
	'voted' => 'voti',
	'vmview_never' => 'Mai',
	'vmview_voted' => 'Dopo il voto',
	'vmview_allways' => 'Sempre',

	'th_date' => 'Data',
	'th_votes' => 'Voti',
	'th_title' => 'Titolo',
	'th_multi' => 'Consenti scelte multiple?',
	'th_option' => 'Opzione %s',
	'th_guests' => 'Permetti il voto agli utenti non registrati?',
	'th_mvview' => 'Mostra risultati',
	'th_vm_public' => 'Mostra nella barra laterale?',
	'th_enabled' => 'Attivato?',
	'th_top_answ' => 'Risposta più frequente',

	'th_vm_gid' => 'Restringi al gruppo',		
	'th_vm_level' => 'Livello minimo per partecipare',

	'ft_edit' => 'Modifica il sondaggio',
	'ft_add_poll' => 'Assegna uno dei sondaggi ad un thread',
	'ft_create' => 'Crea nuovo sondaggio',

	'btn_edit' => 'Modifica',
	'btn_vote' => 'Vota',
	'btn_add_opt' => 'Aggiungi Opzione',
	'btn_rem_opts' => 'Rimuovi tutte le Opzioni',
	'btn_create' => 'Crea sondaggio',

	'err_multiview' => 'La view-flag per questo sondaggio è invalida.',
	'err_poll' => 'Il sondaggio è sconosciuto.',
	'err_global_poll' => 'Non si dispone dell\'autorizzazione per creare un sondaggio globale.',
	'err_option_empty' => 'L\'opzione %s è vuota.',
	'err_option_twice' => 'L\'opzione %s appare più volte.',
	'err_no_options' => 'Ha dimenticato di specificare un\'opzione per il sondaggio.',
	'err_no_multi' => 'Può scegliere una sola opzione.',
	'err_poll_off' => 'Il sondaggio è temporaneamente disabilitato.',
	
	'msg_poll_edit' => 'Il sondaggio è stato modificato con successo.',
	'msg_mvote_added' => 'Il sondaggio è stato aggiunto con successo.',

	# v2.01 Staff
	'th_vs_id' => 'ID ',
	'th_vs_name' => 'Nome',
	'th_vs_expire_date' => 'Scade',
	'th_vs_min' => 'Min ',
	'th_vs_max' => 'Max ',
	'th_vs_avg' => 'Media',
	'th_vs_sum' => 'Somma',
	'th_vs_count' => 'Totale',

	# v2.02
	'th_reverse' => 'Voti modificabili?',
	'err_irreversible' => 'Hai già votato questo elemento e i voti per questo sondaggio non sono modificabili.',
	'err_pollname_taken' => 'Il nome del sondaggio è già stato utilizzato.',

	# v3.00 (fixes)
	'err_gid' => 'La preghiamo di selezionare un gruppo valido.',
	'msg_voted_ajax' => 'Grazie per il suo voto.',
		
	#monnino fixes
	'cfg_vote_guests' => 'Permetti voto agli utenti non registrati',
	'cfg_vote_iconlimit' => 'Limite icone',
	'cfg_vote_option_max' => 'Numero massimo di opzioni',
	'cfg_vote_option_min' => 'Numero minimo di opzioni',
	'cfg_vote_poll_level' => 'Livello minimo del sondaggio',
	'cfg_vote_title_max' => 'Lunghezza massima titolo sondaggio',
	'cfg_vote_title_min' => 'Lunghezza minima titolo sondaggio',
	'cfg_vote_poll_group' => 'Gruppo del sondaggio',
	'cfg_vote_guests_timeout' => 'Timeout del voto per utenti non registrati',
	'ft_edit_vs' => 'Modifica punteggio voto',
);

?>
