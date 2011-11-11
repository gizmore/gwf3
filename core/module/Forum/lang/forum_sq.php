<?php
$lang = array(
	# Errors
	'err_board' => 'Ky bord nuk ekziston, ose ata nuk kanë autoritet.',
	'err_thread' => 'Kjo temë nuk ekziston, ose ata nuk kanë autoritet.',
	'err_post' => 'Ky mesazh është i panjohur.',
	'err_parentid' => 'Bordi prindi është i panjohur.',
	'err_groupid' => 'Ky grup është i panjohur.',
	'err_board_perm' => 'Ju nuk mund të ketë qasje në këtë bord.',
	'err_thread_perm' => 'Ju nuk mund të ketë qasje në këtë çështje.',
	'err_post_perm' => 'Ju nuk mund të lexuar mesazhin.',
	'err_reply_perm' => 'Ju nuk mund të përgjigjeni në këtë temë. <a href="%1$s">Kliko këtu për tu kthyer në temë</a>.',
	'err_no_thread_allowed' => 'Nuk ka tema ne kete bord janë të lejuara.',
	'err_no_guest_post' => 'Mysafir nuk mund të shkruaj në këtë bord.',
	'err_msg_long' => 'Mesazhi juaj është shumë i gjatë. lejohet një maksimum %1$s Shenjë.',
	'err_msg_short' => 'Ju keni harruar mesazhin.',
	'err_descr_long' => 'Përshkrimi juaj është shumë i gjatë. lejohet një maksimum %1$s Shenjë.',
	'err_descr_short' => 'Ju harruar Përshkrimi.',
	'err_title_long' => 'Titulli është shumë i gjatë. Lejohet një maksimum%1$s Shenjë.',
	'err_title_short' => 'Keni harruar titullin.',
	'err_sig_long' => 'Firma juaj është shumë i gjatë. Lejohet një maksimum %1$s Shenjë.',
	'err_subscr_mode' => 'Panjohur mode Forumi abonimit.',
	'err_no_valid_mail' => 'Ju nuk keni një email të konfirmuar të regjistroheni në forum.',
	'err_token' => 'Shenjë është i pavlefshëm.',
	'err_in_mod' => 'Kjo çështje është ende në moderim.',
	'err_board_locked' => 'Ky bord është mbyllur përkohësisht.',

	'err_no_subscr' => 'Ju mund të regjistroheni në këtë temë nuk është shtesë. <a href="%1$s">Kliko këtu për tu kthyer në temë</a>.',
	'err_subscr' => 'Një gabim ka ndodhur. <a href="%1$s">Kliko këtu për tu kthyer në temë</a>.',
	'err_no_unsubscr' => 'Ju nuk mund të largohet nga Abbonenemt për këtë çështje. <a href="%1$s">Kliko këtu për tu kthyer në temë</a>.',
	'err_unsubscr' => 'Një gabim ka ndodhur. <a href="%1$s">Kliko këtu për tu kthyer në temë</a>.',
	'err_sub_by_global' => 'Ju jeni i regjistruar në këtë temë nuk është shtesë, por me parametrat e tyre globale.<br/>Përdorni <a href="/forum/options">Forumi Paneli i punëve</a> për të ndryshuar opsionet e tyre.',
	'err_thank_twice' => 'Ju keni tashmë falenderoi për atë mesazh.',
	'err_thanks_off' => 'Ajo është aktualisht nuk është e mundur të falenderoj për lajme.',
	'err_votes_off' => 'Shqyrtim i mesazheve është mbyllur në këtë kohë.',
	'err_better_edit' => 'Ju lutemi redaktoni mesazhin tuaj te fundit. Nuk është e mundur të dërgojë dy herë në një mesazh rresht. Ju mund të &quot;Shëno si të lexuar&quot;, në qoftë se ata dëshirojnë të bëjnë ndryshime serioze në mesazhin e tyre.<br/><a href="%1$s">Kliko këtu për tu kthyer në temë</a>.',

	# Messages
	'msg_posted' => 'Mesazhi juaj u dërgua.<br/><a href="%1$s">Kliko këtu për të parë mesazhin tuaj</a>.',
	'msg_posted_mod' => 'Mesazhi juaj u dërgua. Ai duhet, megjithatë, kontrolluar nga një moderator para ekranit.<br/><a href="%1$s">Kliko këtu për të shkuar mbrapa në Bord të</a>.',
	'msg_post_edited' => 'Mesazhi i juaj është redaktuar.<br/><a href="%1$s">Kliko këtu për të parë mesazhin tuaj</a>.',
	'msg_edited_board' => 'Bordi është redaktuar.<br/><a href="%1$s">Kliko këtu për tu kthyer në Bordin</a>.',
	'msg_board_added' => 'Një bord i ri u shtua. <a href="%1$s">Kliko këtu për tu kthyer në forum</a>.',
	'msg_edited_thread' => 'Tema është ndryshuar me sukses.',
	'msg_options_changed' => 'Mundësitë tuaja janë ndryshuar.',
	'msg_thread_shown' => 'Tema është testuar dhe është shfaqur nga tani.',
	'msg_post_shown' => 'Ky lajm është rishikuar dhe është shfaqur nga tani.',
	'msg_thread_deleted' => 'Tema u fshi.',
	'msg_post_deleted' => 'Post u fshi.',
	'msg_board_deleted' => 'Gjithë bordi u fshi!',
	'msg_subscribed' => 'Ju jeni i regjistruar në këtë temë dhe tani do të merrni email kur një mesazh të ri.<br/><a href="%1$s">Kliko këtu për tu kthyer në temë</a>.',
	'msg_unsubscribed' => 'Ata kanë denoncuar Abbonement për këtë çështje dhe nuk do të marrin ndonjë email më shumë për këtë temë.<br/><a href="%1$s">Kliko këtu për tu kthyer në temë</a>.',
	'msg_unsub_all' => 'Ata kanë denoncuar të gjitha Abbonementa.',
	'msg_thanked_ajax' => 'Faliminderi juaj është regjistruar në bazën e të dhënave.',
	'msg_thanked' => 'Faliminderi juaj ishte regjistruar në bazën e të dhënave.<br/><a href="%1$s">Klicken sie hier um zur Nachricht zurückzukehren</a>.',
	'msg_thread_moved' => 'Tema %1$s ishte për të %2$s lëvizur.',
	'msg_voted' => 'Faleminderit për votën tuaj.',
	'msg_marked_read' => 'Ka qenë %1$s Temat shënuar si të lexuar.',

	# Titles
	'forum_title' => GWF_SITENAME.' Forum',
	'ft_add_board' => 'Bordit të ri',
	'ft_add_thread' => 'Shto Tema të reja',
	'ft_edit_board' => 'redaktimi Bordi',  #Deutsche Version ist hier falsch!#
	'ft_edit_thread' => 'redaktimi Theme',
	'ft_options' => 'Mundësitë e zgjedhjes Forumi Vendosja',
	'pt_thread' => '%2$s  ['.GWF_SITENAME.']->%1$s',
	'ft_reply' => 'Përgjigju temës',
	'pt_board' => '%1$s ',
//	'pt_board' => '%1$s ['.GWF_SITENAME.']',
	'ft_search_quick' => 'Quick Search',
	'ft_edit_post' => 'Mesazhi juaj Edit',
	'at_mailto' => 'Një email dërguar per %1$s',
	'last_edit_by' => 'Fundit modifikuar nga %1$s - %2$s',

	# Page Info
	'pi_unread' => 'Temat e Vjetër',

	# Table Headers
	'th_board' => 'Forum',
	'th_threadcount' => 'Temat',
	'th_postcount' => 'Lajm',
	'th_title' => 'Titull',
	'th_message' => 'Mesazh',
	'th_descr' => 'Përshkrim',	
	'th_thread_allowed' => 'Çështjet e lejeve të',	
	'th_locked' => 'Mbyllur',
	'th_smileys' => 'heki figurina',
	'th_bbcode' => 'heki BBCode',
	'th_groupid' => 'Kufizojnë në një grup',
	'th_board_title' => 'Bordi Titulli',
	'th_board_descr' => 'Përshkrimi Bordi',
	'th_subscr' => 'EMail Abbonemente',
	'th_sig' => 'Forumi juaj nënshkrim',
	'th_guests' => 'Mysafir lejojë mesazhe',
	'th_google' => 'Google/Übersetzer nuk integrohen',
	'th_firstposter' => 'Krijues',
	'th_lastposter' => 'Përgjigje',
	'th_firstdate' => 'Mesazhi i parë',
	'th_lastdate' => 'Postimi Fundit',
	'th_post_date' => 'Mesazh nga',
	'th_user_name' => 'Përdorues',
	'th_user_regdate' => 'te regjistruar ',
//	'th_unread_again' => '',
	'th_sticky' => 'Rëndësishëm',
	'th_closed' => 'Mbyllur',
	'th_merge' => 'Temat së bashku',
	'th_move_board' => 'Masa Bordi',
	'th_thread_thanks' => 'Falënderim',
	'th_thread_votes_up' => '+Votes',
	'th_thanks' => 'Falemnderit',
	'th_votes_up' => '+Votes',

	# Buttons
	'btn_add_board' => 'Bordi Krijo reja',
	'btn_rem_board' => 'Bordi fshini',
	'btn_edit_board' => 'Ky bord redaktimi',
	'btn_add_thread' => 'Tema e re',
	'btn_preview' => 'shoh',
	'btn_options' => 'Forumi Paneli i punëve',
	'btn_change' => 'Ndryshim',
	'btn_quote' => 'Citim',
	'btn_reply' => 'Përgjigje',
	'btn_edit' => 'Redaktoj',
	'btn_subscribe' => 'Nënshkruaj',
	'btn_unsubscribe' => 'Anuloj',
	'btn_search' => 'Kërkim',
	'btn_vote_up' => 'Lajme të mira!',
	'btn_vote_down' => 'Mesazh e keqe',
	'btn_thanks' => 'Falemnderit!',
	'btn_translate' => 'Google/Übersetzer',

	# Selects
	'sel_group' => 'Zgjidhni një grup përdorues',
	'subscr_none' => 'Asgjë',
	'subscr_own' => 'Ku kam shkruar',
	'subscr_all' => 'Gjithë temat',

	# Config
	'cfg_guest_posts' => 'Mysafir lejojë mesazhe',	
	'cfg_max_descr_len' => 'Gjatësia më e madhe për përshkrimet e',	
	'cfg_max_message_len' => 'Gjatësia më e madhe e mesazheve',
	'cfg_max_sig_len' => 'Gjatësia më e madhe për nënshkrimet',
	'cfg_max_title_len' => 'Gjatësia më e madhe për titullin',
	'cfg_mod_guest_time' => 'Kohë Automatik moderim',
	'cfg_num_latest_threads' => 'Numri i temave më të fundit',
	'cfg_num_latest_threads_pp' => 'Numri i temave për faqe te kaluara', #Deutsche Version ist falsch!!
	'cfg_posts_per_thread' => 'Numri i temave të lajme për faqe',
	'cfg_search' => 'Kërko lejon?',
	'cfg_threads_per_page' => 'Numri i temave për bordit anën',
	'cfg_last_posts_reply' => 'Numri i mesazheve të vjetra, kur iu përgjigjur',
	'cfg_mod_sender' => 'EMail Sender për moderim',
	'cfg_mod_receiver' => 'Mail Marresit për moderim',
	'cfg_unread' => 'Temat e zgjedhura vjetër?',
	'cfg_gtranslate' => 'Google/Übersetzer aktivizimit?',	
	'cfg_thanks' => 'Faleminderit aktivizimit?',
	'cfg_uploads' => 'Ngarkimet aktivizuar?',
	'cfg_votes' => 'Voteink aktivizimit?', #Deutsche Version falsch!
	'cfg_mail_microsleep' => 'Pushim mes E-mail (in ms)',	
	'cfg_subscr_sender' => 'Email Sender për tema regjistruar',

	# show_thread.php
	'posts' => 'Lajm',
	'online' => 'Ky përdorues është online',
	'offline' => 'Ky përdorues është në linjë',
	'registered' => 'Anëtarësuar',
	'watchers' => '%1$s Njerëzit shikojnë këtë çështje tani.',
	'views' => 'Kjo temë është %1$s shikime.',

	# forum.php
	'latest_threads' => 'Temat e fundit',

	# Moderation EMail
	'modmail_subj' => GWF_SITENAME.': mesazhin moderues',
	'modmail_body' =>
		'moderatorët e nderuar'.PHP_EOL.
		PHP_EOL.
		'Es gibt eine neue Nachricht im '.GWF_SITENAME.' Forumi moderim e nevojshme.'.PHP_EOL.
		PHP_EOL.
		'Bordi: %1$s'.PHP_EOL.
		'Temë: %2$s'.PHP_EOL.
		'Nga: %3$s'.PHP_EOL.
		PHP_EOL.
		'%4$s'.PHP_EOL.
		'%5$s'.PHP_EOL.
		PHP_EOL.
		PHP_EOL.
		'Për të fshirë mesazhin, ata e quajnë këtë faqe:'.PHP_EOL.
		'%6$s'.PHP_EOL.
		PHP_EOL.
		'Për të parë mesazhin, ata e quajnë këtë faqe:'.PHP_EOL.
		'%7$s'.PHP_EOL.
		PHP_EOL.
		PHP_EOL.
		'Mesazhi është automatikisht mas %8$s përshtatshme.'.PHP_EOL.
		PHP_EOL.
		'Përshëndetje'.PHP_EOL.
		''.GWF_SITENAME.' Teami'.PHP_EOL,

	# New Post EMail
	'submail_subj' => GWF_SITENAME.': Forumin e ri',
	'submail_body' => 
		'Përshëndetje %1$s'.PHP_EOL.
		PHP_EOL.
		'Ka %2$s mesazh te rea '.GWF_SITENAME.' Forum'.PHP_EOL.
		PHP_EOL.
		'Bordi: %3$s'.PHP_EOL.
		'Temë: %4$s'.PHP_EOL.
		PHP_EOL.
		'<hr/>'.PHP_EOL.
		PHP_EOL.
		'%5$s'.PHP_EOL. # Multiple msgs possible
		PHP_EOL.
		PHP_EOL.
		'To view the thread please visit this page:'.PHP_EOL.
		'%8$s'.PHP_EOL.
		PHP_EOL.
		'Për të përfunduar Abbonement për këtë çështje ata e quajnë këtë faqe:'.PHP_EOL.
		'%6$s'.PHP_EOL.
		PHP_EOL.
		'Për të anulojë të gjitha Abbonements, ata mund të hyrë në këtë faqe:'.PHP_EOL.
		'%7$s'.PHP_EOL.
		PHP_EOL.
		'I juaji sinqerisht,'.PHP_EOL.
		''.GWF_SITENAME.' Teami'.PHP_EOL,
		
	'submail_body_part' =>  # that`s the %5$s above
		'Nga: %1$s'.PHP_EOL.
		'Titull: %2$s'.PHP_EOL.
		'Mesazh:'.PHP_EOL.
		'%3$s'.PHP_EOL.
		PHP_EOL.
		'<hr/>'.PHP_EOL.
		PHP_EOL,
		
	# v2.01 (last seen)
	'last_seen' => 'E fundit shihet në: %1$s',

	# v2.02 (Mark all read)
	'btn_mark_read' => 'Mark të gjitha të lexuar',
	'msg_mark_aread' => '%1$s Çështjet janë shënuar si të lexuar.',

	# v2.03 (Merge)
	'msg_merged' => 'Tema është bashkuar.',
	'th_viewcount' => 'pamje',

	# v2.04 (Polls)
	'ft_add_poll' => 'Cakto ato të një prej sondazheve të tyre',
	'btn_assign' => 'Caktoj',
	'btn_polls' => 'Sondazhet',
	'btn_add_poll' => 'Shto Anketa',
	'msg_poll_assigned' => 'Sondazhi juaj u shtua.',
	'err_poll' => 'Ky studim është i panjohur.',
	'th_thread_pollid' => 'Anketa juaj',
	'pi_poll_add' => 'Këtu ju mund të caktoni të subjektit të tyre, një studim, ose të krijoni një anketë e re.<br/>Pasi që ata kanë krijuar një sondazh, ju mund të caktoni tyre këtu.',
	'sel_poll' => 'Zgjidh një sondazh',
		
	# v2.05 (refinish)
	'th_hidden' => 'Fshehur?',
	'th_thread_viewcount' => 'Pamje',
	'th_unread_again' => 'Shënoje si i ri?',
	'cfg_doublepost' => 'Dy-Postimet lejojnë?',
	'cfg_watch_timeout' => 'Theme si &quot;am lexoj&quot; shenjë për N sekonda',
	'th_guest_view' => 'Për rezultatin e dukshme?',
	'pt_history' => 'tema të vjetra në këtë forum - Faqe %1$s / %2$s',
	'btn_unread' => 'Temat e reja',
		
	# v2.06 (Admin Area)
	'th_approve' => 'Tregoj',
	'th_delete' => 'Fshij',
		
	# v2.07 rerefinish
	'btn_pm' => 'PN',
	'permalink' => 'Lidhje',
		
	# v2.08 (attachment)
	'cfg_postcount' => 'Mesazh akuzë',
	'msg_attach_added' => 'Shtojcën juaj është ngarkuar. <a href="%1$s">Kliko këtu për tu kthyer në zurückzugelangen tyre mesazh.</a>',
	'msg_attach_deleted' => 'Shtojcën juaj u fshi. <a href="%1$s">Kliko këtu për tu kthyer në zurückzugelangen tyre mesazh.</a>',
	'msg_attach_edited' => 'Shtojcën juaj është përpunuar. <a href="%1$s">Kliko këtu për tu kthyer në zurückzugelangen tyre mesazh.</a>',
	'msg_reupload' => 'Shtojcën juaj është zëvendësuar.',
	'btn_add_attach' => 'Shto bashkëngjitje',
	'btn_del_attach' => 'Shtojca Fshije',
	'btn_edit_attach' => 'Shtojca  puno',
	'ft_add_attach' => 'Shto një bashkëngjitje',
	'ft_edit_attach' => 'Puno Shtojca tuaj',
	'th_attach_file' => 'Skedar',
	'th_guest_down' => 'Mysafir mund të shkarkoni shtojcën?',
	'err_attach' => 'Shtojca panjohur.',
	'th_file_name' => 'Emri i dokumentit',
	'th_file_size' => 'Madhësi',
	'th_downloads' => 'Shkarkime',

	# v2.09 Lang Boards
	'cfg_lang_boards' => 'Zëri bordet japin',
	'lang_board_title' => '%1$s Forum',
	'lang_board_descr' => 'Për %1$s Gjuhë',
	'lang_root_title' => 'Në gjuhë të tjera',
	'lang_root_descr' => 'Bordet Jo-Anglisht',
	'md_board' => GWF_SITENAME.' Forum. %1$s',
	'mt_board' => GWF_SITENAME.', Forum, Mysafir Lajme, Alternativ, Forum, Program',
		
	# v2.10 subscribers
	'subscribers' => '%1$s janë regjistruar në këtë temë dhe të marrin mesazhe email me një mesazh të ri.',
	'th_hide_subscr' => 'Abonimet fshih?',
		
	# v2.11 fixes11
	'txt_lastpost' => 'Postimi i fundit',
	'err_thank_self' => 'Ju nuk mund të vlerësojmë kontributet e tyre.',
	'err_vote_self' => 'Ju nuk mund të votoni postimet tuaja.',

	# v3.00 fixes 12
	'info_hidden_attach_guest' => 'You need to login to see an attachment.',
	'msg_cleanup' => 'I have deleted %1$s threads and %2$s posts that have been in moderation.',
		
	# v1.05 (subscriptions)
	'submode' => 'Your global subscription mode is set to: &quot;%1$s&quot;.',
	'submode_all' => 'The whole board',
	'submode_own' => 'Where you posted',
	'submode_none' => 'Manually',
	'subscr_boards' => 'Your have manually subscribed to %1$s boards.',
	'subscr_threads' => 'You have manually subscribed to %1$s threads.',
	'btn_subscriptions' => 'Manage Subscriptions',
	'msg_subscrboard' => 'You have manually subscribed to this board and receive email on new posts.<br/>Click <a href="%1$s">here to return to the board</a>.',
	'msg_unsubscrboard' => 'You have unsubscribed from this board and do not receive emails for it anymore.<br/>Click <a href="%1$s">here to return to your subscription overview</a>.',

	# v1.06 (Post limits)
	'err_post_timeout' => 'You have just recently posted. Please wait %s.',
	'err_post_level' => 'You need a minimum userlevel of %s to post.',
	'cfg_post_timeout' => 'Minimum time between two posts',
	'cfg_post_min_level' => 'Minimum level to post',
);

?>