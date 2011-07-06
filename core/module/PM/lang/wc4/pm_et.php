<?php

$lang = array(
	'hello' => 'Tervist %1%',
	'sel_username' => 'Vali kasutajanimi',
	'sel_folder' => 'Vali kaust',

	# Info
	'pt_guest' => GWF_SITENAME.' Külalise privaatsõnum',
	'pi_guest' => GWF_SITENAME.' lehel on samuti võimalik saata PS (privaatsõnum) ilma, et oleksite sisse loginud, kuid seljuhul pole võimalik teile tagasi saata sõnumit. See on aga selleks nii, et kiirelt edastada teade vea kohta.',
	'pi_trashcan' => 'See on sinu Prügikast, sa ei saa tegelikult sõnumeid kustutada, kuid saad neid taastada.',
	
	# Buttons
	'btn_ignore' => 'Pane %1% oma Block-listi',
	'btn_ignore2' => 'Ignoreeri',
	'btn_save' => 'Salvestamise seaded',
	'btn_create' => 'Uus PS',
	'btn_preview' => 'Eelvaade',
	'btn_send' => 'Saada PS',
	'btn_delete' => 'Kustuta',
	'btn_restore' => 'Taasta',
	'btn_edit' => 'Muuda',
	'btn_autofolder' => 'Pane auto-kaustadesse',
	'btn_reply' => 'Vasta',
	'btn_quote' => 'Tsiteeri',
	'btn_options' => 'PS seaded',
	'btn_search' => 'Otsing',
	'btn_trashcan' => 'Sinu prügikast',
	'btn_auto_folder' => 'Kaotatud PS\'d',

	# Errors
	'err_pm' => 'PS\'t ei eksisteeri.',
	'err_perm_read' => 'Pole lubatud seda PS\'i lugeda.',
	'err_perm_write' => 'Pole lubatud muuta seda PS\'i.',
	'err_no_title' => 'Unustasid PS\'i pealkirja.',
	'err_title_len' => 'Pealkiri on liiga pikk. Maksimum %1% tähte on lubatud.',
	'err_no_msg' => 'Unustasid oma sõnumi.',
	'err_sig_len' => 'Su signatuur on liiga pikk. Maksimum %1% tähte on lubatud.',
	'err_msg_len' => 'Su sõnum on liiga pikk. Maksimum %1% tähte on lubatud.',
	'err_user_no_ppm' => 'See kasutaja ei soovi teiste PS\'e.',
	'err_no_mail' => 'Sul pole heakskiidetud emaili sellel kasutajal.',
	'err_pmoaf' => 'Auto-kaustade väärtus ei ole lubatud.',
	'err_limit' => 'Su PS-limiit on käes. Sa saad saata maksimum %1% PS-i %2% jooksul.',
	'err_ignored' => '%1% on pannud sind oma block-listi.',
	'err_delete' => 'Viga avastatud sinu e-maile kustutades.',
	'err_folder_exists' => 'Kaust on juba olemas.',
	'err_folder_len' => 'Kaustanime pikkus peab olema 1 - %1% tähte',
	'err_del_twice' => 'Sa oled juba kustutanud selle PS\'i.',
	'err_folder' => 'Kaust on tundmatu.',
	'err_pm_read' => 'Sinu PS on juba saadetud, enam ei saa Sa seda muuta.',

	# Messages
	'msg_sent' => 'Su PS on edukalt saadetud. Sa saad seda muuta, kuni see pole veel loetud..',
	'msg_ignored' => 'Sa paned %1% oma ignore listi.',
	'msg_unignored' => 'Sa eemaldasid %1% oma ignore listist.',
	'msg_changed' => 'Seaded on muudetud.',
	'msg_deleted' => 'Edukalt kustutatud %1% PS\'t.',
	'msg_moved' => 'Edukalt liigutatud %1% PS\'i.',
	'msg_edited' => 'Sinu PS on muudetud.',
	'msg_restored' => 'Edukalt taastatud %1% PS\'i.',
	'msg_auto_folder_off' => 'Sul pole auto-kaustad lubatud. PS on märgitud loetuks.',
	'msg_auto_folder_none' => 'On ainult %1% sõnumeid sellelt/le kasutajalt/le. Midagi pole liigutatud. PS on märgitud loetuks.',
	'msg_auto_folder_created' => 'Loodud kaust %1%.',
	'msg_auto_folder_moved' => 'Liigutatud %1% sõnumi(d) kausta %2%. PS(\'id) on märgitud loetuks.',
	'msg_auto_folder_done' => 'Auto-kaustad tehtud.',


	# Titles
	'ft_create' => 'Kirjuta %1% uus PS',
	'ft_preview' => 'Eelvaade',
	'ft_options' => 'Sinu PS seaded',
	'ft_ignore' => 'Lisa kedagi enda ignore-listi',
	'ft_new_pm' => 'Kirjuta uus PS',
	'ft_reply' => 'Vasta %1%',
	'ft_edit' => 'Muuda oma PS',
	'ft_quicksearch' => 'Kiirotsing',
	'ft_advsearch' => 'Tavaotsing',

	# Tooltips
	'tt_pmo_auto_folder' => 'Kui üksainus kasutaja saadab sulle nii palju sõnumeid, siis ta sõnumite jaoks loodakse eraldi kaust automaatselt.',
	
	# Table Headers
	'th_pmo_options&1' => 'Saada mulle email, kui on uusi PS\'e',
	'th_pmo_options&2' => 'Luba külalistel mulle PS\'e saata',
	'th_pmo_auto_folder' => 'Loo kasutajate kaustad pärast nende PS\'e',
	'th_pmo_signature' => 'Sinu PS signatuur',

	'th_pm_options&1' => 'Uus',
	'th_actions' => '',
	'th_user_name' => 'Kasutajanimi',
	'th_pmf_name' => 'Kaust',
	'th_pmf_count' => 'Üldarv',
	'th_pm_id' => 'ID',
	'th_pm_to' => 'Kellele',
	'th_pm_from' => 'Kellelt',
//	'th_pm_to_folder' => 'Kausta',
//	'th_pm_from_folder' => 'Kaustast',
	'th_pm_date' => 'Kuupäev',
	'th_pm_title' => 'Pealkiri',
	'th_pm_message' => 'Sõnum',
//	'th_pm_options' => 'Seaded',

	# Welcome PM
//	'wpm_title' => 'Teretulemast '.GWF_SITENAME,
//	'wpm_message' => 
//		'Lugupeetud %1%'.PHP_EOL.
//		PHP_EOL.
//		'Teretulemast '.GWF_SITENAME.''.PHP_EOL.
//		PHP_EOL.
//		'Me loodame, et Sulle meeldib meie sait ja et Sul saab siin meeldiv olema.'.PHP_EOL,
		
	# New PM Email
	'mail_subj' => GWF_SITENAME.': Uus PS %1%',
	'mail_body' =>
		'Tervist %1%'.PHP_EOL.
		PHP_EOL.
		'Sulle on uus PS '.GWF_SITENAME.'.'.PHP_EOL.
		PHP_EOL.
		'From: %2%'.PHP_EOL.
		'Title: %3%'.PHP_EOL.
		PHP_EOL.
		'%4%'.PHP_EOL.
		PHP_EOL.
		PHP_EOL.
		'--------------------------------------------------------------------------'.
		PHP_EOL.
		PHP_EOL.
		'Sa võid kiiresti:'.PHP_EOL.
		'Auto-kausta panna sõnumi:'.PHP_EOL.
		'%5%'.PHP_EOL.
		PHP_EOL.
		'Kustutada sõnumi:'.PHP_EOL.
		'%6%'.PHP_EOL.
		PHP_EOL.
		'Parimate soovidega,'.PHP_EOL.
		'The '.GWF_SITENAME.' Robot'.PHP_EOL,
		
	# Admin Config
	'cfg_pm_captcha' => 'Kasuta captchat külalistele??',
	'cfg_pm_causes_mail' => 'Luba emaile PS-s?',
	'cfg_pm_for_guests' => 'Luba külaliste PS-e?',
	'cfg_pm_welcome' => 'Saada teretulemast-PS?',
	'cfg_pm_limit' => 'Maksimum PS-d ajalimiidi jooksul',
	'cfg_pm_maxfolders' => 'Maksimum kaustad kasutaja kohta',
	'cfg_pm_msg_len' => 'Maksimum sõnumi pikkus',
	'cfg_pm_per_page' => 'PS\'d lehe kohta',
	'cfg_pm_sig_len' => 'Maksimum signatuuri pikkus',
	'cfg_pm_title_len' => 'Maksimum pealkirja pikkus',
	'cfg_pm_bot_uid' => 'Teretulemast-PS\'i kasutaja ID',
	'cfg_pm_sent' => 'PS saatja lugeja',
	'cfg_pm_mail_sender' => 'EMail PS Saatjale',
	'cfg_pm_re' => 'Pealkiri',
	'cfg_pm_limit_timeout' => 'PS limiidi aeg käes',
	'cfg_pm_fname_len' => 'Maksimum kaustanime pikkus',
	
	# v2.01
	'err_ignore_admin' => 'Sa ei saa panna admini oma ignore-listi.',
	'btn_new_folder' => 'Uus kaust',
		
	# v2.02
	'msg_mail_sent' => 'Email on saadetud %1% sisaldades sinu esialgset sõnumit.',
		
	# v2.03 SEO
	'pt_pm' => 'PS',

	# v2.04 fixes
	'ft_new_folder' => 'Create a new folder',

	# v2.05 (prev+next)
	'btn_prev' => 'Previous message',
	'btn_next' => 'Next message',

	# v2.06 (icon titles+bots)
	'gwf_pm_deleted' => 'The other user deleted this pm.',
	'gwf_pm_read' => 'The other user has read your pm.',
	'gwf_pm_unread' => 'The other user has not read your pm yet.',
	'gwf_pm_old' => 'This pm is old for you.',
	'gwf_pm_new' => 'New pm for you.',
	'err_bot' => 'Bots are not allowed to send messages.',	

	# v2.07 (fixes)
	'err_ignore_self' => 'You can not ignore yourself.',
	'err_folder_perm' => 'This folder is not yours.',
	'msg_folder_deleted' => 'The Folder %1% and %2% message(s) got moved into the trashcan.',
	'cfg_pm_delete' => 'Allow to delete PM?',
	'ft_empty' => 'Empty your Trashcan',
	'msg_empty' => 'Your trashcan (%1% messages) has been cleaned up.<br/>%2% messages has/have been deleted from the database.<br/>%3% messages are still in use by the other user and have not been deleted.',

	# v2.08 (GT)
	'btn_translate' => 'Translate with Google',
		
	# Welcome PM
	'wpm_title' => 'Welcome to '.GWF_SITENAME,
	'wpm_message' =>
		'Dear Challenger, Welcome to WeChall.'.PHP_EOL.
		PHP_EOL.
		'The site\'s ultimate goal is to provide an universal ranking for the hacker challenge sites.'.PHP_EOL.
		'That\'s why you have to [url=/linked_sites]link your challenge site accounts[/url] to WeChall.'.PHP_EOL.
		'You can do this under Account -> Linked Sites.'.PHP_EOL.
		'There are also some [url=/challs]WeChall challenges[/url], and your account is already linked to WeChall itself.'.PHP_EOL.
		'If you like our site, don\'t forget to frequently visit it and [url=/linked_sites]update your progress[/url].'.PHP_EOL.
		'If you are new to challenge sites, feel free to ask in the Forum, we will help you.'.PHP_EOL.
		'If you have any other question or suggestion, please provide feedback to us.'.PHP_EOL.
		PHP_EOL.PHP_EOL.
		'Here are a few hints how to setup your account (press the [url=/account]Account[/url] button in menu for that):'.PHP_EOL.
		'1) It\'s about solving challenges. so solve a few riddles on the [url=/active_sites]sites[/url] and link to your account. If you encounter problems, please tell.'.PHP_EOL.
		'2) You can toggle [url=/forum/options]Forum Settings[/url], [url=/pm/options]PM Settings[/url] and [url=/profile_settings]Change profile options[/url] if you would like to allow getting contacted. All contacting is off by default.'.PHP_EOL.
		'3) [b]WeChall is capable of SSL[/b], but does not force it anywhere. However you should be able to use SSL all over the site.'.PHP_EOL.
		PHP_EOL.
		'Happy Challenging'.PHP_EOL.
		'The WeChall Team'.PHP_EOL,
);
?>