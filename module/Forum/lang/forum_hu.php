<?php
$lang = array(
	# Errors
	'err_board' => 'Ismeretlen "board".',
	'err_thread' => 'Ismeretlen "thread".',
	'err_post' => 'Ismeretlen poszt.',
	'err_parentid' => 'A szülõ "board" érvénytelen.',
	'err_groupid' => 'Ismeretlen csoport.',
	'err_board_perm' => 'Nem engedélyezett ez a "board" a számodra.',
	'err_thread_perm' => 'Nem engedélyezett ez a "thread" a számodra.',
	'err_post_perm' => 'Nem olvashatod el ezt a posztot.',
	'err_reply_perm' => 'Nincs jogod válaszolni erre a threadre. <a href="%1%">Kattints ide, hogy visszatérj a "threadre"</a>.',
	'err_no_thread_allowed' => 'Nem engedélyezettek a "threadek" ezen a "boardon".',
	'err_no_guest_post' => 'A vendégeknek nincs joguk posztolni erre a fórumra.',
	'err_msg_long' => 'Túl hosszú az üzeneted. Maximum %1% karakter engedélyezett.',
	'err_msg_short' => 'Elfelejtetted az üzenet mezõt kitölteni.',
	'err_descr_long' => 'Túl hosszú a leírásod. Maximum %1% karakter engedélyezett.',
	'err_descr_short' => 'Elfelejtetted a leírás mezõt kitölteni.',
	'err_title_long' => 'Túl hosszú a cím. Maximum %1% karakter engedélyezett.',
	'err_title_short' => 'Elfelejtetted a cím mezõt kitölteni.',
	'err_sig_long' => 'Túl hosszú az aláírásod. Maximum %1% karakter engedélyezett.',
	'err_subscr_mode' => 'Ismeretlen elõfizetési mód.',
	'err_no_valid_mail' => 'Nincs ellenõrzött e-mail címed ahhoz, hogy feliratkozz a fórumra.',
	'err_token' => 'Érvénytelen token.',
	'err_in_mod' => 'Ez a "thread" moderálás alatt van.',
	'err_board_locked' => 'A "board" ideiglenesen zárolva van.',
	'err_no_subscr' => 'Nem lehet manuálisan feliratkozni erre a "threadre". <a href="%1%">Kattints ide, hogy visszatérj a "threadhez"</a>.',
	'err_subscr' => 'Hiba történt. <a href="%1%">Kattints ide, hogy visszatérj a "threadhez</a>.',
	'err_no_unsubscr' => 'Nem tudsz leiratkozni errõl a "threadrõl". <a href="%1%">Kattints ide, hogy visszatérj a "threadhez</a>.',
	'err_unsubscr' => 'Hiba történt. <a href="%1%">Kattints ide, hogy visszatérj a "threadhez</a>.',
	'err_sub_by_global' => 'Nem manuálisan iratkoztál fel a "threadre", hanem a globális beállítás által. <br/><a href="/forum/options">Használd a fórum beállításokat</a>, hogy meg tudd változtatni ezt a beállítást.',
	'err_thank_twice' => 'Már megköszönted ezt a posztot.',
	'err_thanks_off' => 'Jelenleg nem elérhető, hogy megköszönd mások posztjait.',
	'err_votes_off' => 'A poszt szavazás jelenleg nem elérhető.',
	'err_better_edit' => 'Kérlek szerkeszd a posztodat és ne posztolj duplán. Átkapcsolhatod a &quot;Jelöld-olvasatlannak&quot; kapcsolót abban az esetben ha jelentős változtatást végzel.<br/><a href="%1%">Kattints ide hogy visszatérj a thread-hez.</a>.',


	# Messages
	'msg_posted' => 'Az üzeneted el lett küldve.<br/><a href="%1%">Kattints ide, hogy megnézd mit küldtél.</a>.',
	'msg_posted_mod' => 'Az üzeneted el lett küldve, de valaki átnézi mielőtt publikálnánk.<br/><a href="%1%">Kattints ide hogy visszatérj a fórumhoz.</a>.',
	'msg_post_edited' => 'A posztod meg lett változtatva.<br/><a href="%1%">Kattints ide, hogy megnézd mit küldtél</a>.',
	'msg_edited_board' => 'Sikeresen szerkesztetted a fórumot.<br/><a href="%1%">Kattints ide hogy visszatérj a fórumhoz.</a>.',
	'msg_board_added' => 'Az új fórum sikeresen létre lett hozva.<a href="%1%">Kattints ide hogy visszatérj a fórumhoz.</a>.',
	'msg_edited_thread' => 'Sikeresen szerkesztetted a beszélgetést.',
	'msg_options_changed' => 'Megváltoztak a beállításaid.',
	'msg_thread_shown' => 'A beszélgetés engedélyezve lett, így már meg is jelenik.',
	'msg_post_shown' => 'Az üzeneted engedélyezve lett, így már meg is jelenik.',
	'msg_thread_deleted' => 'Beszélgetést törölték.',
	'msg_post_deleted' => 'Az üzenetet törölték.',
	'msg_board_deleted' => 'A teljes fórum törlésre került.',
	'msg_subscribed' => 'Előfizettél a beszélgetésre, így minden új üzenetről e-mailt kapsz.<br/><a href="%1%">Kattints ide hogy visszatérj a beszélgetéshez.</a>.',
	'msg_unsubscribed' => 'Lemondtad az előfizetést erről a beszélgetésről, így a jövőben nem kapsz üzeneteket erről.<br/><a href="%1%">Kattints ide hogy visszatérj a beszélgetéshez.</a>.',
	'msg_unsub_all' => 'Leiratkoztál az összes beszélgetésről, így a jövőben nem kapsz e-maileket ezekről.',
	'msg_thanked_ajax' => 'A köszönetedet rögzítettük.',
	'msg_thanked' => 'A köszönetedet rögzítettük.<br/><a href="%1%">Kattints ide hogy visszatérj az üzenethez</a>.',
	'msg_thread_moved' => 'Ez a beszélgetés (%1%) átköltözött ide:%2%.',
	'msg_voted' => 'Köszönjük, hogy szavaztál.',
	'msg_marked_read' => 'Olvasottként jelölted a %1% beszélgetést.',

	# Titles
	'forum_title' => GWF_SITENAME.' Fórumok',
	'ft_add_board' => 'Új fórum csoport létrehozása',
	'ft_add_thread' => 'Új beszélgetés létrehozása',
	'ft_edit_board' => 'Meglévő fórum csoport szerkesztése',
	'ft_edit_thread' => 'Beszélgetés szerkesztése',
	'ft_options' => 'Fórum beállítások',
	'pt_thread' => '%2% ['.GWF_SITENAME.']->%1%',
	'ft_reply' => 'Válasz a beszélgetésre',
	'pt_board' => '%1%',
//	'pt_board' => '%1% ['.GWF_SITENAME.']',
	'ft_search_quick' => 'Gyors keresés',
	'ft_edit_post' => 'Üzeneted szerkesztése',
	'at_mailto' => 'E-mail küldése ide: %1%',
	'last_edit_by' => 'Utoljára szerkesztette: %1% - %2%',

	# Page Info
	'pi_unread' => 'Olvasatlan beszélgetéseid',

	# Table Headers
	'th_board' => 'Fórum csoport',
	'th_threadcount' => 'Beszélgetés',
	'th_postcount' => 'Üzenetek',
	'th_title' => 'Cím',
	'th_message' => 'Üzenet',
	'th_descr' => 'Leírás',	
	'th_thread_allowed' => 'Beszélgetések engedélyezve',	
	'th_locked' => 'Zárolva',
	'th_smileys' => 'Szmájlik tiltása',
	'th_bbcode' => 'BBcode tiltása',
	'th_groupid' => 'Korlátozás csoportra',
	'th_board_title' => 'Fórum csoport címe',
	'th_board_descr' => 'Fórum csoport leírása',
	'th_subscr' => 'Email feliratkozás',
	'th_sig' => 'Fórum aláírásod',
	'th_guests' => 'Vendég üzenetek engedélyezése',
	'th_google' => 'Ne mutasd a Google Fordítót/Javascriptet',
	'th_firstposter' => 'Létrehozó',
	'th_lastposter' => 'Válasz tőle',
	'th_firstdate' => 'Első üzenet',
	'th_lastdate' => 'Utolsó üzenet',
	'th_post_date' => 'Üzenet dátuma',
	'th_user_name' => 'Felhasználói név',
	'th_user_regdate' => 'Regisztrált',
//	'th_unread_again' => '',
	'th_sticky' => 'Ragadós',
	'th_closed' => 'Lezárt',
	'th_merge' => 'Beszélgetések egyesítése',
	'th_move_board' => 'Fórum csoport áthelyezése',
	'th_thread_thanks' => 'Köszönetek',
	'th_thread_votes_up' => 'Jó szavazatok',
	'th_thanks' => 'Köszi',
	'th_votes_up' => 'Jó szavazat',

	# Buttons
	'btn_add_board' => 'Új fórum csoport létrehozása',
	'btn_rem_board' => 'Fórum csoport törlése',
	'btn_edit_board' => 'Fórum csoport szerkesztése',
	'btn_add_thread' => 'Beszélgetés hozzáadása',
	'btn_preview' => 'Előnézet',
	'btn_options' => 'Fórum beállításaid módosítása',
	'btn_change' => 'Módosít',
	'btn_quote' => 'Idéz',
	'btn_reply' => 'Válaszol',
	'btn_edit' => 'Szerkeszt',
	'btn_subscribe' => 'Előfizet',
	'btn_unsubscribe' => 'Leiratkoz',
	'btn_search' => 'Keresés',
	'btn_vote_up' => 'Értékes üzenet!',
	'btn_vote_down' => 'Gagyi üzenet!',
	'btn_thanks' => 'Köszönjük!',
	'btn_translate' => 'Google/fordító',

	# Selects
	'sel_group' => 'Felhasználói csoport választása',
	'subscr_none' => 'Semmi',
	'subscr_own' => 'Ahová üzenetet küldtem',
	'subscr_all' => 'Összes beszélgetés',

	# Config
	'cfg_guest_posts' => 'Vendég üzenetek engedélyezése',	
	'cfg_max_descr_len' => 'Maximális leírás hosszúság',	
	'cfg_max_message_len' => 'Maximális üzenet hosszúság',
	'cfg_max_sig_len' => 'Maximális aláírás hosszúság',
	'cfg_max_title_len' => 'Maximális cím hosszúság',
	'cfg_mod_guest_time' => 'Automatikus moderálási idő',
	'cfg_num_latest_threads' => 'Utolsó beszélgetések száma',
	'cfg_num_latest_threads_pp' => 'Beszélhetések száma oldalanként',
	'cfg_posts_per_thread' => 'Üzenetek száma beszélgetésenként',
	'cfg_search' => 'Keresés engedélyezve',
	'cfg_threads_per_page' => 'Beszélgetések száma fórum csoportonként',
	'cfg_last_posts_reply' => 'Üzenetek száma küldés után',
	'cfg_mod_sender' => 'Moderáló e-mail küldő',
	'cfg_mod_receiver' => 'Moderáló e-mail fogadó',
	'cfg_unread' => 'Olvasatlan beszélgetések engedélyezése',
	'cfg_gtranslate' => 'Google fordító engedélyezése',	
	'cfg_thanks' => 'Köszönetek engedélyezése',
	'cfg_uploads' => 'Feltöltések engedélyezése',
	'cfg_votes' => 'Szavazás engedélyezése',
	'cfg_mail_microsleep' => 'EMail Microalvás :/ .. ???',	
	'cfg_subscr_sender' => 'EMail előfizetés küldő',

	# show_thread.php
	'posts' => 'Üzenetek',
	'online' => 'A felhasználó online',
	'offline' => 'A felhasználó offline',
	'registered' => 'Itt lett regisztrálva:',
	'watchers' => '%1% darab ember nézegeti jelenleg ezt a beszélgetést.',
	'views' => 'Ezt a beszélgetést %1%-szer jelenítettük meg.',

	# forum.php
	'latest_threads' => 'Utolsó történések',

	# Moderation EMail
	'modmail_subj' => GWF_SITENAME.': Moderáló üzenet',
	'modmail_body' =>
		'Kedves Tag'.PHP_EOL.
		PHP_EOL.
		'Van egy új üzenet vagy beszélgetés, a '.GWF_SITENAME.' oldal fórumában, amit moderálni kellene.'.PHP_EOL.
		PHP_EOL.
		'Fórum csoport: %1%'.PHP_EOL.
		'Beszélgetés: %2%'.PHP_EOL.
		'Küldő: %3%'.PHP_EOL.
		PHP_EOL.
		'%4%'.PHP_EOL.
		'%5%'.PHP_EOL.
		PHP_EOL.
		PHP_EOL.
		'Az üzenet törléséhez kattints ide:'.PHP_EOL.
		'%6%'.PHP_EOL.
		PHP_EOL.
		'Az üzenet engedélyezéséhez kattints ide:'.PHP_EOL.
		'%7%'.PHP_EOL.
		PHP_EOL.
		PHP_EOL.
		'Ezt az üzenetet automatikusan megmutatjuk %8% idő után'.PHP_EOL.
		PHP_EOL.
		'Üdvözlettel'.PHP_EOL.
		'A '.GWF_SITENAME.' csapata'.PHP_EOL,

	# New Post EMail
	'submail_subj' => GWF_SITENAME.': Új üzenet',
	'submail_body' => 
		'Kedves %1%'.PHP_EOL.
		PHP_EOL.
		'%2% darab új üzenet van a '.GWF_SITENAME.' fórumában'.PHP_EOL.
		PHP_EOL.
		'Fórum csoport: %3%'.PHP_EOL.
		'Beszélgetés: %4%'.PHP_EOL.
		PHP_EOL.
		'<hr/>'.PHP_EOL.
		PHP_EOL.
		'%5%'.PHP_EOL. # Multiple msgs possible
		PHP_EOL.
		PHP_EOL.
		'To view the thread please visit this page:'.PHP_EOL.
		'%8%'.PHP_EOL.
		PHP_EOL.
		'Ha le szeretnél iratkozni erről a beszélgetésről, kattints ide:'.PHP_EOL.
		'%6%'.PHP_EOL.
		PHP_EOL.
		'Ha a teljes fórum csoportról szeretnél leiratkozni, kattints ide:'.PHP_EOL.
		'%7%'.PHP_EOL.
		PHP_EOL.
		'Üdvözlettel'.PHP_EOL.
		'A '.GWF_SITENAME.' csapata'.PHP_EOL,
		
	'submail_body_part' =>  # that`s the %5% above
		'Küldő: %1%'.PHP_EOL.
		'Cím: %2%'.PHP_EOL.
		'Üzenet:'.PHP_EOL.
		'%3%'.PHP_EOL.
		PHP_EOL.
		'<hr/>'.PHP_EOL.
		PHP_EOL,
		
	# v2.01
	'last_seen' => 'Utoljára it járt: %1%',

	# v2.02
	'btn_mark_read' => 'Jelöld mind olvasottnak',
	'msg_mark_aread' => 'Jelöld az összes beszélgetést olvasottnak.',
		
	# v2.03 (Merge)
	'msg_merged' => 'A beszélgetések egyesítve lettek.',
	'th_viewcount' => 'Nézetek',
		
	# v2.04 (Polls)
	'ft_add_poll' => 'Szavazásaid hozzárendelése',
	'btn_assign' => 'Hozzárendel',
	'btn_polls' => 'Szavazások',
	'btn_add_poll' => 'Szavazás hozzáadása',
	'msg_poll_assigned' => 'A szavazássod sikeresen hozzá lett rendelve.',
	'err_poll' => 'Ismeretlen szavazás.',
	'th_thread_pollid' => 'A szavazásod',
	'pi_poll_add' => 'Itt tudsz szavazást hozzáadni a beszélhetéshez, vagy új szavazást indítani.<br/>A szavazás elkészítése után itt kell hozzárendelni a szavazást a beszélgetéshez.',
	'sel_poll' => 'Szavazás kiválasztása',
		
	# v2.05 (refinish)
	'th_hidden' => 'Rejtett?',
	'th_thread_viewcount' => 'Nézetek',
	'th_unread_again' => 'Jelöld olvasatlannak?',
	'cfg_doublepost' => 'bumps (???) / dupla küldések engedélyezése?',
	'cfg_watch_timeout' => 'Beszélgetés megjelölése, hogy N másodpercig nézték',
	'th_guest_view' => 'Látható a vendég?',
	'pt_history' => 'Fórum történet - Oldal %1% / %2%',
	'btn_unread' => 'Új beszélgetések',
		
	# v2.06 (Admin Area)
	'th_approve' => 'Jóváhagy',
	'th_delete' => 'Töröl',
		
	# v2.07 rerefinish
	'btn_pm' => 'Azonnali üzenet',
	'permalink' => 'kapcsolás',
		
	# v2.08 (attachment)
	'cfg_postcount' => 'Üzenetek száma',
	'msg_attach_added' => 'A csatolmányod sikeresen fel lett töltve. <a href="%1%">Kattints ide, hogy visszatérj az üzenetedhez.</a>',
	'msg_attach_deleted' => 'A csatolmányod sikeresen törölve lett. <a href="%1%">Kattints ide, hogy visszatérj az üzenetedhez.</a>',
	'msg_attach_edited' => 'A csatolmányod sikeresen szerkesztve lett. <a href="%1%">Kattints ide, hogy visszatérj az üzenetedhez.</a>',
	'msg_reupload' => 'A csatolmányod le lett cserélve.',
	'btn_add_attach' => 'Csatolmány hozzáadása',
	'btn_del_attach' => 'Csatolmány törlése',
	'btn_edit_attach' => 'Csatolmány szerkesztése',
	'ft_add_attach' => 'Csatolmány hozzáadása',
	'ft_edit_attach' => 'Csatolmány szerkesztése',
	'th_attach_file' => 'Fájl',
	'th_guest_down' => 'A vendég is letöltheti?',
	'err_attach' => 'Ismeretlen csatolmány.',
	'th_file_name' => 'Fájl',
	'th_file_size' => 'Méret',
	'th_downloads' => 'Találatok',

	# v2.09 Lang Boards
	'cfg_lang_boards' => 'Nyelvi üzenőfal létrehozása',
	'lang_board_title' => '%1% Üzenőfal',
	'lang_board_descr' => '%1% nyelvű',
	'lang_root_title' => 'Idegen nyelv',
	'lang_root_descr' => 'Nem angol üzenőfalak',
	'md_board' => GWF_SITENAME.' Fórumok. %1%',
	'mt_board' => GWF_SITENAME.', Fórum, Vendég üzenetek, Alternate, Fórum, Szoftver',

	# v2.10 subscribers
	'subscribers' => '%1% feliratkozott erre a beszélgetésre és automatikusan e-mailt kap új üzenet esetén.',
	'th_hide_subscr' => 'Elõfizetések elrejtése?',

	# v2.11 fixes11
	'txt_lastpost' => 'Ugrás az utolsó üzenethez',
	'err_thank_self' => 'Nem köszönheted meg a saját bejegyzésed.',
	'err_vote_self' => 'Nem szavazhatsz a saját bejegyzésedre.',
);
?>
