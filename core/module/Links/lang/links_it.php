<?php

$lang = array(
	# Admin Config
	'cfg_link_guests' => 'Permetti agli utenti non registrati di aggiungere Links?',
	'cfg_link_guests_captcha' => 'Utilizza Captcha per gli utenti non registrati?',
	'cfg_link_guests_mod' => 'Utilizza moderazione sui link di utenti non registrati?',
	'cfg_link_guests_votes' => 'Permetti voto agli utenti non registrati?',
	'cfg_link_long_descr' => 'Usa una seconda/lunga descrizione?',
	'cfg_link_cost' => 'Punteggio per Link',
	'cfg_link_max_descr2_len' => 'Lunghezza massima descrizione lunga.',
	'cfg_link_max_descr_len' => 'Lunghezza massima descrizione breve.',
	'cfg_link_max_tag_len' => 'Lunghezza massima Tag',
	'cfg_link_max_url_len' => 'Lunghezza massima URL',
	'cfg_link_min_descr2_len' => 'Lunghezza minima descrizione lunga',
	'cfg_link_min_descr_len' => 'Lunghezza minima descrizione breve',
	'cfg_link_min_level' => 'Livello minimo per aggiungere un link',
	'cfg_link_per_page' => 'Link per pagina',
	'cfg_link_tag_min_level' => 'Livello minimo per aggiungere un Tag',
	'cfg_link_vote_max' => 'Punteggio voto massimo',
	'cfg_link_vote_min' => 'Punteggio voto minimo',
	'cfg_link_guests_unread' => 'Durata per cui un link appare nuovo per gli utenti non registrati',
	
	# Info`s
//	'pi_links' => '',
	'info_tag' => 'Specifichi almeno un Tag.<br/>Separa i Tag con delle virgole.<br/>Provi ad usare Tag preesistenti:',
	'info_newlinks' => 'Ci sono %s nuovi Link per lei.',
	'info_search_exceed' => 'La sua ricerca ha superato il limite massimo di risultati (%s).',

	# Titles
	'ft_add' => 'Aggiungi un Link',
	'ft_edit' => 'Modifica Link',
	'ft_search' => 'Cerca tra i Link',
	'pt_links' => 'Tutti i Link',
	'pt_linksec' => '%s link',
	'pt_new_links' => 'Nuovo Link',
	'mt_links' => GWF_SITENAME.', Link, List, All Links',
	'md_links' => 'All links on '.GWF_SITENAME.'.',
	'mt_linksec' => GWF_SITENAME.', Link, List, Links about %s',
	'md_linksec' => '%s links on '.GWF_SITENAME.'.',

	# Errors
	'err_gid' => 'Il gruppo utente è invalido.',
	'err_score' => 'Punteggio invalido.',
	'err_no_tag' => 'la preghiamo di specificare almeno un Tag.',
	'err_tag' => 'Il Tag %s è invalido ed è stato rimosso. Il Tag deve avere una lunghezza compresa tra %s e %s caratteri.',
	'err_url' => 'L\'URL sembra invalido.',
	'err_url_dup' => 'L\'URL è già stato inserito tra i link.',
	'err_url_down' => 'L\'URL non è raggiungibile.',
	'err_url_long' => 'L\'URL è troppo lungo. Deve avere una lunghezza massima inferiore a %s caratteri.',
	'err_descr1_short' => 'La descrizione è troppo corta. Deve avere una lunghezza minima superiore a %s caratteri.',
	'err_descr1_long' => 'La descrizione è troppo lunga. Deve avere una lunghezza massima inferiore a %s caratteri.',
	'err_descr2_short' => 'La descrizione dettagliata è troppo corta. Deve avere una lunghezza minima superiore a %s caratteri.',
	'err_descr2_long' => 'La descrizione dettagliata è troppo lunga. Deve avere una lunghezza massima inferiore a %s caratteri.',
	'err_link' => 'Link non trovato.',
	'err_add_perm' => 'Non è autorizzato ad aggiungere nuovi Link.',
	'err_edit_perm' => 'Non è autorizzato a modificare questo Link.',
	'err_view_perm' => 'Non è autorizzato a visualizzare questo Link.',
	'err_add_tags' => 'Non è autorizzato ad aggiungere nuovi Tag.',
	'err_score_tag' => 'Il suo livello(%s) non è sufficientemente alto per aggiungere un nuovo Tag. Livello richiesto: %s.',
	'err_score_link' => 'Il suo livello(%s) non è sufficientemente alto per aggiungere un nuovo Link. Livello richiesto: %s.',
	'err_approved' => 'Il ink è già stto approvato. la preghiamo di usare la sezione staff per eseguire delle modifiche.',
	'err_token' => 'Il token è invalido.',

	# Messages
//	'msg_redirecting' => 'Redirecting you to %s.',
	'msg_added' => 'Il Link è stato aggiunto al database.',
	'msg_added_mod' => 'Il Link è stato aggiunto al database, ma deve essere verificato da un Moderatore prima di essere pubblicato.',
	'msg_edited' => 'Il Link è stato modificato.',
	'msg_approved' => 'Il Link è stato modificato e verrà ora visualizzato.',
	'msg_deleted' => 'Il Link è stato cancellato.',
	'msg_counted_visit' => 'Il voto è stato conteggiato.',
	'msg_marked_all_read' => 'Imposta tutti i Link come già letti.',
	'msg_fav_no' => 'Il Link è stato rimosso dalla sua lista preferiti.',
	'msg_fav_yes' => 'Il Link è stato aggiunto alla sua lista preferiti.',

	# Table Headers
	'th_link_score' => 'Punteggio',
	'th_link_gid' => 'Gruppo',
	'th_link_tags' => 'Tags',
	'th_link_href' => 'HREF',
	'th_link_descr' => 'Descrizione',
	'th_link_descr2' => 'Descrizione dettagliata',
	'th_link_options&1' => 'Sticky?',
	'th_link_options&2' => 'In moderazione?',
	'th_link_options&4' => 'Non mostrare il nome utente?',
	'th_link_options&8' => 'Mostra solo agli utenti registrati?',
	'th_link_options&16' => 'Link privato?',
	'th_link_id' => 'ID',
	'th_showtext' => 'Link',
	'th_favs' => 'ContoFavoriti',
	'th_link_clicks' => 'Visite',
	'th_vs_avg' => 'Media',
	'th_vs_sum' => 'Somma',
	'th_vs_count' => 'Voti',
	'th_vote' => 'Vota',
	'th_link_date' => 'Inserisci data',
	'th_user_name' => 'Nome utente',

	# Tooltips
	'tt_link_gid' => 'Restringi il Link ad un gruppo utenti (oppure lascia vuoto)',
	'tt_link_score' => 'Specifica un livello minimo(0-NNNN)',
	'tt_link_href' => 'Invia un URL completo, comprendente http://',

	# Buttons
	'btn_add' => 'Aggiungi Link',
	'btn_delete' => 'Cancella Link',
	'btn_edit' => 'Modifica Link',
	'btn_search' => 'Ricerca',
	'btn_preview' => 'Anteprima',
	'btn_new_links' => 'Nuovi Links',
	'btn_mark_read' => 'Imposta tutti come già letti',
	'btn_favorite' => 'Imposta come Link favorito',
	'btn_un_favorite' => 'Rimuovi dai Link favoriti',
	'btn_search_adv' => 'Ricerca avanzata',

	# Staff EMail
	'mail_subj' => GWF_SITENAME.': Nuovo Link',
	'mail_body' =>
		'Caro Staff,'.PHP_EOL.
		PHP_EOL.
		'E\' stato pubblicato un nuovo Link da un utente non registrato, ed è richiesta la vostra validazione:'.PHP_EOL.
		PHP_EOL.
		'Descrizione: %s'.PHP_EOL.
		'Descrizione dettagliata.: %s'.PHP_EOL.
		'HREF / URL : %s'.PHP_EOL.
		PHP_EOL.
		'Potete anche: '.PHP_EOL.
		'1) Approvare il Link visitando %s'.PHP_EOL.
		'Or:'.PHP_EOL.
		'2) Cancellare il Link visitando %s'.PHP_EOL.
		PHP_EOL.
		'Cordiali saluti,'.PHP_EOL.
		'Gli script di '.GWF_SITENAME.PHP_EOL,
		
	# v2.01 (SEO)
	'pt_search' => 'Cerca tra i Link',
	'md_search' => 'Search links on the '.GWF_SITENAME.' website.',
	'mt_search' => 'Search,'.GWF_SITENAME.',Links',
		
	# v2.02 (permitted)
	'permtext_in_mod' => 'Il Link è in moderazione',
	'permtext_score' => 'E\' richiesto un livello utente di %s per vedere questo Link',
	'permtext_member' => 'Questo Link è visualizzabile solo da utenti non registrati',
	'permtext_group' => 'Deve essere nel gruppo %s per vedere questo Link',
	'cfg_show_permitted' => 'Mostra la ragione per cui sono proibiti certi Link?',
		
	# v3.00 (fixes)
	'cfg_link_check_amt' => 'Ammontare UpDownChecker',
	'cfg_link_check_int' => 'Intervallo UpDownChecker',
		
);

?>