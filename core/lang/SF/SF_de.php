<?php

$lang = array(

	'link_contact' => 'Kontakt',
	'link_impress' => 'Impressum',
	'link_disclaimer' => 'Disclaimer',
	'link_sitemap' => 'Sitemap',
	'link_roadmap' => 'Roadmap',
	'link_changelog' => 'Changelog',
	'link_credits' => 'Credits',
	'link_helpdesk' => 'Report Bug',
	'link_todo' => 'TODO Liste',
	'link_project' => 'Space-Framework',
	'link_bookmark' => 'Bookmark',

	###########
	## month ##
	###########
	'monthnames' => array(
		1 => 'Januar',
		2 => 'Februar',
		3 => 'M&auml;rz',
		4 => 'April',
		5 => 'Mai',
		6 => 'Juni',
		7 => 'Juli',
		8 => 'August',
		9 => 'September',
		10 => 'Oktober',
		11 => 'November',
		12 => 'Dezember',
	),
	##########
	## days ##
	##########
	'daynames' => array(
		0 => 'Sonntag',
		1 => 'Montag',
		2 => 'Dienstag',
		3 => 'Mittwoch',
		4 => 'Donnerstag',
		5 => 'Freitag',
		6 => 'Samstag'
	),
	'days_to_weekend' => array(
		0 => "Und es ist Wochenende!!!        ",
		1 => "Noch 5 Tage bis zum Wochenende. ",
		2 => "Noch 4 Tage bis zum Wochenende. ",
		3 => "Noch 3 Tage bis zum Wochenende. ",
		4 => "Noch 2 Tage bis zum Wochenende. ",
		5 => date('G') < 13 ? "Endlich fängt das Wochenende an." : "Morgen fängt das Wochenende an! ",
		6 => "Und es ist Wochenende!!!        ",
	),
	'day' => 'Tag',
	'month' => 'Monat',
	'year' => 'Jahr',
	'hour' => 'Stunde',
	'second' => 'Sekunde',
	'minute' => 'Minute',
	'request_time' => 'Zugriffszeit',
	'space' => 'Speicher',
	'free_space' => 'Frei',
	'total_space' => 'Gesamt',
	'used_space' => 'Benutzt',
	'admin' => 'Admin',
	'mail' => 'E-Mail',
	'back' => 'Zur&uuml;ck',
	'change_language' => 'Sprache ändern',

	//SURFER INFOS
	'operating_system' => 'Betriebssystem',
	'browser' => 'Browser',
	'provider' => 'Provider',
	'referer' => 'Referer',
	'host' => 'Host',
	'hostname' => 'Hostname',
	'user_agent' => 'UserAgent',

	'country' => 'Land',
	'ip' => 'IP',
	'ipaddr' => 'IP-Adresse',
	'visitor' => 'Besucher',
	'donations' => 'Spenden',
	'server' => 'Server',
	'today' => 'Heute',
	'today_is_the' => 'Heute ist %s, der %s. %s (%s), %s.',
	'statistics' => 'Statistiken',
	'surfer_infos' => 'Surfer Infos',
	'guest' => 'Gast',
	
	'si' => array(
		'operating_system' => 'Betriebssystem: %s %s',
		'browser' => 'Browser: %s %s',
		'provider' => 'Provider: %s %s',
		'referer' => 'Referer: %s',
		'host' => 'Host: %s',
		'hostname' => 'Hostname: %s',
		'user_agent' => 'UserAgent: %s',
		'country' => 'Land: %s %s',
		'ip' => 'IP: %s',
		'ipaddr' => 'IP-Adresse: %s',
		
	),
	
	//COUNTER TODO: Array
	'ct_vis_total' => 'Besucher gesamt: %s',
	'ct_vis_today' => 'Besucher heute: %s',
	'ct_vis_yesterday' => 'Besucher gestern: %s',
	
	'ct_online_today' => 'Online heute: %s',
	'ct_online_total' => 'Online gesamt: %s',
	'ct_online_yesterday' => 'Online gestern: %s',
	'ct_online_atm' => 'Online: %s',

	// FORMS 
	# profile, account
	'name' => 'Name',
	'email' => 'E-Mail Adresse',
	'website' => 'Webseite',
	'icq' => 'ICQ-Nummer',
	'skype' => 'Skype',
	'irc' => 'IRC',
	'account_settings' => 'Account Einstellungen',
	'show_email_on_profile' => 'E-Mail Adresse im Profil anzeigen',
	'profile_settings' => 'Profil Einstellungen',
	'birthdate' => 'Geburtstdatum',
	'firstname' => 'Vorname',
	'lastname' => 'Nachname',
	'nickname' => 'Spitzname',
	'displ_username' => 'Angezeigter Benutzername',
	'old_password' => 'Altes Passwort',
	'new_password' => 'Neues Passwort',
	'password_wdh' => 'Passwort wiederholung',

	# contact, tell a friend
	'contactform' => 'Kontaktformular',
	'contact' => 'Kontakt',
	'tell_a_friend' => 'weiterempfehlen',
	'from_email' => 'Absender E-Mail',
	'to_email' => 'Empfänger E-mail',
	'subject' => 'Betreff',
	'message' => 'Nachricht',
	'send_copy_to_me' => 'Eine Kopie an mich senden',

	# login, logout, register	
	'login' => 'Einloggen',
	'logout' => 'Ausloggen',
	'register' => 'Registrieren',
	'username' => 'Benutzername',
	'password' => 'Passwort',

	# submits
	'submit' => 'Bestätigen',
	'reset' => 'Zurücksetzen',
	'send' => 'Senden',
	'save_profile' => 'Profil speichern',
	'change_password' => 'Passwort ändern',
	'req_field' => 'Pflichtfeld',

	# Color switcher
	'designcolor' => 'Designfarbe: %s',
	'switch_color_of_layout' => 'Layoutfarbe wechseln',
	'red' => 'Rot',
	'green' => 'Grün',
	'blue' => 'Blau',
	'orange' => 'Orange',
	'purple' => 'lila',
	'yellow' => 'Gelb',
	'white' => 'Weiß',
	'black' => 'Schwarz',
	'brown' => 'Braun',
	'change_layout' => 'Layout ändern',

	// MELDUNGEN 
	'sucessfully' => 'Erfolgreich',
	'error_be_logged_in_as' => array(
		'user' => 'Du musst Registriert sein, um diesen versteckten Inhalt zu sehen!',
		'special_user' => 'Du musst als Special-User eingelogt sein, um diesen versteckten Inhalt zu sehen!',
		'moderator' => 'Du musst als Moderator eingelogt sein, um diesen versteckten Inhalt zu sehen!',
		'admin' => 'Du musst als Admin eingelogt sein, um diesen versteckten Inhalt zu sehen!',
	),

	// ERRORS
	'INVALID_FORM' => 'Benutzen sie nur Formulare von der Homepage.',
	'EMPTY_FORM' => 'Bitte fülle das Formular vollständig aus.',
	'NOT_LOGGED_IN' => 'Du musst eingeloggt sein um diese Funktion nutzen zu können.',

	// CONTENT 
	'screen_resolution' => 'Bildschirmaufl&ouml;sung',

	#greeting
	'good_morning' => 'Guten Morgen!',
	'good_day' => 'Guten Tag!&nbsp;&nbsp;&nbsp;',
	'good_evening' => 'Guten Abend!&nbsp;',
	'good_night' => 'Du solltest schlafen gehen!',

	#donate
	'why_donate' => 'Warum spenden?',
	'donate_via_paypal' => 'per PayPal spenden',

	// CONTENT
	'last_change' => 'Letzte Aktualisierung am %s',
);

?>
