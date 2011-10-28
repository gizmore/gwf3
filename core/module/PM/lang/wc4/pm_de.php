<?php

$lang = array(
	'hello' => 'Hallo %1$s',
	'sel_username' => 'Wählen sie einen Benutzer',
	'sel_folder' => 'Wählen sie einen Ordner',

	# Info
	'pt_guest' => GWF_SITENAME.' Gäste PN',
	'pi_guest' => 'Auf '.GWF_SITENAME.' können sie auch als Gast eine PN senden. Der Benutzer muss dies explizit erlauben, ausserdem kann er ihnen keine Antwort schreiben. Dennoch kann es benutzt werden um schnell einen Fehler zu melden.',

	'pi_trashcan' => 'Hier ist ihr PN-Papierkorb. Nachrichten können nicht wirklich gelöscht werden. Sie können aber Nachrichten aus dem Papierkorb wiederherstellen.',
	
	# Buttons
	'btn_ignore' => '%1$s ignorieren',
	'btn_ignore2' => 'Ignorieren',
	'btn_save' => 'Einstellungen Speichern',
	'btn_create' => 'Neue PN',
	'btn_preview' => 'Vorschau',
	'btn_send' => 'Senden',
	'btn_delete' => 'Löschen',
	'btn_restore' => 'Wiederherstellen',
	'btn_edit' => 'Bearbeiten',
	'btn_autofolder' => 'Automatisch sortieren',
	'btn_reply' => 'Antworten',
	'btn_quote' => 'Zitieren',
	'btn_options' => 'PN Einstellungen',
	'btn_search' => 'Suchen',
	'btn_trashcan' => 'Ihr Mülleimer',
	'btn_auto_folder' => 'In automatische Ordner sortieren',

	# Errors
	'err_pm' => 'Diese Nachricht existiert nicht.',
	'err_perm_read' => 'Sie dürfen diese Nachricht nicht lesen.',
	'err_perm_write' => 'Sie dürfen diese Nachricht nicht bearbeiten.',
	'err_no_title' => 'Sie haben den Titel vergessen.',
	'err_title_len' => 'Ihr Titel ist zu lang. Maximal erlaubt sind %1$s Zeichen.',
	'err_no_msg' => 'Sie haben die Nachricht vergessen.',
	'err_sig_len' => 'Ihre Signatur ist zu lang. Maximal erlaubt sind %1$s Zeichen.',
	'err_msg_len' => 'Ihre Nachricht ist zu lang. Maximal erlaubt sind %1$s Zeichen.',
	'err_user_no_ppm' => 'Dieser Nutzer möchte keine Gäste-PN.',
	'err_no_mail' => 'Sie haben keine bestätigte EMail für dieses Konto angegeben.',
	'err_pmoaf' => 'Der Wert für automatische Ordner ist ungültig.',
	'err_limit' => 'Sie haben ihr PN Limit für heute erreicht. Sie können maximal %1$s Nachricht(en) innerhalb von %2$s senden.',

	'err_ignored' => '%1$s ignoriert sie.',
	'err_delete' => 'Ein Fehler trat beim löschen ihrer PN auf.',
	'err_folder_exists' => 'Dieser Ordner existiert bereits.',
	'err_folder_len' => 'Der Name des Ordners muss zwischen einem und %1$s Zeichen lang sein.',
	'err_del_twice' => 'Sie haben diese PN bereits gelöscht.',
	'err_folder' => 'Der Ordner ist unbekannt.',
	'err_pm_read' => 'Ihre Nachricht wurde bereits gelesen. Sie können diese nun nicht mehr ändern.',

	# Messages
	'msg_sent' => 'Ihre Nachricht wurde erfolgreich gesendet. Sie können diese immer noch bearbeiten, bis sie gelesen wurde.',
	'msg_ignored' => 'Sie ignorieren ab sofort Nachrichten von %1$s.',
	'msg_unignored' => 'Sie erlauben nun wieder Nachrichten von %1$s.',
	'msg_changed' => 'Ihre Einstellungen wurden gespeichert.',
	'msg_deleted' => 'Es wurde(n) %1$s Nachricht(en) als gelöscht markiert.',
	'msg_moved' => 'Es wurde(n) %1$s Nachricht(en) verschoben.',
	'msg_edited' => 'Ihre Nachricht wurde geändert.',
	'msg_restored' => 'Es wurde(n) %1$s Nachricht(en) wiederhergestellt.',
	'msg_auto_folder_off' => 'Sie haben keine Automatischen Ordner aktiviert. Die PN wurde(n) als gelesen markiert.',
	'msg_auto_folder_none' => 'Es existieren nur %1$s PN mit diesem Benutzer. Es wurde(n) keine Nachricht(en) verschoben. Die Nachricht(en) wurde als gelesen markiert.',
	'msg_auto_folder_created' => 'Es wurde der Ordner %1$s erstellt.',
	'msg_auto_folder_moved' => 'Es wurden %1$s Nachricht(en) nach %2$s verschoben. Die Nachrichten wurden als gelesen markiert.',
	'msg_auto_folder_done' => 'Automatische Ordner Sortierung wurde ausgeführt.',


	# Titles
	'ft_create' => 'Eine neue Nachricht an %1$s verfassen',
	'ft_preview' => 'Vorschau',
	'ft_options' => 'Ihre PN Einstellungen',
	'ft_ignore' => 'Jemanden Ignorieren',
	'ft_new_pm' => 'Neue Nachricht verfassen',
	'ft_reply' => 'Antwort an %1$s',
	'ft_edit' => 'Nachricht bearbeiten',
	'ft_quicksearch' => 'Schnellsuche',
	'ft_advsearch' => 'Erweiterte Suchfunktion',

	# Tooltips
	'tt_pmo_auto_folder' => 'Wenn dir ein Benutzer diese Anzahl Nachrichten schreibt wird automatisch ein Ordner für diesen Benutzer erzeugt, und PN mit diesem Nutzer wird automatisch dorthin verschoben.',

	
	# Table Headers
	'th_pmo_options&1' => 'Sende mir EMail für neue PN',
	'th_pmo_options&2' => 'Gästen erlauben mir PN zu senden',
	'th_pmo_auto_folder' => 'Einzelne Benutzerordner nach N Nachrichten erzeugen',
	'th_pmo_signature' => 'Ihre PN Signatur',

	'th_pm_options&1' => 'Neu',
	'th_actions' => ' ',
	'th_user_name' => 'Benutzer',
	'th_pmf_name' => 'Ordner',
	'th_pmf_count' => 'Anzahl',
	'th_pm_id' => 'ID ',
	'th_pm_to' => 'An',
	'th_pm_from' => 'Von',
//	'th_pm_to_folder' => 'To Folder',
//	'th_pm_from_folder' => 'From Folder',
	'th_pm_date' => 'Datum',
	'th_pm_title' => 'Titel',
	'th_pm_message' => 'Nachricht',
//	'th_pm_options' => 'Einstellungen',

	# Welcome PM
//	'wpm_title' => 'Willkommen auf '.GWF_SITENAME,
//	'wpm_message' => 
//		'Hallo %1$s'.PHP_EOL.
//		PHP_EOL.
//		'Willkommen auf '.GWF_SITENAME.''.PHP_EOL.
//		PHP_EOL.
//		'Wir hoffen du magst unsere Webseite und hast Spaß damit.'.PHP_EOL,
		
	# New PM Email
	'mail_subj' => GWF_SITENAME.': PN von %1$s',
	'mail_body' =>
		'Hallo %1$s'.PHP_EOL.
		PHP_EOL.
		'Es gibt eine neue private Nachricht für dich auf '.GWF_SITENAME.'.'.PHP_EOL.
		PHP_EOL.
		'Von: %2$s'.PHP_EOL.
		'Titel: %3$s'.PHP_EOL.
		PHP_EOL.
		'%4$s'.PHP_EOL.
		PHP_EOL.
		PHP_EOL.
		'--------------------------------------------------------------------------'.
		PHP_EOL.
		PHP_EOL.
		'Du kannst sofort...'.PHP_EOL.
		'Diese Nachricht automatisch einsortieren:'.PHP_EOL.
		'%5$s'.PHP_EOL.
		PHP_EOL.
		'Diese Nachricht löschen:'.PHP_EOL.
		'%6$s'.PHP_EOL.
		PHP_EOL.
		'Hochachtungsvoll,'.PHP_EOL.
		'Das '.GWF_SITENAME.' Script'.PHP_EOL,
		
	# Admin Config
	'cfg_pm_captcha' => 'Gäste-CAPTCHA?',
	'cfg_pm_causes_mail' => 'EMail on PN erlauben?',
	'cfg_pm_for_guests' => 'Gäste PN erlauben?',
	'cfg_pm_welcome' => 'Willkommens-PN senden?',
	'cfg_pm_limit' => 'Maximale PN (Anzahl)',
	'cfg_pm_maxfolders' => 'Maximale Anzahl Ordner pro Nutzer',
	'cfg_pm_msg_len' => 'Maximale Länge einer Nachricht',
	'cfg_pm_per_page' => 'PN pro Seite',
	'cfg_pm_sig_len' => 'Maximale Länge einer Signatur',
	'cfg_pm_title_len' => 'Maximal Länge eines Titels',
	'cfg_pm_bot_uid' => 'Willkommen PN - UID des Senders',
	'cfg_pm_sent' => 'PN Sende Zähler',
	'cfg_pm_mail_sender' => 'SenderEMail bei EMail nach PN',
	'cfg_pm_re' => 'Titel voranstellung (RE: )',
	'cfg_pm_limit_timeout' => 'Maximale PN (Zeitraum)',
	'cfg_pm_fname_len' => 'Maximale Länge eines Ordnernamens',
	
	# v2.01
	'err_ignore_admin' => 'Sie können keine Administratoren ignorieren.',
	'btn_new_folder' => 'Neuer Ordner',
		
	# v2.02
	'msg_mail_sent' => 'Eine EMail mit ihrer Original Nachricht wurde an %1$s gesendet.',
		
	# v2.03 SEO
	'pt_pm' => 'PN',
		
	# v2.04 fixes
	'ft_new_folder' => 'Einen neuen Ordner erstellen',

	# v2.05 (prev+next)
	'btn_prev' => 'Vorherige Nachricht',
	'btn_next' => 'Nächste Nachricht',
		
	# v2.06 (icon titles+bots)
	'gwf_pm_deleted' => 'Der Empfänger hat diese Nachricht gelöscht.',
	'gwf_pm_read' => 'Der Empfänger hat diese Nachricht gelesen.',
	'gwf_pm_unread' => 'Die Nachricht ist ungelesen.',
	'gwf_pm_old' => 'Gelesene Nachricht.',
	'gwf_pm_new' => 'Neue PN für sie.',
	'err_bot' => 'Roboter dürfen keine PN senden.',

	# v2.07 (fixes)
	'err_ignore_self' => 'Sie können sich nicht selbst ignorieren.',
	'err_folder_perm' => 'Dieser Ordner gehört Ihnen nicht.',
	'msg_folder_deleted' => 'Der Ordner %1$s und %2$s Nachricht(en) wurde(n) in den Papierkorb verschoben.',
	'cfg_pm_delete' => 'Löschend von PN erlauben?',
	'ft_empty' => 'Den Papierkorb leeren',
	'msg_empty' => 'Ihr Papierkorb (%1$s Nachricht(en)) wurde aufgeräumt.<br/>%2$s Nachricht(en) wurde(n) aus der Datenbank gelöscht.<br/>%3$s Nachricht(en) konnten nicht gelöscht werden, da der Gegenüber die Nachricht noch archiviert hat.',
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