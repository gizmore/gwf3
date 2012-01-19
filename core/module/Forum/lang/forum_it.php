<?php

$lang = array(

		# Errors
		'err_board' => 'La sezione è sconosciuta o non si dispone dei permessi necessari per visualizzarla.',
		'err_thread' => 'Il thread è sconosciuto o non si dispone dei permessi necessari per visualizzarlo.',
		'err_post' => 'Il post è sconosciuto.',
		'err_parentid' => 'La sezione correlata è sconosciuta.',
		'err_groupid' => 'Il gruppo è sconosciuto.',
		'err_board_perm' => 'Non è autorizzato ad accedere a questa sezione.',
		'err_thread_perm' => 'Non è autorizzato ad accedere a questa thread.',
		'err_post_perm' => 'Non è autorizzato ad visualizzare questo post.',
		'err_reply_perm' => 'Non è autorizzato a replicare a questo thread. <a href="%s">Cilcchi qui per tornare al thread</a>.',
		'err_no_thread_allowed' => 'In questa sezione non ci sono thread in cui possa postare.',
		'err_no_guest_post' => 'Gli ospiti non sono autorizzati a postare in questo forum. Per farlo deve prima registrarsi.',
		'err_msg_long' => 'Il messaggio è troppo lungo. Sono ammessi, al massimo, %s caratteri.',
		'err_msg_short' => 'Ha dimenticato di inserire il messaggio.',
		'err_descr_long' => 'La descrizione è troppo lunga. Sono ammessi, al massimo, %s caratteri.',
		'err_descr_short' => 'ha dimenticato di inserire la descrizione.',
		'err_title_long' => 'Il titolo è troppo lungo. Sono ammessi, al massimo, %s caratteri.',
		'err_title_short' => 'Ha dimenticato il titolo.',
		'err_sig_long' => 'La firma è troppo lunga. Sono ammessi, al massimo, %s caratteri.',
		'err_subscr_mode' => 'Modalità di sottoscrizione sconosciuta.',
		'err_no_valid_mail' => 'E\' necessaria un\'E-Mail approvata per sottoscriversi a questo forum.',
		'err_token' => 'Il token è invalido.',
		'err_in_mod' => 'Questo thread è al momento sotto moderazione.',
		'err_board_locked' => 'Questa sezione è temporaneamente bloccata.',
		'err_no_subscr' => 'Non può sottoscriversi manualmente a questo thread. <a href="%s">Clicchi qui per tornare al thread</a>.',
		'err_subscr' => 'Si è verificato un errore. <a href="%s">Clicchi qui per tornare al thread</a>.',
		'err_no_unsubscr' => 'Non può rimuovere la sottoscrizione a questo thread. <a href="%s">Clicchi qui per tornare al thread</a>.',
		'err_unsubscr' => 'Si è verificato un errore. <a href="%s">Clicchi qui per tornare al thread</a>.',
		'err_sub_by_global' => 'Non si è iscritto al thread manualmente, ma tramite le opzioni globali del forum.<br/><a href="/forum/options">Usa le ForumOptions</a> per modificare le tue preferenze.',
		'err_thank_twice' => 'Ha già ringrazionato per questo post.',
		'err_thanks_off' => 'Non è attualmente possibile ringraziare gli utenti per i post.',
		'err_votes_off' => 'La votazione per i post è attualmente disabilitata.',
		'err_better_edit' => 'In caso di errore, la preghiamo di modificare il post errato e di evitare di crearne un altro. Tramite &quot;Mark-Unread&quot; può nuovamente impostare il post come non letto.<br/><a href="%s">Clicchi qui per tornare al thread</a>.',

		# Messages
		'msg_posted' => 'Il messaggio è stato pubblicato.<br/><a href="%s">Clicchi qui per vedere il messaggio</a>.',
		'msg_posted_mod' => 'Il messaggio è stato pubblicato, ma sarà controllato prima di essere visualizzato.<br/><a href="%s">Clicchi qui per tornare alla sezione</a>.',
		'msg_post_edited' => 'Il post è stato modificato.<br/><a href="%s">Clicchi qui per tornare al post</a>.',
		'msg_edited_board' => 'La sezione è stata modificata.<br/><a href="%s">Clicchi qui per tornare alla sezione</a>.',
		'msg_board_added' => 'La nuova sezione è stata aggiunta con successo. <a href="%s">Clicchi qui per andare alla sezione</a>.',
		'msg_edited_thread' => 'Il thread è stato modificato con successo.',
		'msg_options_changed' => 'Le tue opzioni sono state modificate.',
		'msg_thread_shown' => 'Il thread è stato approvato e verrà visualizzato.',
		'msg_post_shown' => 'Il post è stato approvato e verrà visualizzato.',
		'msg_thread_deleted' => 'Il thread è stato cancellato.',
		'msg_post_deleted' => 'Il post è stato cancellato.',
		'msg_board_deleted' => 'L\'intera sezione è stata cancellata!',
		'msg_subscribed' => 'Ha sottoscritto il thread e riceverà notifiche tramite E-Mail ad ogni nuovo post.<br/><a href="%s">Clicchi qui per tornare al thread</a>.',
		'msg_unsubscribed' => 'Ha cancellato la sottoscrizione al thread e non riceverà più E-Mail.<br/><a href="%s">licca qui per tornare al thread</a>.',
		'msg_unsub_all' => 'Ha cancellato tutte le sottoscrizioni del suo account.',
		'msg_thanked_ajax' => 'I suoi ringraziamenti sono stati salvati.',
		'msg_thanked' => 'I suoi ringraziamenti sono stati salvati.<br/><a href="%s">Clicchi qui per tornare al post</a>.',
		'msg_thread_moved' => 'Il thread %s è stato spostato in %s.',
		'msg_voted' => 'Grazie per il suo voto.',
		'msg_marked_read' => '%s threads sono stati impostati come già letti.',

		# Titles
		'forum_title' => 'Forums di '.GWF_SITENAME,
		'ft_add_board' => 'Aggiungi sezione',
		'ft_add_thread' => 'Crea thread',
		'ft_edit_board' => 'Aggiungi sezione preesistente',
		'ft_edit_thread' => 'Modifica thread',
		'ft_options' => 'Impostazioni del forum',
		'pt_thread' => '%2$s ['.GWF_SITENAME.']->%1$s',
		'ft_reply' => 'Replica al thread',
		'pt_board' => '%s',
		//	'pt_board' => '%s ['.GWF_SITENAME.']',
		'ft_search_quick' => 'Ricerca rapida',
		'ft_edit_post' => 'Modifica il post',
		'at_mailto' => 'Invia E-Mail a %s',
		'last_edit_by' => 'Ultima modifica: %s - %s',

		# Page Info
		'pi_unread' => 'Thread non letti',

		# Table Headers
		'th_board' => 'Sezioni',
		'th_threadcount' => 'Threads',
		'th_postcount' => 'Posts',
		'th_title' => 'Titolo',
		'th_message' => 'Messaggio',
		'th_descr' => 'Descrizione',
		'th_thread_allowed' => 'Thread consentiti',
		'th_locked' => 'Bloccato',
		'th_smileys' => 'Disabilita Smilies',
		'th_bbcode' => 'Disabilita BBCode',
		'th_groupid' => 'Limita al gruppo',
		'th_board_title' => 'Titolo della sezione',
		'th_board_descr' => 'Descrizione della sezione',
		'th_subscr' => 'Sottoscrizione E-Mail',
		'th_sig' => 'Firma da visualizzare',
		'th_guests' => 'Autorizza post da utenti non registrati (Guest)',
		'th_google' => 'Non includere Google/Translate Javascript',
		'th_firstposter' => 'Creatore',
		'th_lastposter' => 'Ultima replica',
		'th_firstdate' => 'Primo post',
		'th_lastdate' => 'Ultimo post',
		'th_post_date' => 'Data del post',
		'th_user_name' => 'Nome utente',
		'th_user_regdate' => 'Registrato',
		//	'th_unread_again' => '',
		'th_sticky' => 'Sticky',
		'th_closed' => 'Chiuso',
		'th_merge' => 'Unisci threads',
		'th_move_board' => 'Muovi sezione',
		'th_thread_thanks' => 'Grazie',
		'th_thread_votes_up' => 'Voti+',
		'th_thanks' => 'Ringraziamenti',
		'th_votes_up' => 'Voti+',

		# Buttons
		'btn_add_board' => 'Crea nuova sezione',
		'btn_rem_board' => 'Cancella sezione',
		'btn_edit_board' => 'Modifica sezione corrente',
		'btn_add_thread' => 'Crea thread',
		'btn_preview' => 'Anteprima',
		'btn_options' => 'Modifica le opzioni del forum',
		'btn_change' => 'Cambia',
		'btn_quote' => 'Cita',
		'btn_reply' => 'Replica',
		'btn_edit' => 'Modifica',
		'btn_subscribe' => 'Sottoscrivi',
		'btn_unsubscribe' => 'Rimuovi sottoscrizione',
		'btn_search' => 'Ricerca',
		'btn_vote_up' => 'Bel post!',
		'btn_vote_down' => 'Brutto post!',
		'btn_thanks' => 'Grazie!',
		'btn_translate' => 'Google/traduci',

		# Selects
		'sel_group' => 'Seleziona gruppo utenti',
		'subscr_none' => 'Nessuno',
		'subscr_own' => 'Dove ho postato',
		'subscr_all' => 'Tutti i thread',

		# Config
		'cfg_guest_posts' => 'Permetti post da account non registrati (Guest)',
		'cfg_max_descr_len' => 'Lunghezza massima della descrizione',
		'cfg_max_message_len' => 'Lunghezza massima del messaggio',
		'cfg_max_sig_len' => 'Lunghezza massima della firma',
		'cfg_max_title_len' => 'Lunghezza massima del titolo',
		'cfg_mod_guest_time' => 'Tempo per auto moderazione',
		'cfg_num_latest_threads' => 'Numero di thread recenti',
		'cfg_num_latest_threads_pp' => 'Thread per pagina della cronologia',
		'cfg_posts_per_thread' => 'Numero di post per thread',
		'cfg_search' => 'Ricerca permessa',
		'cfg_threads_per_page' => 'Thread per sezione',
		'cfg_last_posts_reply' => 'Numero di post mostrati alla replica',
		'cfg_mod_sender' => 'Mittente di E-Mail di moderazione',
		'cfg_mod_receiver' => 'Ricevente di E-Mail di moderazione',
		'cfg_unread' => 'Attiva thread non letti',
		'cfg_gtranslate' => 'Attiva Google Translate',
		'cfg_thanks' => 'Attiva i ringraziamenti',
		'cfg_uploads' => 'Attiva il caricamento files',
		'cfg_votes' => 'Attiva i voti',
		'cfg_mail_microsleep' => 'E-Mail Microsleep :/ .. ???',
		'cfg_subscr_sender' => 'Mittente delle E-Mail di sottoscrizione',

		# show_thread.php
		'posts' => 'Posts',
		'online' => 'L\'utente è Online',
		'offline' => 'L\'utente è Offline',
		'registered' => 'Registrato a',
		'watchers' => '%s persone stanno visualizzando il thread.',
		'views' => 'Questo thread è stato visualizzato %s volte.',

		# forum.php
		'latest_threads' => 'Ultime attività',

		# Moderation EMail
		'modmail_subj' => GWF_SITENAME.': Modera post',
		'modmail_body' =>
		'Cari membri dello Staff'.PHP_EOL.
		PHP_EOL.
		'C\'è un nuovo post o thread sui forum di '.GWF_SITENAME.' che richiede la vostra moderazione.'.PHP_EOL.
		PHP_EOL.
		'Sezione: %s'.PHP_EOL.
		'Thread: %s'.PHP_EOL.
		'Da: %s'.PHP_EOL.
		PHP_EOL.
		'%s'.PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		PHP_EOL.
		'Per cancellare il post, utilizzate questo link:'.PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'Per autorizzare il post, utilizzate questo link:'.PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		PHP_EOL.
		'Il post sarà visualizzato automaticamente in %s'.PHP_EOL.
		PHP_EOL.
		'Cordiali saluti,'.PHP_EOL.
		'Il team di '.GWF_SITENAME.PHP_EOL,

		# New Post EMail
		'submail_subj' => GWF_SITENAME.': Nuovo Post',
		'submail_body' =>
		'Caro %s'.PHP_EOL.
		PHP_EOL.
		'Ci sono %s nuovi Post(s) nel forum di '.GWF_SITENAME.PHP_EOL.
		PHP_EOL.
		'Sezione: %s'.PHP_EOL.
		'Thread: %s'.PHP_EOL.
		PHP_EOL.
		'<hr/>'.PHP_EOL.
		PHP_EOL.
		'%s'.PHP_EOL. # Multiple msgs possible
		PHP_EOL.
		PHP_EOL.
		'Per vedere il thread visita il link seguente:'.PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'Per rimuovere la sottoscrizione da questo thread visita il link seguente:'.PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'Per rimuovere la sottoscrizione da tutti i thread, puoi usare il link seguente:'.PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'Cordiali saluti,'.PHP_EOL.
		'Il team di '.GWF_SITENAME.PHP_EOL,

		'submail_body_part' =>  # that`s the %s above
		'Da: %s'.PHP_EOL.
		'Titolo: %s'.PHP_EOL.
		'Messaggio:'.PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'<hr/>'.PHP_EOL.
		PHP_EOL,

		# v2.01 (last seen)
		'last_seen' => 'Ultima visita: %s',

		# v2.02 (Mark all read)
		'btn_mark_read' => 'Imposta tutti come già letti',
		'msg_mark_aread' => '%s thread sono stati impostati come già letti.',

		# v2.03 (Merge)
		'msg_merged' => 'I thread sono stati uniti.',
		'th_viewcount' => 'Visite',
		#TODO:
		# v2.04 (Polls)
		'ft_add_poll' => 'Assegna un sondaggio ad un thread',
		'btn_assign' => 'Assegna',
		'btn_polls' => 'Sondaggi',
		'btn_add_poll' => 'Aggiungi sondaggio',
		'msg_poll_assigned' => 'Il suo sondaggio è stato assegnato con successo.',
		'err_poll' => 'Sondaggio sconosciuto.',
		'th_thread_pollid' => 'Il suo sondaggio',
		'pi_poll_add' => 'Qui può assegnare un sondaggio ad uno dei suoi thread, oppure può crearne uno nuovo.<br/>Dopo aver creato il thread, dovrà tornare qui per assegnare il sondaggio al nuovo thread.',
		'sel_poll' => 'Seleziona un sondaggio',

		# v2.05 (refinish)
		'th_hidden' => 'E\' nascosto?',
		'th_thread_viewcount' => 'Visite',
		'th_unread_again' => 'Imposta come non letto?',
		'cfg_doublepost' => 'Permetti BUMP / doppi post?',
		'cfg_watch_timeout' => 'Modifica numero di visitatori del thread ogni N secondi',
		'th_guest_view' => 'Visibile ai thread?',
		'pt_history' => 'Storia del forum - Pagina %s / %s',
		'btn_unread' => 'Nuovi thread',

		# v2.06 (Admin Area)
		'th_approve' => 'Approva',
		'th_delete' => 'Cancella',

		# v2.07 rerefinish
		'btn_pm' => 'PM',
		'permalink' => 'Link',

		# v2.08 (attachment)
		'cfg_postcount' => 'Numero di post',
		'msg_attach_added' => 'L\'allegato è stato caricato. <a href="%s">Clicchi qui per tornare al post.</a>',
		'msg_attach_deleted' => 'L\'allegato è stato cancellato. <a href="%s">Clicchi qui per tornare al post.</a>',
		'msg_attach_edited' => 'L\'allegato è stato modificato. <a href="%s">Clicchi qui per tornare al post.</a>',
		'msg_reupload' => 'L\'allegato è stato rimpiazzato.',
		'btn_add_attach' => 'Aggiungi allegato',
		'btn_del_attach' => 'Cancella allegato',
		'btn_edit_attach' => 'Modifica allegato',
		'ft_add_attach' => 'Aggiungi allegato',
		'ft_edit_attach' => 'Modifica allegato',
		'th_attach_file' => 'File',
		'th_guest_down' => 'Scaricabile da utenti non registrati?',
		'err_attach' => 'Allegato sconosciuto.',
		'th_file_name' => 'File',
		'th_file_size' => 'Dimensione',
		'th_downloads' => 'Numero di download',

		# v2.09 Lang Boards
		'cfg_lang_boards' => 'Crea sezioni divise per lingue',
		'lang_board_title' => 'Sezione %s',
		'lang_board_descr' => 'Per la lingua %s',
		'lang_root_title' => 'Lingua straniera',
		'lang_root_descr' => 'Sezioni non in inglese',
		'md_board' => 'Forums di '.GWF_SITENAME.'. %s',
		'mt_board' => GWF_SITENAME.', Forum, Guest Posts, Alternativo, Forum, Software',

		# v2.10 subscribers
		'subscribers' => '%s utenti hanno sottoscritto il thread e ricevo le E-Mail di notifica.',
		'th_hide_subscr' => 'Nascondere le sottoscrizioni agli altri utenti?',

		# v2.11 fixes11
		'txt_lastpost' => 'Vai al tuo ultimo post',
		'err_thank_self' => 'Non è possibile ringraziarsi per un proprio post.',
		'err_vote_self' => 'Non è possibile votare i propri post.',

		# v3.00 fixes 12
		'info_hidden_attach_guest' => 'Deve connettersi per vedere un allegato.',
		'msg_cleanup' => 'Ho cancellato %s thread and %s post che erano in moderazione.',

		# v1.05 (subscriptions)
		'submode' => 'La tua modalità globale di sottoscrizione è: &quot;%s&quot;.',
		'submode_all' => 'L\'intera sezione',
		'submode_own' => 'Dove ha postato',
		'submode_none' => 'Manuale',
		'subscr_boards' => 'Ha sottoscritto manualmente %s sezioni.',
		'subscr_threads' => 'Ha sottoscritto manualmente %s thread.',
		'btn_subscriptions' => 'Gestisci sottoscrizioni',
		'msg_subscrboard' => 'E\' sottoscritto a questa sezione e riceverà E-Mail di notifica.<br/><a href="%s">Clicchi qui per tornare alla sezione</a>.',
		'msg_unsubscrboard' => 'Ha cancellato la sottoscrizione a questa sezione e non riceverà più E-Mail.<br/><a href="%s">Clicchi qui per tornare alla panoramica delle sottoscrizioni</a>.',

		# v1.06 (Post limits)
		'err_post_timeout' => 'Ha già postato recentemente. La preghiamo di aspettare %s.',
		'err_post_level' => 'Per postare, è necessario un livello utente minimo di %s.',
		'cfg_post_timeout' => 'Tempo minimo tra due post',
		'cfg_post_min_level' => 'Livello minimo necessario per postare',
);

?>