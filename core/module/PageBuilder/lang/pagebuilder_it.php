<?php
$lang = array(
	'ft_add' => 'Aggiungi una nuova pagina',
	'ft_edit' => 'Modifica questa pagina',
	'ft_translate' => 'Traduci questa pagina',

	'lang_all' => 'Tutti',

	'th_id' => 'ID ',
	'th_otherid' => 'PID ',
	'th_type' => 'Tipo',
	'th_cat' => 'Categoria',
	'th_url' => 'URL ',
	'th_groups' => 'Gruppi autorizzati',
	'th_title' => 'Titolo',
	'th_descr' => 'Descrizione',
	'th_tags' => 'Tags ',
	'th_content' => 'Contenuto',
	'th_inline_css' => 'Inserisci codice CSS',
	'th_noguests' => 'Login richiesto',
	'th_lang' => 'Lingua',
	'th_enabled' => 'Attivato',
	'th_file' => 'File ',
	'th_show_author' => 'Mostra autore',
	'th_show_similar' => 'Mostra pagine simili',
	'th_show_modified' => 'Mostra data di modifica',
	'th_show_trans' => 'Mostra traduzioni disponibili',
	'th_show_comments' => 'Permetti commenti',
	'th_home_page' => 'Imposta come HomePage di GWF',
	'th_index' => 'Permetti indicizzazione',
	'th_follow' => 'Permetti seguito',
	'th_in_sitemap' => 'Inserisci nella mappa del sito',

	'sel_type' => 'Seleziona un tipo',
	'type_html' => 'HTML ',
	'type_bbcode' => 'BBCode ',
	'type_smarty' => 'Smarty ',

	'btn_add_page' => 'Aggiungi Pagina',
	'btn_add_link' => 'Aggiungi Link',
	'btn_add' => 'Aggiungi Pagina', // @deprecated
	'btn_edit' => 'Modifica',
	'btn_translate' => 'Traduci',
	'btn_upload' => 'Upload ',

	'err_page' => 'Pagina sconosciuta.',
	'err_404' => 'Per pagina richiesta non esiste.',
	'err_url' => 'L\'URL sembra invalido o eccede 255 caratteri. Non può cominciare con /.',
	'err_groups' => 'I gruppi selezionati sono invalidi.',
	'err_title' => 'Il titolo della pagina è invalido. La lunghezza deve essere compresa tra %s e %s caratteri.',
	'err_descr' => 'La descrizione Meta è invalida. La lunghezza deve essere compresa tra %s e %s caratteri.',
	'err_tags' => 'I tags sono invalidi. In totale, devono avere una lunghezza compresa tra %s e %s caratteri.',
	'err_content' => 'Il contenuto della pagina non è valido. La lunghezza deve essere compresa tra %s e %s caratteri.',
	'err_inline_css' => 'Il codice CSS è invalido. Non è necessario una tag/un commento CSS.',
	'err_dup_lid' => 'Un pagina tradotta con questo linguaggio esiste già.',
	'err_file_ext' => 'L\'estensione del file caricato non è valida. Appendi &quot;.html&quot; ad esso.',
	'err_upload_exists' => 'Un file con quel nome è già presente.',
	'err_type' => 'Il tipo di pagina è invalido. Deve essere html, bbcode oppure smarty.',

	'msg_added' => 'La <a href="%s" title="%s">pagina</a> è stata aggiunta con successo.',
	'msg_edited' => 'La <a href="%s" title="%s">pagina</a> è stata modificata con successo.',
	'msg_trans' => 'Una nuova pagina è stata creata e serve da traduzione per la pagina corrente.',
	'msg_file_upped' => 'Il file è stato caricato su %s.',
	'msg_no_trans' => 'Non ci sono traduzioni disponibili. Se vuole, può tradurre questa pagina.',

	'info_author' => 'Autore: %s',
	'info_modified' => 'pagina creata su %s. Ultima modifica il %s, %s.',
	'info_trans' => 'La pagina è disponibile in %s.',
	'info_similar' => 'Può essere interessato a pagine simili: %s.',
	'info_pageviews' => 'La pagina è stata richiesta %s volte.',

	'author' => 'Autore',
	'created_on' => 'Creata il',
	'modified_on' => 'Modificata il',
	'translations' => 'Traduzioni disponibili',
	'similar_pages' => 'Pagine simili',
	'page_views' => 'Visite',

	'cfg_home_page' => 'PageID della homepage di GWF o 0 per nessuna',
//	'cfg_ipp' => '',

	# monnino fixes 
	'btn_show_published' => 'Mostra pubblicate', 
	'btn_show_revisions' => 'Mostra revisioni',
	'btn_show_disableds' => 'Mostra disabilitate',
	'btn_show_locked' => 'Mostra non moderati',
		
	#v1.05 Searching, Locked pages and Overview
	'overview_title' => 'Panoramica della pagina su '.GWF_SITENAME,
	'mt_overview' => 'Pagine,Saggi,Tutorial,'.GWF_SITENAME,
	'md_overview' => 'Una panoramica delle pagine, dei saggi e dei tutorial su '.GWF_SITENAME,
	'overview_info' =>
	'BLA SEARCH.'.PHP_EOL.
	'BLA ADD',
	'translate_to' => 'Traduci in %s',
	'ft_search' => 'Ricerca Rapida',
	'th_term' => 'Termini di ricerca',
	'btn_search' => 'Cerca',
	'btn_unlock' => 'Sblocca',
	'btn_delete' => 'Cancella',
	'msg_added_locked' => 'La tua pagina è stata creata ma dovrà essere controllata prima di essere pubblicata.',
	'msg_del_confirm' => 'Per cancellare una pagina clicca qui: <a href="%s">Cancella pagina</a>.',
	'msg_unlock_confirm' => 'Per pubblicare la pagina clicca qui: <a href="%s">Pubblica pagina</a>.',
	'err_dup_url' => 'L\'URL è già stato riservato per un altra risorsa. E\' pregato di sceglierne un altro.',
	'err_locked' => 'Questa pagina è ancora in attesa di essere controllata e pubblicata.',
	'cfg_locked_posting' => 'Permetti commenti agli utenti non registrati?',
	'cfg_author_level' => 'Livello minimo per aggiungere una pagina',
	'cfg_ipp' => 'Elementi per pagina',
	'cfg_authors' => 'Gruppo Utenti dell\'autore',
	'tt_cfg_locked_posting' => 'Setta per consentire agli utenti senza privilegi di creare pagine che finiranno nella coda di moderazione.',
	'tt_cfg_authors' => 'Lista, separata da virgole, dei nomi dei Gruppi utente.',
	'btn_preview' => 'Anteprima',
	'msg_enabled' => 'La pagine è ora <a href="%s">visibile qui</a>.',
	'msg_edit_locked' => 'La tua pagina è stata modificata ma sarà controllata prima di essere pubblicata.',
	'err_token' => 'Il token è invalido perchè la pagina è già stata inserita nella coda di moderazione.',
	'subj_mod' => GWF_SITENAME.': Moderazione Pagina',
	'body_mod' =>
	'Ciao %s'.PHP_EOL.
	PHP_EOL.
	'L\'utente %s ha appena creato o modificato una pagina o una traduzione su '.GWF_SITENAME.'.'.PHP_EOL.
	PHP_EOL.
	'URL: %s'.PHP_EOL.
	'Titolo: %s'.PHP_EOL.
	'Meta-Tag: %s'.PHP_EOL.
	'Descrizione: %s'.PHP_EOL.
	'Inline-CSS:'.PHP_EOL.
	'%s'.PHP_EOL.
	PHP_EOL.
	'Contenuto:'.PHP_EOL.
	'%s'.PHP_EOL.
	PHP_EOL.
	PHP_EOL.
	'Puoi usare questi URL per la moderazione veloce:'.PHP_EOL.
	'AUTORIZZA: %s'.PHP_EOL.
	PHP_EOL.
	'o'.PHP_EOL.
	PHP_EOL.
	'CANCELLA: %s'.PHP_EOL.
	PHP_EOL.
	'Cordiali saluti,'.PHP_EOL.
	'Gli script di '.GWF_SITENAME.PHP_EOL,
);
?>
