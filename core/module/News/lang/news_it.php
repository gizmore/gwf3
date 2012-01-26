<?php

$lang = array(
	
	# Messages
	'msg_news_added' => 'La novità è stata aggiunta con successo.',
	'msg_translated' => 'Ha tradotto la notizia \'%s\' in %s. Complimenti.',
	'msg_edited' => 'La notizia \'%s\' in %s è stata modificata.',
	'msg_hidden_1' => 'La notizia è ora nascosta.',
	'msg_hidden_0' => 'La notizia è ora visibile.',
	'msg_mailme_1' => 'La notizia è stata messa dalla coda delle E-Mail.',
	'msg_mailme_0' => 'La notizia è stata rimossa dalla coda delle E-Mail.',
	'msg_signed' => 'Ti sei iscritto alla Newsletter.',
	'msg_unsigned' => 'Hai cancellato la sottoscrizione alla Newsletter.',
	'msg_changed_type' => 'Ha cambiato il formato della sottoscrizione alla Newsletter.',
	'msg_changed_lang' => 'Ha cambiato il linguaggio preferito della sottoscrizione alla Newsletter.',

	# Errors
	'err_email' => 'L\'E-mail è invalida.',
	'err_news' => 'La novità è sconosciuta.',
	'err_title_too_short' => 'Il titolo è troppo corto.',
	'err_msg_too_short' => 'Il messaggio è troppo breve.',
	'err_langtrans' => 'Il linguaggio non è supportato.',
	'err_lang_src' => 'Il linguaggio d\'origine è sconosciuto.',
	'err_lang_dest' => 'Il linguaggio di destinazione è sconosciuto.',
	'err_equal_translang' => 'Il inguaggio di origine e di destinazione sono uguali (Entrambi %s).',
	'err_type' => 'Il formato della newsletter è invalido.',
	'err_unsign' => 'Si è verificato un errore.',


	# Main
	'title' => 'Novità',
	'pt_news' => 'Novità da %s',
	'mt_news' => 'Novità, '.GWF_SITENAME.', %s',
	'md_news' => GWF_SITENAME.' Novità, pagina %s di %s.',

	# Table Headers
	'th_email' => 'E-mail',
	'th_type' => 'Formato Newsletter',
	'th_langid' => 'Linguaggio Newsletter',
	'th_category' => 'Categoria',
	'th_title' => 'Titolo',
	'th_message' => 'Messaggio',
	'th_date' => 'Data',
	'th_userid' => 'Utente',
	'th_catid' => 'Categoria',
	'th_newsletter' => 'Invia novità<br/>La pregiamo di controllare ed utilizzare la funzione Anteprima!',

	# Preview
	'btn_preview_text' => 'Versione Testo Semplice',
	'btn_preview_html' => 'Version HTML',
	'preview_info' => 'Puoi accedere alle anteprime delle novità qui:<br/>%s e %s.',

	# Show 
	'unknown_user' => 'Utente sconosciuto',
	'title_no_news' => '~~~~',
	'msg_no_news' => 'Non ci sono ancora novità in questa categoria.',

	# Newsletter
	'newsletter_title' => GWF_SITENAME.': Novità',
	'anrede' => 'Caro %s',
	'newsletter_wrap' =>
		'%s, '.PHP_EOL.
		PHP_EOL.
		'Si è iscritto alla newsletter di '.GWF_SITENAME.' e ci sono delle novità per lei.'.PHP_EOL.
		'Per rimuovere la sottoscrizione alla newsletter visiti il seguente link:'.PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'<hr/>'.PHP_EOL.
		PHP_EOL.
		'L\'articolo sulla novità è riportato di seguito:'.PHP_EOL.
		PHP_EOL.
		'<hr/>'.PHP_EOL.
		PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'%s'.PHP_EOL,

	# Types
	'type_none' => 'Scegli formato',
	'type_text' => 'Testo semplice',
	'type_html' => 'HTML semplice',
		
	# Sign
	'sign_title' => 'Iscriviti alla Newsletter',
	'sign_info_login' => 'Non è attualmente connesso, per cui non possiamo verificare se è già iscritto alla Newsletter.',
	'sign_info_none' => 'Non è ancora iscritto alla Newsletter.',
	'sign_info_html' => 'Si è già iscritto alla Newsletter in formato \'Testo semplice\'.',
	'sign_info_text' => 'Si è già iscritto alla Newsletter in formato \'HTML semplice\'.',
	'ft_sign' => 'Iscrivi alla Newsletter',
	'btn_sign' => 'Iscrivi alla Newsletter',
	'btn_unsign' => 'Rimuovi dalla Newsletter',
		
	# Edit
	'ft_edit' => 'Modifica novità (in %s)',
	'btn_edit' => 'Modifica',
	'btn_translate' => 'Traduci',
	'th_transid' => 'Traduzione',
	'th_mail_me' => 'Invia questa come Newsletter',
	'th_hidden' => 'Nascosto?',

	# Add
	'ft_add' => 'Aggiungi novità',
	'btn_add' => 'Aggiungi novità',
	'btn_preview' => 'Anteprima (!)',
		
	# Admin Config
	'cfg_newsletter_guests' => 'Permetti iscrizione alla Newsletter ad utenti non registrati',
	'cfg_news_per_adminpage' => 'Novità Pagina Admin',
	'cfg_news_per_box' => 'Novità per inline-box',
	'cfg_news_per_page' => 'Novità per Pagina Novità',
	'cfg_newsletter_mail' => 'Mittente E-Mail Newsletter',
	'cfg_newsletter_sleep' => 'Attenti N ms dopo invio E-Mail',
	'cfg_news_per_feed' => 'Novità per Pagina Feed',
	
	# RSS2 Feed
	'rss_title' => 'News Feed di'.GWF_SITENAME,
		
	# V2.03 (News + Forum)
	'cfg_news_in_forum' => 'Pubblica novità nel forum',
	'board_lang_descr' => 'Novità in %s',
	'btn_admin_section' => 'Sezione Admin',
	'th_hidden' => 'Nascosto',
	'th_visible' => 'Visibile',
	'btn_forum' => 'Discuti nel forum',
		
	# V3.00 (fixes)
	'rss_img_title' => 'Logo di '.GWF_SITENAME,
	'cfg_news_comments' => 'Permetti commenti',
		
	# monnino fixes
	'btn_news' => 'Novità',
	'btn_build_forum' => 'Crea Sezione Novità',
);

?>
