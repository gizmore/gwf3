<?php

$lang = array(
	'monthnames' => array(
		1 => 'January',
		2 => 'February',
		3 => 'March',
		4 => 'April',
		5 => 'May',
		6 => 'June',
		7 => 'July',
		8 => 'August',
		9 => 'September',
		10 => 'October',
		11 => 'November',
		12 => 'December',
	),
	'daynames' => array(
		0 => 'Sunday',
		1 => 'Monday',
		2 => 'Tuesday',
		3 => 'Wednesday',
		4 => 'Thursday',
		5 => 'Friday',
		6 => 'Saturday'
	),
	'days_to_weekend' => array(
		0 => "And it is weekend!!!           ",
		1 => "Only 5 days until the weekend. ",
		2 => "Only 4 days until the weekend. ",
		3 => "Only 3 days until the weekend. ",
		4 => "Only 4 days until the weekend. ",
		5 => date('G') < 13 ? "Finally, the weekend begins... " : "Tomorrow starts the weekend! ",
		6 => "And it is weekend!!!           ",
	),
	'day' => 'Day',
	'month' => 'Month',
	'year' => 'Year',
	'hour' => 'Hour',
	'second' => 'Second',
	'minute' => 'Minute',
	'request_time' => 'Requesttime',
	'space' => 'Space',
	'free_space' => 'Free',
	'total_space' => 'Total',
	'used_space' => 'Used',
	'admin' => 'Admin',
	'mail' => 'E-Mail',
	'back' => 'Back',
	'change_language' => 'Change language',

	//SURFER INFOS
	'operating_system' => 'Operatingsystem',
	'browser' => 'Browser',
	'provider' => 'Provider',
	'referer' => 'Referer',
	'host' => 'Host',
	'hostname' => 'Hostname',
	'user_agent' => 'UserAgent',

	'country' => 'Country',
	'ip' => 'IP',
	'ipaddr' => 'IP-Address',
	'visitor' => 'Visitor',
	'donations' => 'Donations',
	'server' => 'Server',
	'today' => 'Today',
	'today_is_the' => 'Today is %1$s, the %2$s. %3$s (%4$s), %5$s.',
	'statistics' => 'Statistics',
	'surfer_infos' => 'Surfer Infos',
	'guest' => 'guest',
	
	'si' => array(
		'operating_system' => 'Operatingsystem: %1$s %2$s',
		'browser' => 'Browser: %1$s %2$s',
		'provider' => 'Provider: %1$s %2$s',
		'referer' => 'Referer: %1$s',
		'host' => 'Host: %1$s',
		'hostname' => 'Hostname: %1$s',
		'user_agent' => 'UserAgent: %1$s',
		'country' => 'Country: %1$s %2$s',
		'ip' => 'IP: %1$s',
		'ipaddr' => 'IP-Address: %1$s',
		
	),
	
	//COUNTER TODO: Array
	'ct_vis_total' => 'Visitor total: %1$s',
	'ct_vis_today' => 'Visitor today: %1$s',
	'ct_vis_yesterday' => 'Visitor yesterday: %1$s',
	
	'ct_online_today' => 'Online today: %1$s',
	'ct_online_total' => 'Online total: %1$s',
	'ct_online_yesterday' => 'Online yesterday: %1$s',
	'ct_online_atm' => 'Online: %1$s',

//	// FORMS 
//	# profile, account
//	'name' => 'Name',
//	'email' => 'E-Mail Adresse',
//	'website' => 'Webseite',
//	'icq' => 'ICQ-Nummer',
//	'skype' => 'Skype',
//	'irc' => 'IRC',
//	'account_settings' => 'Account Einstellungen',
//	'show_email_on_profile' => 'E-Mail Adresse im Profil anzeigen',
//	'profile_settings' => 'Profil Einstellungen',
//	'birthdate' => 'Geburtstdatum',
//	'firstname' => 'Vorname',
//	'lastname' => 'Nachname',
//	'nickname' => 'Spitzname',
//	'displ_username' => 'Angezeigter Benutzername',
//	'old_password' => 'Altes Passwort',
//	'new_password' => 'Neues Passwort',
//	'password_wdh' => 'Passwort wiederholung',
//
//	# contact, tell a friend
//	'contactform' => 'Kontaktformular',
//	'contact' => 'Kontakt',
//	'tell_a_friend' => 'weiterempfehlen',
//	'from_email' => 'Absender E-Mail',
//	'to_email' => 'Empfänger E-mail',
//	'subject' => 'Betreff',
//	'message' => 'Nachricht',
//	'send_copy_to_me' => 'Eine Kopie an mich senden',
//
//	# login, logout, register	
//	'login' => 'Einloggen',
//	'logout' => 'Ausloggen',
//	'register' => 'Registrieren',
//	'username' => 'Benutzername',
//	'password' => 'Passwort',
//
//	# submits
//	'submit' => 'Bestätigen',
//	'reset' => 'Zurücksetzen',
//	'send' => 'Senden',
//	'save_profile' => 'Profil speichern',
//	'change_password' => 'Passwort ändern',
//	'req_field' => 'Pflichtfeld',

	# Color switcher
	'switch_color_of_layout' => 'change Layoutcolor',
	'red' => 'Red',
	'green' => 'Green',
	'blue' => 'Blue',
	'orange' => 'Orange',
	'purple' => 'Purple',
	'yellow' => 'Yellow',
	'white' => 'White',
	'black' => 'Black',
	'brown' => 'Brown',
	'change_layout' => 'Change layout',

//	// MELDUNGEN 
//	'sucessfully' => 'Erfolgreich',
//	'error_be_logged_in_as' => array(
//		'user' => 'Du musst Registriert sein, um diesen versteckten Inhalt zu sehen!',
//		'special_user' => 'Du musst als Special-User eingelogt sein, um diesen versteckten Inhalt zu sehen!',
//		'moderator' => 'Du musst als Moderator eingelogt sein, um diesen versteckten Inhalt zu sehen!',
//		'admin' => 'Du musst als Admin eingelogt sein, um diesen versteckten Inhalt zu sehen!',
//	),
//
//	// ERRORS
//	'INVALID_FORM' => 'Benutzen sie nur Formulare von der Homepage.',
//	'EMPTY_FORM' => 'Bitte fülle das Formular vollständig aus.',
//	'NOT_LOGGED_IN' => 'Du musst eingeloggt sein um diese Funktion nutzen zu können.',

	// CONTENT 
	'screen_resolution' => 'Screenresolution',

	#greeting
	'good_morning' => 'Good morning!',
	'good_day' => 'Good day!&nbsp;&nbsp;&nbsp;',
	'good_evening' => 'Good afternoon!&nbsp;',
	'good_night' => 'You shall go sleepin!',

	#donate
	'why_donate' => 'Why donating?',
	'donate_via_paypal' => 'donate via PayPal',

	// CONTENT
	'last_change' => 'Last actualisation on %1$s',
);

?>