<?php
 
$lang = array(

	# Errors
	'err_board' => 'Tahvlit ei leitud või puudul teil luba sellele ligipääsemiseks.',
	'err_thread' => 'Teemat ei leitud või puudub teil luba sellele ligipääsemiseks.',
	'err_post' => 'Postitust ei leitud.',
	'err_parentid' => 'Tahvlit ei leitud.',
	'err_groupid' => 'Gruppi ei leitud.',
	'err_board_perm' => 'Teil puudub ligipääs antud tahvlile.',
	'err_thread_perm' => 'Teil puudub ligipääs sellele teemale.',
	'err_post_perm' => 'Teil ei ole lubatud seda postitust lugeda.',
	'err_reply_perm' => 'Teil ei ole lubatud sellele postitusele vastata. <a href="%1%">Vajuta siia, et minna tagasi teema juurde</a>.',
	'err_no_thread_allowed' => 'Sellel tahvlil ei ole teemad lubatud.',
	'err_no_guest_post' => 'Külalised ei saa siia foorumisse postitada.',
	'err_msg_long' => 'Teie postitus on liiga pikk. Maksimaalselt on lubatud %1% tähte.',
	'err_msg_short' => 'Te unustasite oma sõnumi.',
	'err_descr_long' => 'Teie kirjeldus on liiga pikk. Maksimaalselt on lubatud %1% tähte.',
	'err_descr_short' => 'Te unustasite kirjelduse.',
	'err_title_long' => 'Teie pealkiri on liiga pikk. Maksimaalselt on lubatud %1% tähte.',
	'err_title_short' => 'Te unustasite pealkirja.',
	'err_sig_long' => 'Teie signatuur on liiga pikk. Max % Maksimaalselt on lubatud %1% tähte.',
	'err_subscr_mode' => 'Tundmatu tellimisviis.',
	'err_no_valid_mail' => 'Teil pole kinnitatud e-maili et liituda foorumiga.',
	'err_token' => 'Märk on vigane.',
	'err_in_mod' => 'Hetkel seda teemat modereeritakse.',
	'err_board_locked' => 'Tahvel on ajutiselt lukustatud.',
	'err_no_subscr' => 'Te ei saa käsitsi selle teemaga liituda. <a href="%1%">Vajutage siia, et pöörduda tagasi teemasse</a>.',
	'err_subscr' => 'Esines viga. <a href="%1%"> Vajutage siia, et pöörduda tagasi teemasse</a>.',
	'err_no_unsubscr' => 'Te ei saa sellest teemast lahkuda<a href="%1%"> Vajutage siia, et pöörduda tagasi teemasse</a>.',
	'err_unsubscr' => 'Esines viga. <a href="%1%"> Vajutage siia, et pöörduda tagasi teemasse</a>.',
	'err_sub_by_global' => 'Te ei liitunud teemaga käsitsi, vaid globaalselt.<br/><a href="/forum/options">Kasuta foorumisätteid</a>, et muuta oma lippe.',
	'err_thank_twice' => 'Te olete selle posti eest juba tänanud.',
	'err_thanks_off' => 'Ajutiselt ei ole võimalik inimesi postituste eest tänada.',
	'err_votes_off' => 'Foorumi postituste hääletamine on ajutiselt keelatud.',
	'err_better_edit' => 'Palun muudke oma postitust ning ärge tehke kahte posti. Te saate vahetada &quot;Mark-Unread&quot; lippe juhul kui teete suuremaid muudatusi.<br/><a href="%1%"> Vajutage siia, et pöörduda tagasi teemasse</a>.',

	# Messages
	'msg_posted' => 'Teie sõnum on postitatud.<br/><a href="%1%">Vajutage siia, et näha oma postitust </a>.',
	'msg_posted_mod' => 'Teie postitus on postitatud, kuid see vaadatakse läbi enne avalikustamist.<br/><a href="%1%">Vajutage siia, et pöörduda tagasi tahvlile</a>.',
	'msg_post_edited' => 'Teie postitus sai muudetud.<br/><a href="%1%">Vajutage siia, et minna tagasi oma postitusse</a>.',
	'msg_edited_board' => 'Tahvlit on muudetud.<br/><a href="%1%">Vajutage siia, et pöörduda tagasi tahvlile</a>.',
	'msg_board_added' => 'Uue tahvli lisamine õnnestus. <a href="%1%">Vajutage siia, et pöörduda tagasi tahvlile</a>.',
	'msg_edited_thread' => 'Teema muutmine õnnestus.',
	'msg_options_changed' => 'Teie valikud on muudetud.',
	'msg_thread_shown' => 'Teema on heakskiidetud ja nähtavaks tehtud.',
	'msg_post_shown' => 'Postitus on heakskiidetud ja nähtavaks tehtud.',
	'msg_thread_deleted' => 'Teema on kustutatud.',
	'msg_post_deleted' => 'Postitus on kustutatud.',
	'msg_board_deleted' => 'Kogu tahvel on kustutatud!',
	'msg_subscribed' => 'Te liitusite teemaga ja saate uued postitused e-mailile.<br/><a href="%1%">Vajutage siia, et pöörduda tagasi teemasse</a>.',
	'msg_unsubscribed' => 'Te lahkusite teemast ja ei saa edasisi sõnumeid e-mailile.<br/><a href="%1%">Vajutage siia, et pöörduda tagasi teemasse</a>.',
	'msg_unsub_all' => 'Te lahkusite oma e-mailiga kõikidest teemadest.',
	'msg_thanked_ajax' => 'Teie tänuavaldus on salvestatud.',
	'msg_thanked' => 'Teie tänuavaldus on salvestatud.<br/><a href="%1%">Vajutage siia, et pöörduda postitusse</a>.',
	'msg_thread_moved' => 'Teema %1% on liigutatud %2%.',
	'msg_voted' => 'Täname hääle eest.',
	'msg_marked_read' => 'Teema %1% märgiti õnnestunult loetuks.',

	# Titles
	'forum_title' => GWF_SITENAME.' Foorumid',
	'ft_add_board' => 'Lisa tahvel',
	'ft_add_thread' => 'Lisa teema',
	'ft_edit_board' => 'Muuda olemasolevat tahvlit',
	'ft_edit_thread' => 'Muuda teemat',
	'ft_options' => 'Seadista oma foorumisätted',
	'pt_thread' => '%2% ['.GWF_SITENAME.']->%1%',
	'ft_reply' => 'Vasta teemale',
	'pt_board' => '%1%',
//	'pt_board' => '%1% ['.GWF_SITENAME.']',
	'ft_search_quick' => 'Kiirotsing',
	'ft_edit_post' => 'Muuda oma postitust',
	'at_mailto' => 'Saada e-mail %1%',
	'last_edit_by' => 'Viimati muudetud %1% - %2%',

	# Page Info
	'pi_unread' => 'Lugemata teemad',

	# Table Headers
	'th_board' => 'Tahvel',
	'th_threadcount' => 'Teemad',
	'th_postcount' => 'Postitused',
	'th_title' => 'Pealkiri',
	'th_message' => 'Sõnum',
	'th_descr' => 'Kirjeldus',	
	'th_thread_allowed' => 'Teemad lubatud',	
	'th_locked' => 'Lukus',
	'th_smileys' => 'Keela smailid',
	'th_bbcode' => 'Keela BBCode',
	'th_groupid' => 'Piira grupile',
	'th_board_title' => 'Tahvli nimi',
	'th_board_descr' => 'Tahvli kirjeldus',
	'th_subscr' => 'Liitumine e-mailiga',
	'th_sig' => 'Sinu foorumi signatuur',
	'th_guests' => 'Luba külalistel postitada',
	'th_google' => 'Ära kaasa Google/Translate Javascript',
	'th_firstposter' => 'Tegija',
	'th_lastposter' => 'Vasta',
	'th_firstdate' => 'Esimene postitus',
	'th_lastdate' => 'Viimane postitus',
	'th_post_date' => 'Postituse kuupäev',
	'th_user_name' => 'Kasutajanimi',
	'th_user_regdate' => 'Registreeritud',
//	'th_unread_again' => '',
	'th_sticky' => 'Kleeps',
	'th_closed' => 'Lukus',
	'th_merge' => 'Märgi teema',
	'th_move_board' => 'Liiguta tahvlit',
	'th_thread_thanks' => 'Aitäh',
	'th_thread_votes_up' => 'Üleshääled',
	'th_thanks' => 'Aitäh',
	'th_votes_up' => 'Hääl üles',

	# Buttons
	'btn_add_board' => 'Loo uus tahvel',
	'btn_rem_board' => 'Kustuta tahvel',
	'btn_edit_board' => 'Muuda olemasolevat tahvlit',
	'btn_add_thread' => 'Lisa teema',
	'btn_preview' => 'Eelvaade',
	'btn_options' => 'Muuda oma foorumi seadistusi',
	'btn_change' => 'Muuda',
	'btn_quote' => 'Tsiteeri',
	'btn_reply' => 'Vasta',
	'btn_edit' => 'Muuda',
	'btn_subscribe' => 'Liitu',
	'btn_unsubscribe' => 'Lõpeta liitumine',
	'btn_search' => 'Otsi',
	'btn_vote_up' => 'Hea postitus!',
	'btn_vote_down' => 'Halb postitus!',
	'btn_thanks' => 'Aitäh!',
	'btn_translate' => 'Google/translate',

	# Selects
	'sel_group' => 'Vali kasutajagrupp',
	'subscr_none' => 'Midagi',
	'subscr_own' => 'Kuhu ma postitasin',
	'subscr_all' => 'Kõik teemad',

	# Config
	'cfg_guest_posts' => 'Luba külalistel postitada',	
	'cfg_max_descr_len' => 'Suurim kirjelduse pikkus',	
	'cfg_max_message_len' => 'Suurim sõnumi pikkus',
	'cfg_max_sig_len' => 'Suurim signatuuri pikkus',
	'cfg_max_title_len' => 'Suurim pealkirja pikkus',
	'cfg_mod_guest_time' => 'Automaatne aja modereerimine',
	'cfg_num_latest_threads' => 'Viimaste teemade arv',
	'cfg_num_latest_threads_pp' => 'Teemasid lehekülje kohta',
	'cfg_posts_per_thread' => 'Poste teema kohta',
	'cfg_search' => 'Otsing lubatud',
	'cfg_threads_per_page' => 'Teemasid tahvli kohta',
	'cfg_last_posts_reply' => 'Nähtavate postituste arv vastamisel',
	'cfg_mod_sender' => 'Moderaatori e-maili saatja',
	'cfg_mod_receiver' => 'Moderaatori e-maili saaja',
	'cfg_unread' => 'Luba lugemata teemad',
	'cfg_gtranslate' => 'Luba Google Translate',	
	'cfg_thanks' => 'Luba tänamine',
	'cfg_uploads' => 'Luba üleslaadimine',
	'cfg_votes' => 'Luba hääletamine',
	'cfg_mail_microsleep' => 'EMail Microsleep :/ .. ???',	
	'cfg_subscr_sender' => 'E-maili liitumise saatja',

	# show_thread.php
	'posts' => 'Postitused',
	'online' => 'Kasutaja on hetkel sees',
	'offline' => 'Kasutaja on hetkel väljas',
	'registered' => 'Registreeritud',
	'watchers' => '%1% vaatavad hetkel seda teemat.',
	'views' => 'Seda teemat on vaadatud %1% korda.',

	# forum.php
	'latest_threads' => 'Viimased tegevused',

	# Moderation EMail
	'modmail_subj' => GWF_SITENAME.': Modereeri postitust',
	'modmail_body' =>
		'Dear Staff'.PHP_EOL.
		PHP_EOL.
		'Uus postitus või teema leheküljel '.GWF_SITENAME.' Foorumid, mis vajavad modereerimist.'.PHP_EOL.
		PHP_EOL.
		'Tahvel: %1%'.PHP_EOL.
		'Teema: %2%'.PHP_EOL.
		'Kellelt: %3%'.PHP_EOL.
		PHP_EOL.
		'%4%'.PHP_EOL.
		'%5%'.PHP_EOL.
		PHP_EOL.
		PHP_EOL.
		'Teema kustutamiseks kasuta seda linki:'.PHP_EOL.
		'%6%'.PHP_EOL.
		PHP_EOL.
		'Postituse lubamiseks kasuta seda linki:'.PHP_EOL.
		'%7%'.PHP_EOL.
		PHP_EOL.
		PHP_EOL.
		'Postitust näidatakse automaatselt peale %8%'.PHP_EOL.
		PHP_EOL.
		'Siirad tervitused'.PHP_EOL.
		'The '.GWF_SITENAME.' Meeskond'.PHP_EOL,

	# New Post EMail
	'submail_subj' => GWF_SITENAME.': Uus postitus',
	'submail_body' => 
		'Lugupeetud %1%'.PHP_EOL.
		PHP_EOL.
		'On %2% uut postitust '.GWF_SITENAME.' foorumis'.PHP_EOL.
		PHP_EOL.
		'Tahvel: %3%'.PHP_EOL.
		'Teema: %4%'.PHP_EOL.
		PHP_EOL.
		'<hr/>'.PHP_EOL.
		PHP_EOL.
		'%5%'.PHP_EOL. # Multiple msgs possible
		PHP_EOL.
		PHP_EOL.
		'Et lahkuda sellest teemast, vajuta sellele lingile:'.PHP_EOL.
		'%6%'.PHP_EOL.
		PHP_EOL.
		'Et lahkuda kogu tahvlist, vajuta sellele lingile:'.PHP_EOL.
		'%7%'.PHP_EOL.
		PHP_EOL.
		'Siirad tervitused'.PHP_EOL.
		'The '.GWF_SITENAME.' Meeskond'.PHP_EOL,
		
	'submail_body_part' =>  # that`s the %5% above
		'Kellelt: %1%'.PHP_EOL.
		'Pealkiri: %2%'.PHP_EOL.
		'Sõnum:'.PHP_EOL.
		'%3%'.PHP_EOL.
		PHP_EOL.
		'<hr/>'.PHP_EOL.
		PHP_EOL,
		
	# v2.01 (last seen)
	'last_seen' => 'Viimati nähtud: %1%',

	# v2.02 (Mark all read)
	'btn_mark_read' => 'Märgi kõik loetuks',
	'msg_mark_aread' => 'Märgi %1% teemat loetuks.',

	# v2.03 (Merge)
	'msg_merged' => 'Teemad on märgistatud.',
	'th_viewcount' => 'Vaatamisi',

	# v2.04 (Polls)
	'ft_add_poll' => 'Määra oma teema',
	'btn_assign' => 'Määra',
	'btn_polls' => 'Hääletused',
	'btn_add_poll' => 'Lisa hääletus',
	'msg_poll_assigned' => 'Sinu hääletuse määramine õnnestus.',
	'err_poll' => 'Hääletust ei leitud.',
	'th_thread_pollid' => 'Sinu hääletus',
	'pi_poll_add' => 'Siin sa saad määrata oma hääletuse oma teemadele või luua uus teema.<br/>Peale tegemist pead sa siin oma hääletuse uuesti teemale määrama.',
	'sel_poll' => 'Märgi üks hääletus',
		
	# v2.05 (refinish)
	'th_hidden' => 'Varjatud?',
	'th_thread_viewcount' => 'Vaatamisi',
	'th_unread_again' => 'Märgi uuesti mitteloetuks?',
	'cfg_doublepost' => 'Luba tõsmised/topeltpostitused?',
	'cfg_watch_timeout' => 'Märgi teema vaadatuks N sekundiks',
	'th_guest_view' => 'Külalistele nähtav?',
	'pt_history' => 'Foorumi ajalugu - lehekülg %1% / %2%',
	'btn_unread' => 'Uued teemad',
		
	# v2.06 (Admin Area)
	'th_approve' => 'Kiida heaks',
	'th_delete' => 'Kustuta',

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
);
?>