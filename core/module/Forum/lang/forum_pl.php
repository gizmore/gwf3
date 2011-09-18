<?php # PHmaster + drummachina 
$lang = array(

	# Errors
	'err_board' => 'Wybrałeś błędne forum, bądź nie masz do niego dostępu.',
	'err_post' => 'Wiadomość jest nieznana.',
	'err_thread' => 'Wybrany wątek nie został znaleziony, bądź nie masz do niego dostępu.',
	'err_parentid' => 'Forum jest nieznane.',
	'err_groupid' => 'Grupa jest nieznana.',
	'err_board_perm' => 'Nie masz praw dostępu do tego forum',
	'err_thread_perm' => 'Nie masz praw dostępu do tego tematu.',
	'err_post_perm' => 'Nie masz odpowiednich przywilejów, aby odczytać ta wiadomośś.',
	'err_reply_perm' => 'Nie masz odpowiednich przywilejów, aby odpowiadać w tym temacie. <a href="%1%">Kliknij tutaj aby powrócić do tematu</a>.',
	'err_no_thread_allowed' => 'Na tym forum nie ma żadnych dozwolonych tematów.',
	'err_no_guest_post' => 'Goście nie mogą wysyłać wiadomości na tym forum.',
	'err_msg_long' => 'Twoja wiadomość jest zbyt długa. Wprowadź maksymalnie %1% znaków.',
	'err_msg_short' => 'Wpisz wiadomość!',
	'err_descr_long' => 'Twój opis jest zbyt długi. Wpisz maksymalnie %1% znaków.',
	'err_descr_short' => 'Nie wpisałeś opisu.',
	'err_title_long' => 'Tytuł jest za długi. Wpisz maksymalnie %1% znaków.',
	'err_title_short' => 'Nie wpisałeś tytułu.',
	'err_sig_long' => 'Twój podpis jest za długi. Wpisz maksymalnie %1% znaków.',
	'err_subscr_mode' => 'Tryb subskrypcji nie został odnaleziony.',
	'err_no_valid_mail' => 'Nie potwierdziłeś wiadomości e-mail, która jest wymagana do subskrypcji na tym forum.',
	'err_token' => 'Wprowadzony token jest błędny.',
	'err_in_mod' => 'Wątek jest obecnie moderowany.',
	'err_board_locked' => 'To forum jest obecnie zamknięte.',
	'err_no_subscr' => 'Nie możesz dokonać subskrypcji w tym wątku. <a href="%1%">Kliknij tutaj, aby powrócić do tematu</a>.',
	'err_subscr' => 'Wystąpił błąd. <a href="%1%">Kliknij tutaj, aby powrócić do temutu</a>.',
	'err_no_unsubscr' => 'Nie możesz zrezygnować z subskrypcji. <a href="%1%">Kliknij tutaj, aby powrócić do tematu</a>.',
	'err_unsubscr' => 'Wystąpił błąd. <a href="%1%">Kliknij tutaj, aby powrócić do temutu</a>.',
	'err_sub_by_global' => 'Nie dokonałeś ręcznej subskrypcji.<br/><a href="/forum/options">Użyj ForumOptions</a> żeby zmienić flagi.',
	'err_thank_twice' => 'Już podziękowałeś za tą wiadomość.',
	'err_thanks_off' => 'Obecnie nie jest możliwe dziękowanie za wiadomości.',
	'err_votes_off' => 'Głosowanie na wiadomości jest obecnie wyłączone.',
	'err_better_edit' => 'Nie pisz dwóch wiadomości pod rząd, skorzystaj z edycji. Możesz używać flag &quot;Mark-Unread&quot; to oznaczania istotnych zmian.<br/><a href="%1%">Kliknij tutaj, aby powrócić do wątku</a>.',

	# Messages
	'msg_posted' => 'Twoja wiadomość została wysłana.<br/><a href="%1%">Kliknij tutaj, aby zobaczyć wiadomość</a>.',
	'msg_posted_mod' => 'Twoja wiadomość została wysłana, ale musi poczekać na akceptację.<br/><a href="%1%">Kliknij tutaj, aby powrócić do forum</a>.',
	'msg_post_edited' => 'Dokonałeś edycji wiadomości.<br/><a href="%1%">Kliknij, aby powrócić do wątku</a>.',
	'msg_edited_board' => 'Forum zostało zedytowane.<br/><a href="%1%">Kliknij, aby powrócić na forum</a>.',
	'msg_board_added' => 'Nowe forum zostało pomyślnie dodane. <a href="%1%">Kliknij, aby powrócić</a>.',
	'msg_edited_thread' => 'Operacja edycji wątku została wykonana pomyślnie.',
	'msg_options_changed' => 'Twoje opcje uległy zmianie.',
	'msg_thread_shown' => 'Twój watek został zaakceptowany i pojawił się na forum.',
	'msg_post_shown' => 'Twoja wiadomość została zaakceptowana i pojawiła się na forum.',
	'msg_thread_deleted' => 'Wątek został usunięty.',
	'msg_post_deleted' => 'Wiadomość została usunięta.',
	'msg_board_deleted' => 'Całe forum została usunięte!',
	'msg_subscribed' => 'Dokonałeś subskrypcji tego wątku. Na Twój adres e-mail zostaną wysłane najnowsze wiadomości<br/><a href="%1%">Kliknij, aby powrócic do wątku</a>.',
	'msg_unsubscribed' => 'Zrezygnowałeś z subskrypcji wątku i nie będziesz już otrzymywał e-maili z tego wątku.<br/><a href="%1%">Kliknij, aby powrócić do wątku</a>.',
	'msg_unsub_all' => 'Wypisałeś się ze subskrypcji we wszystkich wątkach.',
	'msg_thanked_ajax' => 'Twoje podziękowania zostały dodane.',
	'msg_thanked' => 'Twoje podziękowania zostały dodane.<br/><a href="%1%">Kliknij tutaj, aby powrócić do wiadomości</a>.',
	'msg_thread_moved' => 'Wątek %1% został przesunięty do %2%.',
	'msg_voted' => 'Dziękujemy za oddanie głosu.',
	'msg_marked_read' => '%1% wątków zostało oznaczonych jako przeczytane.',

	# Titles
	'forum_title' => GWF_SITENAME.' Forum',
	'ft_add_board' => 'Dodaj nowe forum',
	'ft_add_thread' => 'Dodaj nowy wątek',
	'ft_edit_board' => 'Edytuj forum',
	'ft_edit_thread' => 'Edytuj wątek',
	'ft_options' => 'Ustaw opcje forum',
	'pt_thread' => '%2% ['.GWF_SITENAME.']->%1%',
	'ft_reply' => 'Odpowiedz w tym temacie',
	'pt_board' => '%1%',
//	'pt_board' => '%1% ['.GWF_SITENAME.']',
	'ft_search_quick' => 'Szybkie wyszukiwanie',
	'ft_edit_post' => 'Edytuj wiadomość',
	'at_mailto' => 'Wyślij maila do %1%',
	'last_edit_by' => 'Ostatnio edytowany przez %1% - %2%',

	# Page Info
	'pi_unread' => 'Nieprzeczytane tematy',

	# Table Headers
	'th_board' => 'Forum',
	'th_threadcount' => 'Wątki',
	'th_postcount' => 'Wiadomości',
	'th_title' => 'Tutuł',
	'th_message' => 'Wiadomość',
	'th_descr' => 'Opis',	
	'th_thread_allowed' => 'Dozwolone wątki',	
	'th_locked' => 'Zablokowane',
	'th_smileys' => 'Wyłącz emotikony', # uśmieszki means smileys, emoticons is more prcesice
	'th_bbcode' => 'Wyłącz BBCode',
	'th_groupid' => 'Ogranicz dostęp dla grupy',
	'th_board_title' => 'Tytuł forum',
	'th_board_descr' => 'Opis forum',
	'th_subscr' => 'Subskrypcja e-mail',
	'th_sig' => 'Twoja sygnaturka',
	'th_guests' => 'Pozwól gościom wysyłać wiadomości',
	'th_google' => 'Nie dołączaj Google translate',
	'th_firstposter' => 'Twórca',
	'th_lastposter' => 'Odpowiedz z:',
	'th_firstdate' => 'Pierwsza wiadomość',
	'th_lastdate' => 'Ostatnia wiadomość',
	'th_post_date' => 'Data napisania wiadomości',
	'th_user_name' => 'Użytkownik',
	'th_user_regdate' => 'Zarejestrowany',
//	'th_unread_again' => '',
	'th_sticky' => 'Przyklejony',
	'th_closed' => 'Zamknięty',
	'th_merge' => 'Złącz wątki',
	'th_move_board' => 'Przenieś forum',
	'th_thread_thanks' => 'Dziękuję',
	'th_thread_votes_up' => 'Podbij wątek',
	'th_thanks' => 'Dzięki',
	'th_votes_up' => 'Podbij',

	# Buttons
	'btn_add_board' => 'Stwórz nowe forum',
	'btn_rem_board' => 'Usuń forum',
	'btn_edit_board' => 'Edytuj obecne forum',
	'btn_add_thread' => 'Dodaj wątek',
	'btn_preview' => 'Podgląd',
	'btn_options' => 'Edytuj ustawienia forum',
	'btn_change' => 'Zmień',
	'btn_quote' => 'Cytuj',
	'btn_reply' => 'Odpowiedz',
	'btn_edit' => 'Edytuj',
	'btn_subscribe' => 'Dokonaj subskrybcji',
	'btn_unsubscribe' => 'Wypisz się z subskrybcji',
	'btn_search' => 'Szukaj',
	'btn_vote_up' => 'Niezła wiadomość!',
	'btn_vote_down' => 'Słaba wiadomość!',
	'btn_thanks' => 'Dziękuję!',
	'btn_translate' => 'Google Translate',

	# Selects
	'sel_group' => 'Wybierz grupę',
	'subscr_none' => 'Nic',
	'subscr_own' => 'Gdzie pisałem',
	'subscr_all' => 'Wszystkie wątki',

	# Config //imo no sense to translate config - PHmaster // translated - drummachina
	'cfg_guest_posts' => 'Pozwól gościom na pisanie wiadomości',	
	'cfg_max_descr_len' => 'Maksymalna długość opisu',	
	'cfg_max_message_len' => 'Maksymalna długość wiadomości',
	'cfg_max_sig_len' => 'Maksymalna długość sygnaturki',
	'cfg_max_title_len' => 'Maksymalna długość tytułu',
	'cfg_mod_guest_time' => 'Automatyczny czas moderacji',
	'cfg_num_latest_threads' => 'Ilość ostatnich wątków',
	'cfg_num_latest_threads_pp' => 'Wątków na stronie historii',
	'cfg_posts_per_thread' => 'Postów w temacie',
	'cfg_search' => 'Szukanie dozwolone',
	'cfg_threads_per_page' => 'Wątków w forum',
	'cfg_last_posts_reply' => 'Liczba pokazywanych postów przy odpowiedzi',
	'cfg_mod_sender' => 'Nadawca wiadomości moderowanej',
	'cfg_mod_receiver' => 'Odbiorca wiadomości moderowanej',
	'cfg_unread' => 'Włącz nieprzeczytane wątki',
	'cfg_gtranslate' => 'Włącz Google Translate',	
	'cfg_thanks' => 'Włącz podziękowania',
	'cfg_uploads' => 'Włącz upload',
	'cfg_votes' => 'Włącz głosowanie',
	'cfg_mail_microsleep' => 'EMail Microsleep :/ .. ???',	# ?!?!?!?! WTF is that?
	'cfg_subscr_sender' => 'Nadawca subskrypcji przez email',

	# show_thread.php
	'posts' => 'Wiadomości',
	'online' => 'Online',
	'offline' => 'Offline',
	'registered' => 'Zarejestrowany',
	'watchers' => '%1% użytkowników ogląda obecnie ten watek.',
	'views' => 'Ten temat został obejrzany %1% razy.',

	# forum.php
	'latest_threads' => 'Ostatnio aktywni',

	# Moderation EMail //imo no sense to translate config - PHmaster // translated - drummachina
	'modmail_subj' => GWF_SITENAME.': Moderuj wiadomość',
	'modmail_body' =>
		'Drodzy moderatorzy'.PHP_EOL.
		PHP_EOL.
		'Jest nowa wiadomość lub wątek na Forum '.GWF_SITENAME.', która wymaga moderacji.'.PHP_EOL.
		PHP_EOL.
		'Dział: %1%'.PHP_EOL.
		'Wątek: %2%'.PHP_EOL.
		'Od: %3%'.PHP_EOL.
		PHP_EOL.
		'%4%'.PHP_EOL.
		'%5%'.PHP_EOL.
		PHP_EOL.
		PHP_EOL.
		'Aby skasować post, kliknij w link:'.PHP_EOL.
		'%6%'.PHP_EOL.
		PHP_EOL.
		'Aby zaakceptować post, kliknij w link:'.PHP_EOL.
		'%7%'.PHP_EOL.
		PHP_EOL.
		PHP_EOL.
		'Post zostanie automatycznie pokazany po upływie %8%'.PHP_EOL.
		PHP_EOL.
		'Pozdrawiamy'.PHP_EOL.
		'Zespół '.GWF_SITENAME.PHP_EOL,

	# New Post EMail
	'submail_subj' => GWF_SITENAME.': Nowa wiadomość',
	'submail_body' => 
		'Szanowny użytkowniku %1%'.PHP_EOL.
		PHP_EOL.
		'Mamy %2% nowych wiadomości na '.GWF_SITENAME.' forach'.PHP_EOL.
		PHP_EOL.
		'Forum: %3%'.PHP_EOL.
		'Wątek: %4%'.PHP_EOL.
		PHP_EOL.
		'<hr/>'.PHP_EOL.
		PHP_EOL.
		'%5%'.PHP_EOL. # Multiple msgs possible
		PHP_EOL.
		PHP_EOL.
		'To view the thread please visit this page:'.PHP_EOL.
		'%8%'.PHP_EOL.
		PHP_EOL.
		'Jeśli chcesz zrezygnować z subskrypcji tego tematu kliknij w link:'.PHP_EOL.
		'%6%'.PHP_EOL.
		PHP_EOL.
		'Jeśli chcesz zrezygnować z subskrupcji, kliknij w link:'.PHP_EOL.
		'%7%'.PHP_EOL.
		PHP_EOL.
		'Pozdrawiamy'.PHP_EOL.
		'Nasz '.GWF_SITENAME.' zespół WeChall'.PHP_EOL,
		
	'submail_body_part' =>  # that`s the %5% above
		'Od: %1%'.PHP_EOL.
		'Tytuł: %2%'.PHP_EOL.
		'Wiadomość:'.PHP_EOL.
		'%3%'.PHP_EOL.
		PHP_EOL.
		'<hr/>'.PHP_EOL.
		PHP_EOL,
		
	# v2.01 (last seen)
	'last_seen' => 'Ostatnio widziany: %1%',

	# v2.02 (Mark all read)
	'btn_mark_read' => 'Zaznacz wszystkie jako przeczytane',
	'msg_mark_aread' => 'Zaznacz %1% wątki jako przeczytane.',

	# v2.03 (Merge)
	'msg_merged' => 'Watki zostały złączone.',
	'th_viewcount' => 'Obejrzeń',

	# v2.04 (Polls)
	'ft_add_poll' => 'Przydziel ankietę',
	'btn_assign' => 'Przydziel',
	'btn_polls' => 'Ankiety',
	'btn_add_poll' => 'Dodaj ankietę',
	'msg_poll_assigned' => 'Twoja ankieta została stworzona.',
	'err_poll' => 'Ankieta jest nieznana.',
	'th_thread_pollid' => 'Twoja ankieta',
	'pi_poll_add' => 'Tutaj możesz dołączyć ankietę do tematu, bądź stworzyć nową.<br/>Po jej stworzeniu musisz ponownie dołączyć ja do wątku..',
	'sel_poll' => 'Wybierz ankietę',
		
	# v2.05 (refinish)
	'th_hidden' => 'Czy ukryty?',
	'th_thread_viewcount' => 'Obejrzeń',
	'th_unread_again' => 'Ponownie zaznaczyć jako nieprzeczytany?',
	'cfg_doublepost' => 'Pozwól na podwójne wiadomości',
	'cfg_watch_timeout' => 'Zaznacz wątek jako obserwowany przez N sekund',
	'th_guest_view' => 'Udostępnić wgląd dla gości?',
	'pt_history' => 'Historia forum - Strona %1% / %2%',
	'btn_unread' => 'Nowe wątki',
		
	# v2.06 (Admin Area)
	'th_approve' => 'Akceptuj',
	'th_delete' => 'Usuń',
		
	# v2.07 rerefinish
	'btn_pm' => 'PM',
	'permalink' => 'link',
		
	# v2.08 (attachment)
	'cfg_postcount' => 'Postcount',
	'msg_attach_added' => 'Your attachment has been uploaded. <a href="%1%">Click here to return to your post.</a>',
	'msg_attach_deleted' => 'Your attachment has been deleted. <a href="%1%">Click here to return to your post.</a>',
	'msg_attach_edited' => 'Your attachment has been edited. <a href="%1%">Click here to return to your post.</a>',
	'msg_reupload' => 'Your attachment has been replaced.',
	'btn_add_attach' => 'Add Attachment',
	'btn_del_attach' => 'Delete Attachment',
	'btn_edit_attach' => 'Edit Attachment',
	'ft_add_attach' => 'Add Attachment',
	'ft_edit_attach' => 'Edit Attachment',
	'th_attach_file' => 'File',
	'th_guest_down' => 'Guest downloadable?',
	'err_attach' => 'Unknown attachment.',
	'th_file_name' => 'File',
	'th_file_size' => 'Size',
	'th_downloads' => 'Hits',

	# v2.09 Lang Boards
	'cfg_lang_boards' => 'Create language boards',
	'lang_board_title' => '%1% Board',
	'lang_board_descr' => 'For %1% language',
	'lang_root_title' => 'Foreign language',
	'lang_root_descr' => 'Non english boards',
	'md_board' => GWF_SITENAME.' Forums. %1%',
	'mt_board' => GWF_SITENAME.', Forum, Guest Posts, Alternate, Forum, Software',
		
	# v2.10 subscribers
	'subscribers' => '%1% have subscribed to this thread and receive emails on new posts.',
	'th_hide_subscr' => 'Hide your subscriptions?',

	# v2.11 fixes11
	'txt_lastpost' => 'Goto last post',
	'err_thank_self' => 'You cannot thank yourself for a post.',
	'err_vote_self' => 'You cannot vote your own posts.',

	# v3.00 fixes 12
	'info_hidden_attach_guest' => 'You need to login to see an attachment.',
	'msg_cleanup' => 'I have deleted %1% threads and %2% posts that have been in moderation.',
		
	# v1.05 (subscriptions)
	'submode' => 'Your global subscription mode is set to: &quot;%1%&quot;.',
	'submode_all' => 'The whole board',
	'submode_own' => 'Where you posted',
	'submode_none' => 'Manually',
	'subscr_boards' => 'Your have manually subscribed to %1% boards.',
	'subscr_threads' => 'You have manually subscribed to %1% threads.',
	'btn_subscriptions' => 'Manage Subscriptions',
	'msg_subscrboard' => 'You have manually subscribed to this board and receive email on new posts.<br/>Click <a href="%1%">here to return to the board</a>.',
	'msg_unsubscrboard' => 'You have unsubscribed from this board and do not receive emails for it anymore.<br/>Click <a href="%1%">here to return to your subscription overview</a>.',
);

?>