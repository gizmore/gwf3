<?php

$lang = array(
	
	# Messages
	'msg_news_added' => 'Die Nachrichten wurden hinzugefügt.',
	'msg_translated' => 'Sie haben die Nachricht \'%s\' in die Sprache %s übersetzt.',
	'msg_edited' => 'Die Nachricht \'%s\' in %s wurde bearbeitet.',
	'msg_hidden_1' => 'Die Nachricht ist nun versteckt.',
	'msg_hidden_0' => 'Die Nachricht ist nun sichtbar.',
	'msg_mailme_1' => 'Die Nachricht wurde in den mail-queue verschoben.',
	'msg_mailme_0' => 'Die Nachricht wurde aus dem mail-queue entfernt.',
	'msg_signed' => 'Sie haben den Newsletter abonniert.',
	'msg_unsigned' => 'Sie haben den Newsletter abbestellt.',
	'msg_changed_type' => 'Sie haben das Format ihres Newsletters geändert.',
	'msg_changed_lang' => 'Sie haben die bevorzugte Sprache ihres Newsletters geändert.',

	# Errors
	'err_email' => 'Ihre EMail ist ungültig.',
	'err_news' => 'Diese Nachricht ist unbekannt.',
	'err_title_too_short' => 'Der Titel ist zu kurz.',
	'err_msg_too_short' => 'Die Nachricht ist zu kurz.',
	'err_langtrans' => 'Diese Sprache wird nicht unterstützt.',
	'err_lang_src' => 'Die Original-Sprache ist unbekannt.',
	'err_lang_dest' => 'Die Ziel-Sprache ist unbekannt.',
	'err_equal_translang' => 'Die Quell und Ziel-Sprache sind gleich (%s).',
	'err_type' => 'Das Newsletter Format ist ungültig.',
	'err_unsign' => 'Ein Fehler ist aufgetreten.',


	# Main
	'title' => 'Neuigkeiten',
	'pt_news' => 'Neuigkeiten vom %s',
	'mt_news' => 'News, Neuigkeiten, '.GWF_SITENAME.', %s',
	'md_news' => 'Neues auf '.GWF_SITENAME.'. Seite %s von %s.',

	# Table Headers
	'th_email' => 'Ihre EMail',
	'th_type' => 'Newsletter Format',
	'th_langid' => 'Bevorzugte Sprache',
	'th_category' => 'Kategorie',
	'th_title' => 'Titel',
	'th_message' => 'Nachricht',
	'th_date' => 'Datum',
	'th_userid' => 'Benutzer',
	'th_catid' => 'Kategorie',
	'th_newsletter' => 'Als Newsletter senden.<br/>Bitte 2x prüfen und Vorschau ausführen!',

	# Preview
	'btn_preview_text' => 'als Text Version',
	'btn_preview_html' => 'als HTML Version',
	'preview_info' => 'Sie können die Vorschau hier ansehen:<br/>%s und %s.',

	# Show 
	'unknown_user' => 'Unbekannter Nutzer',
	'title_no_news' => '-----',
	'msg_no_news' => 'Es gibt keine neuen Nachrichten in dieser Kategorie.',

	# Newsletter
	'newsletter_title' => GWF_SITENAME.': Newsletter',
	'anrede' => 'Hallo %s',
	'newsletter_wrap' =>
		'%s, '.PHP_EOL.
		PHP_EOL.
		'Du hast dich für den Newsletter auf '.GWF_SITENAME.' eingetragen, und es gibt Neuigkeiten.'.PHP_EOL.
		'Um dich vom Newsletter auszutragen, rufe folgende Seite auf:'.PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'<hr/>'.PHP_EOL.
		PHP_EOL.
		'Und hier die Neuigkeiten auf '.GWF_SITENAME.':'.PHP_EOL.
		PHP_EOL.
		'<hr/>'.PHP_EOL.
		PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'%s'.PHP_EOL,

	# Types
	'type_none' => 'Wählen sie ein Format',
	'type_text' => 'Einfacher Text (Plaintext/UTF8)',
	'type_html' => 'Einfaches HTML (xhtml/UTF8)',
		
	# Sign
	'sign_title' => 'Den Newsletter abonnieren',
	'sign_info_login' => 'Sie sind nicht angemeldet, daher können wir nicht ermitteln ob sie den Newsletter abonniert haben.',
	'sign_info_none' => 'Sie haben sich nicht für den Newsletter angemeldet.',
	'sign_info_html' => 'Sie haben den Newsletter im HTML-Format abonniert.',
	'sign_info_text' => 'Sie haben den Newsletter im Text-Format abonniert.',
	'ft_sign' => 'Den Newsletter abonnieren',
	'btn_sign' => 'Newsletter abonnieren',
	'btn_unsign' => 'Newsletter abbestellen',
		
	# Edit
	'ft_edit' => 'News Bearbeiten (Sprache: %s)',
	'btn_edit' => 'Speichern',
	'btn_translate' => 'Übersetzen',
	'th_transid' => 'Übersetzung',
	'th_mail_me' => 'Als Newsletter senden',
	'th_hidden' => 'Versteckt?',

	# Add
	'ft_add' => 'Neue Nachricht hinzufügen',
	'btn_add' => 'Nachricht Hinzufügen',
	'btn_preview' => 'Vorschau (BITTE!)',
		
	# Admin Config
	'cfg_newsletter_guests' => 'Gästen erlaueben den Newsletter zu abonnieren',
	'cfg_news_per_adminpage' => 'Nachrichten pro Admin Seite',
	'cfg_news_per_box' => 'Nachrichte für Inline-Box',
	'cfg_news_per_page' => 'Nachrichten pro Seite',
	'cfg_newsletter_mail' => 'Nachrichten E-Mail sender',
	'cfg_newsletter_sleep' => 'Nach jeder mail N ms schlafen',
	'cfg_news_per_feed' => 'Nachrichten pro RSS Feed Seite',
	
	# RSS2 Feed
	'rss_title' => GWF_SITENAME.' Nachrichten Feed',
		
	# V2.03 (News + Forum)
	'cfg_news_in_forum' => 'Nachrichten ins Forum posten',
	'board_lang_descr' => 'Nachrichten in %s',
	'btn_admin_section' => 'Admin Bereich',
	'th_hidden' => 'Versteckt?',
	'th_visible' => 'Sichtbar?',
	'btn_forum' => 'Im Forum diskutieren',
		
	# V3.00 (fixes)
	'rss_img_title' => GWF_SITENAME.'  Logo',
	'cfg_news_comments' => 'Kommentare aktivieren',
		
	# v3.01 (deletion)
	'msg_deleted' => 'Die News wurde als gelöscht markiert.',
	'err_newsid' => 'Der newsid Parameter wird erwarten.',
);
