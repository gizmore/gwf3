<?php
$lang = array(
	'tag' => '%1$s (%2$s%%) ',
	'now_playing' => 'State ascoltando',
	'previously_played' => 'Canzone precedente',
	'tag_this_song' => 'Tagga a questa canzone',
	'add_lyrics_to_song' => 'Aggiungi il testo della canzone',
	'you_not_tagged' => 'Non hai ancora aggiunto un tag a questa canzone.',
	'you_tagged' => 'Hai già aggiunto un tag a questa canzone, ma puoi cambiarlo.',
	'not_on_rko' => 'Questa canzone non è su RKO.',
	'dl_from_rko' => 'Scarica da remix.kwed.org',
	'show_lyrics' => 'Mostra testo',
	'info_quicksearch' => 'Utilizza la funzione \'Ricerca veloce\' per cercare all\'interno dell\'intero database di slaytag per parole chiave.<br/>La ricerca utilizzerà anche il testo della canzone, che si spera verranno aggiunte.',
	'seconds_left' => 'Secondi rimanenti',
	'pt_lyrics' => '%2$s by %1$s [Testo]',
	'download_from_rko' => 'Scarica da RKO',

	'ft_tag' => 'Slaytagger ',
	'ft_add_tag' => 'Tagga',
	'ft_add_lyrics' => 'Aggiunti tutti i testi delle canzoni!',
	'ft_search' => 'Ricerca veloce',
	'ft_edit_song' => 'Modifica la canzone',

	'th_tag' => 'Nome tag',
	'th_tags' => 'Taggato come',
	'th_date' => 'Data',
	'th_artist' => 'Artista', 
	'th_title' => 'Titolo',
	'th_composer' => 'Compositore SID',
	'th_played' => 'Ascoltata',
	'th_duration' => 'Durata',
	'th_taggers' => 'Taggatori',
	'th_lyrics' => 'Testi',
	'th_rko_download' => 'Scarica su RKO',
	'th_searchtag' => 'Tag di ricerca',
	'th_searchterm' => 'Termini di ricerca',
	'th_enabled' => 'Attivata?',

	'btn_tag' => 'Tagga!',
	'btn_add' => 'Aggiungi',
	'btn_edit' => 'Modifica',
	'btn_add_tag' => 'Aggingi un nuovo tag',
	'btn_add_lyrics' => 'Aggiungi testo della canzone',
	'btn_download' => 'Scarica',
	'btn_search' => 'Cerca',
	'btn_flush_tags' => 'Cancella tutti i tag',

	'err_tag_uk' => 'Il server ha ricevuto un tag invalido.',
	'err_tag' => 'Il tag fornito è invalido. Deve avere un lunghezza compresa tra %1$s e %2$s caratteri.',
	'err_lyrics' => 'Il testo della canzone deve avere una lunghezza compresa tra %1$s e %2$s caratteri.',
	'err_lyrics_unk' => 'Non è stato possibile trovare il testo della canzone.',
	'err_song' => 'Non è stato possibile trovare la canzone.',
	'err_add_tag' => 'Ha già aggiunto un tag. Finchè lo staff non decide di accettarlo non ne può aggiungere un altro.',
	'err_dup_tag' => 'Questo tag esiste già.',
	'err_searchterm' => 'Il termine di ricerca è invalido. Deve avere un lunghezza compresa tra %1$s e %2$s caratteri.',
	'err_searchtag' => 'Il tag fornito è invalido.',
	'err_no_match' => 'La ricerca non ha trovato alcuna corrispondenza all\'interno del database.',
	'err_cross_login' => 'Il token per il cross-login è invalido.',

	'msg_tagged' => 'Grazie per aver taggato questa canzone.',
	'msg_tag_added' => 'Grazie. Un nuovo tag è stato aggiunto al database.<br/><a href="%1$s">Ritorna alla canzone per taggarla!</a>',
	'msg_added_lyrics' => 'Grazie. Un nuovo testo è stato aggiunto!',
	'msg_cross_login' => 'Grazie al suo token di cross-login, è stato effettuato l\'accesso con il nome utente di %1$s.<br/>Questa è un opzione conveniente per velocizzare il processo di tagging.',
	'msg_song_edit' => 'La canzone è stata modificata.',
	'msg_tags_flushed' => 'I tag di questa canzone sono stati rimossi.',

	###################
	### Lyrics Mail ###
	###################
	'mail_subj_lyri' => GWF_SITENAME.': Testo aggiunto',
	'mail_body_lyri' =>
		'Ciao %1$s'.PHP_EOL.
		PHP_EOL.
		'L\'utente %2$s ha appena aggiunti il resto della canzone %3$s - %4$s'.PHP_EOL.
		PHP_EOL.
		'%5$s'.PHP_EOL.
		PHP_EOL.
		'Puoi cancellarlo qui:'.PHP_EOL.
		'%6$s'.PHP_EOL.
		PHP_EOL.
		'Cordiali saluti,'.PHP_EOL.
		'The Slaytagginsite',
);
?>