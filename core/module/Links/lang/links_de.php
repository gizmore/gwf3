<?php

$lang = array(
	# Admin Config
	'cfg_link_guests' => 'Gästen erlauben, Links hinzuzufügen?',
	'cfg_link_guests_captcha' => 'Captcha für Gäste anzeigen?',
	'cfg_link_guests_mod' => 'Links von Gästen moderieren?',
	'cfg_link_guests_votes' => 'Bewertungen von Gästen erlauben?',
	'cfg_link_long_descr' => '2./längere Beschreibung benutzen?',
	'cfg_link_cost' => 'Benötigte Punktzahl pro Link',
	'cfg_link_max_descr2_len' => 'Max. Länge für 2. Beschr.',
	'cfg_link_max_descr_len' => 'Max. Länge für Kurzbeschr.',
	'cfg_link_max_tag_len' => 'Maximale Tag-Länge',
	'cfg_link_max_url_len' => 'Maximale URL-Länge',
	'cfg_link_min_descr2_len' => 'Min. Länge 2. Beschreibung',
	'cfg_link_min_descr_len' => 'Min. Länge Kurzbeschreibung',
	'cfg_link_min_level' => 'Minimales Level, um Link hinzuzufügen',
	'cfg_link_per_page' => 'Links pro Seite',
	'cfg_link_tag_min_level' => 'Minimales Level, um Tag hinzuzufügen',
	'cfg_link_vote_max' => 'Maximale Bewertung',
	'cfg_link_vote_min' => 'Minimale Bewertung',
	'cfg_link_guests_unread' => 'Dauer, für die ein Link für Gäste als neu erscheint.',
	
	# Info`s
//	'pi_links' => '',
	'info_tag' => 'Mindestens einen Tag angeben. Tags mit Kommas abtrennen. Liste bestehender Tags:',
	'info_newlinks' => 'Es gibt %s neue Links für dich.',
	'info_search_exceed' => 'Die Sucher ergab zu viele Treffer (maximal %s).',

	# Titles
	'ft_add' => 'Link hinzufügen',
	'ft_edit' => 'Link bearbeiten',
	'ft_search' => 'Links durchsuchen',
	'pt_links' => 'Alle Links',
	'pt_linksec' => '%s Links ',
	'pt_new_links' => 'Neue Links',
	'mt_links' => GWF_SITENAME.', Link, Liste, Alle Links',
	'md_links' => 'Alle Links auf '.GWF_SITENAME.'.',
	'mt_linksec' => GWF_SITENAME.', Link, Liste, Links über %s',
	'md_linksec' => '%s Links auf '.GWF_SITENAME.'.',

	# Errors
	'err_gid' => 'Die Nutzergruppe ist ungültig.',
	'err_score' => 'Ungültige Punktzahl angegeben.',
	'err_no_tag' => 'Bitte mindestens einen Tag angeben.',
	'err_tag' => 'Das Tag %s ist ungültig und wurde entfernt. Das Tag muss zwischen %s und %s Zeichen lang sein.',
	'err_url' => 'Die URL entspricht offenbar nicht dem üblichen Schema.',
	'err_url_dup' => 'Die URL gibt es hier schon.',
	'err_url_down' => 'Die URL kann nicht aufgerufen werden.',
	'err_url_long' => 'Deine URL ist zu lang. Maximum sind %s Zeichen.',
	'err_descr1_short' => 'Deine Beschreibung ist zu kurz. Minimum sind %s Zeichen.',
	'err_descr1_long' => 'Deine Beschreibung ist zu lang. Maximum sind %s Zeichen.',
	'err_descr2_short' => 'Deine ausführliche Beschreibung ist zu kurz. Minimum sind %s Zeichen.',
	'err_descr2_long' => 'Deine ausführliche Beschreibung ist zu lang. Maximum sind %s Zeichen.',
	'err_link' => 'Link konnte nicht gefunden werden.',
	'err_add_perm' => 'Du darfst keinen Link hinzufügen.',
	'err_edit_perm' => 'Du darfst diesen Link nicht bearbeiten.',
	'err_view_perm' => 'Du darfst diesen Link nicht ansehen.',
	'err_add_tags' => 'Du darfst keine Tags hinzufügen',
	'err_score_tag' => 'Dein Benutzerlevel (%s) ist zu gering, um einen weiteren Tag hinzuzufügen. Benötigter Level ist %s.',
	'err_score_link' => 'Dein Benutzerlevel (%s) ist zu gering, um einen weiteren Link hinzuzufügen. Benötigter Level ist %s.',
	'err_approved' => 'Der Link wurde bereits akzeptiert. Bitte benutze die Moderationssektion um Änderungen durchzuführen.',
	'err_token' => 'Das Token ist ungültig.',

	# Messages
//	'msg_redirecting' => 'Du wirst auf %s umgeleitet.',
	'msg_added' => 'Dein Link wurde der Datenbank hinzugefügt.',
	'msg_added_mod' => 'Dein Link wurde der Datenbank hinzugefügt, jedoch muss dieser noch von einem Moderator geprüft werden.',
	'msg_edited' => 'Der Link wurde bearbeitet.',
	'msg_approved' => 'Der Link wurde akzeptiert und wird nun angezeigt.',
	'msg_deleted' => 'Der Link wurde gelöscht.',
	'msg_counted_visit' => 'Dein Klick wurde gezählt.',
	'msg_marked_all_read' => 'Alle Links als gelesen markiert.',
	'msg_fav_no' => 'Der Link wurde von deinen Favoriten entfernt.',
	'msg_fav_yes' => 'Der Link wurde deinen Favoriten hinzugefügt.',

	# Table Headers
	'th_link_score' => 'Punktzahl',
	'th_link_gid' => 'Gruppe',
	'th_link_tags' => 'Tags ',
	'th_link_href' => 'HREF ', // ?
	'th_link_descr' => 'Beschreibung',
	'th_link_descr2' => 'ausführliche Beschreibung',
	'th_link_options&1' => 'Sticky? ',
	'th_link_options&2' => 'In Moderation? ',
	'th_link_options&4' => 'Nicknamen verbergen?',
	'th_link_options&8' => 'Nur für Mitglieder sichtbar?',
	'th_link_options&16' => 'Ist der Link privat?',
	'th_link_id' => 'ID ',
	'th_showtext' => 'Link ',
	'th_favs' => 'FavCount',
	'th_link_clicks' => 'Besuche',
	'th_vs_avg' => 'Durchschnitt',
	'th_vs_sum' => 'Summe',
	'th_vs_count' => 'Bewertungen',
	'th_vote' => 'Bewerten',
	'th_link_date' => 'Datum einfügen',
	'th_user_name' => 'Nickname',

	# Tooltips
	'tt_link_gid' => 'Link auf Nutzergruppe beschränken (oder leer lassen)',
	'tt_link_score' => 'Minimale Punktzahl angeben (0-NNNN)',
	'tt_link_href' => 'Volle URL angeben, mit einleitendem http://',

	# Buttons
	'btn_add' => 'Link hinzufügen',
	'btn_delete' => 'Link entfernen',
	'btn_edit' => 'Link bearbeiten',
	'btn_search' => 'Suchen',
	'btn_preview' => 'Vorschau',
	'btn_new_links' => 'Neue Links',
	'btn_mark_read' => 'Alle als gelesen markieren',
	'btn_favorite' => 'Als Favorit markieren',
	'btn_un_favorite' => 'Als Nicht-Favorit markieren', // alternativ: Aus Favoriten entfernen (?)
	'btn_search_adv' => 'Erweiterte Suche',

	# Staff EMail
	'mail_subj' => GWF_SITENAME.': Neuer Link',
	'mail_body' =>
		'Lieber Moderator,'.PHP_EOL.
		PHP_EOL.
		'Von einem Gast wurde ein Link hinzugefügt, welcher noch moderiert werden muss:'.PHP_EOL.
		PHP_EOL.
		'Beschreibung: %s'.PHP_EOL.
		'erw. Beschr.: %s'.PHP_EOL.
		'HREF / URL  : %s'.PHP_EOL.
		PHP_EOL.
		'Du kannst diesen Link entweder'.PHP_EOL.
		'1) mit einem Klick auf %s akzeptieren'.PHP_EOL.
		'oder'.PHP_EOL.
		'2) mit einem Klick auf %s löschen.'.PHP_EOL.
		PHP_EOL.
		'Mit freundlichen Grüßen,'.PHP_EOL.
		'Das '.GWF_SITENAME.'-Skript'.PHP_EOL,
		
	# v2.01 (SEO)
	'pt_search' => 'Links durchsuchen',
	'md_search' => 'Links auf '.GWF_SITENAME.' durchsuchen.',
	'mt_search' => 'Suche,'.GWF_SITENAME.',Links',
		
	# v2.02 (permitted)
	'permtext_in_mod' => 'Dieser Link ist in der Moderationsphase',
	'permtext_score' => 'Du brauchst einen Benutzerlevel von %s, um diesen Link ansehen zu können',
	'permtext_member' => 'Dieser Link ist nur für Mitglieder sichtbar',
	'permtext_group' => 'Du musst in Gruppe %s sein, um diesen Link ansehen zu können',
	'cfg_show_permitted' => 'Zeige Begründung für verweigerte Links?',
		
);
?>