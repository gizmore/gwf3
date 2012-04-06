<?php
 
$lang = array(

	# Errors
	'err_board' => 'Dieses Board existiert nicht, oder Ihnen fehlt die Berechtigung.',
	'err_thread' => 'Dieses Thema existiert nicht, oder Ihnen fehlt die Berechtigung.',
	'err_post' => 'Diese Nachricht ist unbekannt.',
	'err_parentid' => 'Das übergeordnete Board ist unbekannt.',
	'err_groupid' => 'Diese Gruppe ist unbekannt.',
	'err_board_perm' => 'Sie dürfen auf dieses Board nicht zugreifen.',
	'err_thread_perm' => 'Sie dürfen auf dieses Thema nicht zugreifen.',
	'err_post_perm' => 'Sie dürfen diese Nachricht nicht lesen.',
	'err_reply_perm' => 'Sie dürfen auf dieses Thema nicht antworten. <a href="%s">Klicken Sie hier um zum Thema zurück zu gelangen</a>.',
	'err_no_thread_allowed' => 'In diesem Board sind keine Themen erlaubt.',
	'err_no_guest_post' => 'Gäste dürfen in diesem Board nicht schreiben.',
	'err_msg_long' => 'Ihre Nachricht ist zu lang. Maximal erlaubt sind %s Zeichen.',
	'err_msg_short' => 'Sie haben die Nachricht vergessen.',
	'err_descr_long' => 'Ihre Beschreibung ist zu lang. Maximal erlaubt sind %s Zeichen.',
	'err_descr_short' => 'Sie haben die Beschreibung vergessen.',
	'err_title_long' => 'Der Titel ist zu lang. Maximal erlaubt sind %s Zeichen.',
	'err_title_short' => 'Sie haben den Titel vergessen.',
	'err_sig_long' => 'Ihre Signatur ist zu lang. Maximal erlaubt sind %s Zeichen.',
	'err_subscr_mode' => 'Unbekannter Forum Abonnement Modus.',
	'err_no_valid_mail' => 'Sie haben keine bestätigte EMail um das Forum zu abonnieren.',
	'err_token' => 'Das Token ist ungültig.',
	'err_in_mod' => 'Dieses Thema befindet sich noch in der Moderation.',
	'err_board_locked' => 'Dieses Board ist vorübergehend geschlossen.',

	'err_no_subscr' => 'Sie können dieses Thema nicht extra abonnieren. <a href="%s">Klicken Sie hier um zum Thema zurück zu gelangen</a>.',
	'err_subscr' => 'Ein Fehler ist aufgetreten. <a href="%s">Klicken Sie hier um zum Thema zurück zu gelangen</a>.',
	'err_no_unsubscr' => 'Sie können das Abonnement zu diesem Thema nicht abstellen. <a href="%s">Klicken Sie hier um zum Thema zurückzukehren</a>.',
	'err_unsubscr' => 'Ein Fehler ist aufgetreten. <a href="%s">Klicken Sie hier um zum Thema zurückzukehren</a>.',
	'err_sub_by_global' => 'Sie haben dieses Thema nicht extra abonniert, sondern durch ihre globalen Einstellungen.<br/>Benutzen Sie die <a href="/forum/options">Forum Einstellungen</a> um ihre Optionen zu ändern.',
	'err_thank_twice' => 'Sie haben sich bereits für diese Nachricht bedankt.',
	'err_thanks_off' => 'Es ist zur Zeit nicht möglich sich für Nachrichten zu bedanken.',
	'err_votes_off' => 'Das Bewerten von Nachrichten ist zur Zeit deaktiviert.',
	'err_better_edit' => 'Bitte editieren Sie ihre letzte Nachricht. Es ist nicht möglich zwei mal hintereinander eine Nachricht zu senden. Sie können &quot;Als Ungelesen markieren&quot;, falls Sie gravierende Änderungen an ihrer Nachricht vornehmen möchten.<br/><a href="%s">Klicken Sie hier um zum Thema zurückzukehren</a>.',

	# Messages
	'msg_posted' => 'Ihre Nachricht wurde gesendet.<br/><a href="%s">Klicken Sie hier um ihre Nachricht anzuzeigen</a>.',
	'msg_posted_mod' => 'Ihre Nachricht wurde gesendet. Sie muss allerdings von einem Moderator vor dem Anzeigen geprüft werden.<br/><a href="%s">Klicken Sie hier um zum Board zurück zu gelangen</a>.',
	'msg_post_edited' => 'Ihre Nachricht wurde bearbeitet.<br/><a href="%s">Klicken Sie hier um ihre Nachricht anzuzeigen</a>.',
	'msg_edited_board' => 'Das Board wurde editiert.<br/><a href="%s">Klicken Sie hier um zum Board zurückzukehren</a>.',
	'msg_board_added' => 'Ein neues Board wurde hinzugefügt. <a href="%s">Klicken Sie hier um zum Forum zurückzukehren</a>.',
	'msg_edited_thread' => 'Das Thema wurde erfolgreich editiert.',
	'msg_options_changed' => 'Ihre Optionen wurden geändert.',
	'msg_thread_shown' => 'Das Thema wurde geprüft und wird ab sofort angezeigt.',
	'msg_post_shown' => 'Die Nachricht wurde geprüft und wird ab sofort angezeigt.',
	'msg_thread_deleted' => 'Das Thema wurde gelöscht.',
	'msg_post_deleted' => 'Die Nachricht wurde gelöscht.',
	'msg_board_deleted' => 'Das gesamte Board wurde gelöscht!',
	'msg_subscribed' => 'Sie haben dieses Thema abonniert und erhalten nun EMails bei einer neuen Nachricht.<br/><a href="%s">Klicken Sie hier um zum Thema zurückzukehren</a>.',
	'msg_unsubscribed' => 'Sie haben das Abonnement zu diesem Thema gekündigt und werden keine EMails mehr zu diesem Thema erhalten.<br/><a href="%s">Klicken Sie hier um zum Thema zurückzukehren</a>.',
	'msg_unsub_all' => 'Sie haben alle Abonnements gekündigt.',
	'msg_thanked_ajax' => 'Ihr Danke-Schön wurde in der Datenbank vermerkt.',
	'msg_thanked' => 'Ihr Danke-Schön wurde in der Datenbank vermerkt.<br/><a href="%s">Klicken Sie hier um zur Nachricht zurückzukehren</a>.',
	'msg_thread_moved' => 'Das Thema %s wurde nach %s verschoben.',
	'msg_voted' => 'Vielen Dank für ihre Stimme.',
	'msg_marked_read' => 'Es wurden %s Themen als gelesen markiert.',

	# Titles
	'forum_title' => GWF_SITENAME.' Forum',
	'ft_add_board' => 'Neues Board',
	'ft_add_thread' => 'Neues Thema Hinzufügen',
	'ft_edit_board' => 'Board Editieren',
	'ft_edit_thread' => 'Thema Editieren',
	'ft_options' => 'Forum Optionen Einstellen',
	'pt_thread' => '%2$s  ['.GWF_SITENAME.']->%1$s',
	'ft_reply' => 'Auf das Thema antworten',
	'pt_board' => '%s ',
//	'pt_board' => '%s ['.GWF_SITENAME.']',
	'ft_search_quick' => 'Schnellsuche',
	'ft_edit_post' => 'Ihre Nachricht Bearbeiten',
	'at_mailto' => 'Eine EMail an %s senden',
	'last_edit_by' => 'Zuletzt geändert von %s - %s',

	# Page Info
	'pi_unread' => 'Ungelesene Themen',

	# Table Headers
	'th_board' => 'Forum',
	'th_threadcount' => 'Themen',
	'th_postcount' => 'Nachrichten',
	'th_title' => 'Titel',
	'th_message' => 'Nachricht',
	'th_descr' => 'Beschreibung',	
	'th_thread_allowed' => 'Themen erlaubt',	
	'th_locked' => 'Geschlossen',
	'th_smileys' => 'Smileys Deaktivieren',
	'th_bbcode' => 'BBCode Deaktivieren',
	'th_groupid' => 'Auf eine Gruppe beschränken',
	'th_board_title' => 'Board Titel',
	'th_board_descr' => 'Board Beschreibung',
	'th_subscr' => 'EMail Abonnements',
	'th_sig' => 'Ihre Forensignatur',
	'th_guests' => 'Gäste-Nachrichten erlauben',
	'th_google' => 'Google/Übersetzer nicht einbinden',
	'th_firstposter' => 'Ersteller',
	'th_lastposter' => 'Antwort von',
	'th_firstdate' => 'Erste Nachricht',
	'th_lastdate' => 'Letzte Nachricht',
	'th_post_date' => 'Nachricht vom',
	'th_user_name' => 'Benutzer',
	'th_user_regdate' => 'Registriert ',
//	'th_unread_again' => '',
	'th_sticky' => 'Wichtig',
	'th_closed' => 'Geschlossen',
	'th_merge' => 'Themen zusammenführen',
	'th_move_board' => 'Board verschieben',
	'th_thread_thanks' => 'Dank',
	'th_thread_votes_up' => '+Votes',
	'th_thanks' => 'Danke',
	'th_votes_up' => '+Votes',

	# Buttons
	'btn_add_board' => 'Neues Board erstellen',
	'btn_rem_board' => 'Board löschen',
	'btn_edit_board' => 'Dieses Board editieren',
	'btn_add_thread' => 'Neues Thema',
	'btn_preview' => 'Vorschau',
	'btn_options' => 'Forum Einstellungen',
	'btn_change' => 'Ändern',
	'btn_quote' => 'Zitieren',
	'btn_reply' => 'Antworten',
	'btn_edit' => 'Editieren',
	'btn_subscribe' => 'Abonnieren',
	'btn_unsubscribe' => 'Abbestellen',
	'btn_search' => 'Suchen',
	'btn_vote_up' => 'Gute Nachricht!',
	'btn_vote_down' => 'Schlechte Nachricht!',
	'btn_thanks' => 'Danke Schön!',
	'btn_translate' => 'Google/Übersetzer',

	# Selects
	'sel_group' => 'Wählen Sie eine Benutzergruppe',
	'subscr_none' => 'Nichts',
	'subscr_own' => 'Themen mit eigenen Beiträgen',
	'subscr_all' => 'Alle Themen',

	# Config
	'cfg_guest_posts' => 'Gast Nachrichten erlauben',	
	'cfg_max_descr_len' => 'Maximale Länge für Beschreibungen',	
	'cfg_max_message_len' => 'Maximale Länge für Nachrichten',
	'cfg_max_sig_len' => 'Maximale Länge für Signaturen',
	'cfg_max_title_len' => 'Maximale Länge für Titel',
	'cfg_mod_guest_time' => 'Automatische Moderations Zeit',
	'cfg_num_latest_threads' => 'Anzahl der neusten Themen',
	'cfg_num_latest_threads_pp' => 'Anzahl Themen pro Vergangenheits-Seite',
	'cfg_posts_per_thread' => 'Anzahl Nachrichten pro Themenseite',
	'cfg_search' => 'Suche erlaubt?',
	'cfg_threads_per_page' => 'Anzahl Themen pro Boardseite',
	'cfg_last_posts_reply' => 'Anzahl alter Nachrichten beim Antworten',
	'cfg_mod_sender' => 'EMail Sender für Moderation',
	'cfg_mod_receiver' => 'Mail Empfänger für Moderation',
	'cfg_unread' => 'Ungelesene Themen aktiviert?',
	'cfg_gtranslate' => 'Google/Übersetzer aktiviert?',	
	'cfg_thanks' => 'Danke-Schön aktiviert?',
	'cfg_uploads' => 'Uploads aktiviert?',
	'cfg_votes' => 'Voting aktiviert?',
	'cfg_mail_microsleep' => 'Pause zwischen den E-Mails (in ms)',	
	'cfg_subscr_sender' => 'EMail Sender für Abonnierte Themen',

	# show_thread.php
	'posts' => 'Nachrichten',
	'online' => 'Der Benutzer ist Online',
	'offline' => 'Der Benutzer ist Offline',
	'registered' => 'Registriert am',
	'watchers' => '%s Personen sehen sich diese Thema gerade an.',
	'views' => 'Dieses Thema wurde %s mal angesehen.',

	# forum.php
	'latest_threads' => 'Die neuesten Themen',

	# Moderation EMail
	'modmail_subj' => GWF_SITENAME.': Nachricht Moderieren',
	'modmail_body' =>
		'Liebe Moderatoren'.PHP_EOL.
		PHP_EOL.
		'Es gibt eine neue Nachricht im '.GWF_SITENAME.' Forum das Moderation benötigt.'.PHP_EOL.
		PHP_EOL.
		'Board: %s'.PHP_EOL.
		'Thema: %s'.PHP_EOL.
		'Von: %s'.PHP_EOL.
		PHP_EOL.
		'%s'.PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		PHP_EOL.
		'Um die Nachricht zu löschen rufen Sie diese Seite auf:'.PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'Um die Nachricht anzuzeigen rufen Sie diese Seite auf:'.PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		PHP_EOL.
		'Die Nachricht wird automatisch nach %s angezeigt.'.PHP_EOL.
		PHP_EOL.
		'Viele Grüße'.PHP_EOL.
		'Das '.GWF_SITENAME.' Team'.PHP_EOL,

	# New Post EMail
	'submail_subj' => GWF_SITENAME.': Neuer Forum-Post',
	'submail_body' => 
		'Hallo %s'.PHP_EOL.
		PHP_EOL.
		'Es gibt %s neue Nachricht(en) im '.GWF_SITENAME.' Forum'.PHP_EOL.
		PHP_EOL.
		'Board: %s'.PHP_EOL.
		'Thema: %s'.PHP_EOL.
		PHP_EOL.
		'<hr/>'.PHP_EOL.
		PHP_EOL.
		'%s'.PHP_EOL. # Multiple msgs possible
		PHP_EOL.
		PHP_EOL.
		'Um den Thread anzusehen rufen sie diese Seite auf:'.PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'Um das Abonnement zu diesem Thema zu kündigen rufen Sie diese Seite auf:'.PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'Um alle Abonnements zu kündigen, können Sie diese Seite aufrufen:'.PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'Hochachtungsvoll,'.PHP_EOL.
		'Das '.GWF_SITENAME.' Team'.PHP_EOL,
		
	'submail_body_part' =>  # that`s the %s above
		'Von: %s'.PHP_EOL.
		'Titel: %s'.PHP_EOL.
		'Nachricht:'.PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'<hr/>'.PHP_EOL.
		PHP_EOL,
		
	# v2.01 (last seen)
	'last_seen' => 'Zuletzt gesehen am: %s',

	# v2.02 (Mark all read)
	'btn_mark_read' => 'Alle als gelesen markieren',
	'msg_mark_aread' => '%s Thema/Themen wurden als gelesen markiert.',

	# v2.03 (Merge)
	'msg_merged' => 'Die Themen wurden zusammengeführt.',
	'th_viewcount' => 'Aufrufe',

	# v2.04 (Polls)
	'ft_add_poll' => 'Fügen Sie eine Ihrer Umfragen hinzu',
	'btn_assign' => 'Zuweisen',
	'btn_polls' => 'Umfragen',
	'btn_add_poll' => 'Umfrage hinzufügen',
	'msg_poll_assigned' => 'Ihre Umfrage wurde hinzugefügt.',
	'err_poll' => 'Diese Umfrage ist unbekannt.',
	'th_thread_pollid' => 'Ihre Umfrage',
	'pi_poll_add' => 'Hier können Sie Ihrem Thema eine Umfrage zuweisen, oder eine neue Umfrage erstellen.<br/>Nachdem Sie eine Umfrage erstellt haben, können Sie diese hier zuweisen.',
	'sel_poll' => 'Wählen Sie eine Umfrage',
		
	# v2.05 (refinish)
	'th_hidden' => 'Versteckt?',
	'th_thread_viewcount' => 'Aufrufe',
	'th_unread_again' => 'Als neu markieren?',
	'cfg_doublepost' => 'Doppel-Posts erlauben?',
	'cfg_watch_timeout' => 'Thema als &quot;am lesen&quot; markieren für N Sekunden',
	'th_guest_view' => 'Für Gäste sichtbar?',
	'pt_history' => 'Ältere Themen im Forum - Seite %s / %s',
	'btn_unread' => 'Neue Themen',
		
	# v2.06 (Admin Area)
	'th_approve' => 'Anzeigen',
	'th_delete' => 'Löschen',
		
	# v2.07 rerefinish
	'btn_pm' => 'PN',
	'permalink' => 'Link',
		
	# v2.08 (attachment)
	'cfg_postcount' => 'Nachrichten Zähler',
	'msg_attach_added' => 'Ihr Anhang wurde hochgeladen. <a href="%s">Klicken Sie hier um zu Ihrer Nachricht zurückzugelangen.</a>',
	'msg_attach_deleted' => 'Ihr Anhang wurde gelöscht. <a href="%s">Klicken Sie hier um zu Ihrer Nachricht zurückzugelangen.</a>',
	'msg_attach_edited' => 'Ihr Anhang wurde bearbeitet. <a href="%s">Klicken Sie hier um zu Ihrer Nachricht zurückzugelangen.</a>',
	'msg_reupload' => 'Ihr Anhang wurde ausgetauscht.',
	'btn_add_attach' => 'Anhang hinzufügen',
	'btn_del_attach' => 'Anhang löschen',
	'btn_edit_attach' => 'Anhang bearbeiten',
	'ft_add_attach' => 'Einen Anhang hinzufügen',
	'ft_edit_attach' => 'Ihren Anhang bearbeiten',
	'th_attach_file' => 'Datei',
	'th_guest_down' => 'Können Gäste den Anhang herunterladen?',
	'err_attach' => 'Unbekannter Anhang.',
	'th_file_name' => 'Dateiname',
	'th_file_size' => 'Größe',
	'th_downloads' => 'Downloads',

	# v2.09 Lang Boards
	'cfg_lang_boards' => 'Sprach-Boards erzeugen',
	'lang_board_title' => '%s Forum',
	'lang_board_descr' => 'Für %s Sprache',
	'lang_root_title' => 'Andere Sprachen',
	'lang_root_descr' => 'Nicht englische Boards',
	'md_board' => GWF_SITENAME.' Forum. %s',
	'mt_board' => GWF_SITENAME.', Forum, Gäste Nachrichten, Alternative, Forum, Software',
		
	# v2.10 subscribers
	'subscribers' => '%s haben dieses Thema abonniert und erhalten EMails bei einer neuen Nachricht.',
	'th_hide_subscr' => 'Abonnements verstecken?',
		
	# v2.11 fixes11
	'txt_lastpost' => 'Den letzten Beitrag anzeigen',
	'err_thank_self' => 'Sie können sich für eigene Beiträge nicht bedanken.',
	'err_vote_self' => 'Sie können Ihre eigenen Beiträge nicht bewerten.',
	
	# v3.00 fixes 12
	'info_hidden_attach_guest' => 'You need to login to see an attachment.',
	'msg_cleanup' => 'I have deleted %s threads and %s posts that have been in moderation.',
		
	# v1.05 (subscriptions)
	'submode' => 'Your global subscription mode is set to: &quot;%s&quot;.',
	'submode_all' => 'The whole board',
	'submode_own' => 'Where you posted',
	'submode_none' => 'Manually',
	'subscr_boards' => 'Your have manually subscribed to %s boards.',
	'subscr_threads' => 'You have manually subscribed to %s threads.',
	'btn_subscriptions' => 'Manage Subscriptions',
	'msg_subscrboard' => 'You have manually subscribed to this board and receive email on new posts.<br/>Click <a href="%s">here to return to the board</a>.',
	'msg_unsubscrboard' => 'You have unsubscribed from this board and do not receive emails for it anymore.<br/>Click <a href="%s">here to return to your subscription overview</a>.',
	
	# v1.06 (Post limits)
	'err_post_timeout' => 'You have just recently posted. Please wait %s.',
	'err_post_level' => 'You need a minimum userlevel of %s to post.',
	'cfg_post_timeout' => 'Minimum time between two posts',
	'cfg_post_min_level' => 'Minimum level to post',
);

?>