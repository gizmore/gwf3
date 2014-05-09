<?php
$lang = array(
	'hello' => 'Hallo %s',
	'sel_username' => 'Wählen Sie einen Benutzer',
	'sel_folder' => 'Wählen Sie einen Ordner',

	# Info
	'pt_guest' => GWF_SITENAME.' Gäste PN',
	'pi_guest' => 'Auf '.GWF_SITENAME.' können Sie auch als Gast eine PN senden. Der Benutzer muss dies explizit erlauben, außerdem kann er Ihnen keine Antwort schreiben. Dennoch kann es benutzt werden um schnell einen Fehler zu melden.',

	'pi_trashcan' => 'Hier ist ihr PN-Papierkorb. Nachrichten können nicht wirklich gelöscht werden. Sie können aber Nachrichten aus dem Papierkorb wiederherstellen.',
	
	# Buttons
	'btn_ignore' => '%s ignorieren',
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
	'err_title_len' => 'Ihr Titel ist zu lang. Maximal erlaubt sind %s Zeichen.',
	'err_no_msg' => 'Sie haben die Nachricht vergessen.',
	'err_sig_len' => 'Ihre Signatur ist zu lang. Maximal erlaubt sind %s Zeichen.',
	'err_msg_len' => 'Ihre Nachricht ist zu lang. Maximal erlaubt sind %s Zeichen.',
	'err_user_no_ppm' => 'Dieser Nutzer möchte keine Gäste-PN.',
	'err_no_mail' => 'Sie haben keine bestätigte EMail für dieses Konto angegeben.',
	'err_pmoaf' => 'Der Wert für automatische Ordner ist ungültig.',
	'err_limit' => 'Sie haben ihr PN Limit für heute erreicht. Sie können maximal %s Nachricht(en) innerhalb von %s senden.',

	'err_ignored' => '%s ignoriert sie.<br/>%s',
	'err_delete' => 'Ein Fehler trat beim löschen ihrer PN auf.',
	'err_folder_exists' => 'Dieser Ordner existiert bereits.',
	'err_folder_len' => 'Der Name des Ordners muss zwischen einem und %s Zeichen lang sein.',
	'err_del_twice' => 'Sie haben diese PN bereits gelöscht.',
	'err_folder' => 'Der Ordner ist unbekannt.',
	'err_pm_read' => 'Ihre Nachricht wurde bereits gelesen. Sie können diese nun nicht mehr ändern.',

	# Messages
	'msg_sent' => 'Ihre Nachricht wurde erfolgreich gesendet. Sie können diese immer noch bearbeiten, bis sie gelesen wurde.',
	'msg_ignored' => 'Sie ignorieren ab sofort Nachrichten von %s.',
	'msg_unignored' => 'Sie erlauben nun wieder Nachrichten von %s.',
	'msg_changed' => 'Ihre Einstellungen wurden gespeichert.',
	'msg_deleted' => 'Es wurde(n) %s Nachricht(en) als gelöscht markiert.',
	'msg_moved' => 'Es wurde(n) %s Nachricht(en) verschoben.',
	'msg_edited' => 'Ihre Nachricht wurde geändert.',
	'msg_restored' => 'Es wurde(n) %s Nachricht(en) wiederhergestellt.',
	'msg_auto_folder_off' => 'Sie haben keine Automatischen Ordner aktiviert. Die PN wurde(n) als gelesen markiert.',
	'msg_auto_folder_none' => 'Es existieren nur %s PN mit diesem Benutzer. Es wurde(n) keine Nachricht(en) verschoben. Die Nachricht(en) wurde als gelesen markiert.',
	'msg_auto_folder_created' => 'Es wurde der Ordner %s erstellt.',
	'msg_auto_folder_moved' => 'Es wurden %s Nachricht(en) nach %s verschoben. Die Nachrichten wurden als gelesen markiert.',
	'msg_auto_folder_done' => 'Automatische Ordner Sortierung wurde ausgeführt.',


	# Titles
	'ft_create' => 'Eine neue Nachricht an %s verfassen',
	'ft_preview' => 'Vorschau',
	'ft_options' => 'Ihre PN Einstellungen',
	'ft_ignore' => 'Jemanden Ignorieren',
	'ft_new_pm' => 'Neue Nachricht verfassen',
	'ft_reply' => 'Antwort an %s',
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
	'wpm_title' => 'Willkommen auf '.GWF_SITENAME,
	'wpm_message' => 
		'Hallo %s'.PHP_EOL.
		PHP_EOL.
		'Willkommen auf '.GWF_SITENAME.''.PHP_EOL.
		PHP_EOL.
		'Wir hoffen du magst unsere Webseite und hast Spaß damit.'.PHP_EOL,
		
	# New PM Email
	'mail_subj' => GWF_SITENAME.': PN von %s',
	'mail_body' =>
		'Hallo %s'.PHP_EOL.
		PHP_EOL.
		'Es gibt eine neue private Nachricht für dich auf '.GWF_SITENAME.'.'.PHP_EOL.
		PHP_EOL.
		'Von: %s'.PHP_EOL.
		'Titel: %s'.PHP_EOL.
		PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		PHP_EOL.
		'--------------------------------------------------------------------------'.
		PHP_EOL.
		PHP_EOL.
		'Du kannst sofort...'.PHP_EOL.
		'Diese Nachricht automatisch einsortieren:'.PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'Diese Nachricht löschen:'.PHP_EOL.
		'%s'.PHP_EOL.
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
	'msg_mail_sent' => 'Eine EMail mit ihrer Original Nachricht wurde an %s gesendet.',
		
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
	'msg_folder_deleted' => 'Der Ordner %s und %s Nachricht(en) wurde(n) in den Papierkorb verschoben.',
	'cfg_pm_delete' => 'Löschend von PN erlauben?',
	'ft_empty' => 'Den Papierkorb leeren',
	'msg_empty' => 'Ihr Papierkorb (%s Nachricht(en)) wurde aufgeräumt.<br/>%s Nachricht(en) wurde(n) aus der Datenbank gelöscht.<br/>%s Nachricht(en) konnten nicht gelöscht werden, da der Gegenüber die Nachricht noch archiviert hat.',

	# v2.08 (GT)
	'btn_translate' => 'Translate with Google',

	# monnino fixes
	'cfg_pm_limit_per_level' => 'Benötigter Level pro PM',
	'cfg_pm_own_bot' => 'Eigener PM Bot',
	'th_reason' => 'Grund',

	# v2.09 (pmo_level)
	'err_user_pmo_level' => 'This user requires you to have a userlevel of %s to send him PM.',
	'th_pmo_level' => 'Min userlevel of sender',
	'tt_pmo_level' => 'Set a minimal userlevel requirement to allow to send you PM',
);
