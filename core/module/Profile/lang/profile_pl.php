<?php # PHmaster + drummachina

$lang = array(
	# Page Titles
	'pt_profile' => 'Profil %1%',
	'pt_settings' => 'Ustawienia profilu',

	# Meta Tags
	'mt_profile' => 'Profil %1%, '.GWF_SITENAME.', %1%, Profil',
	'mt_settings' => GWF_SITENAME.', Profil, Ustawienia, Edycja, Kontakt, Dane',

	# Meta Description
	'md_profile' => 'Profil %1% na stronie '.GWF_SITENAME.'.',
	'md_settings' => 'Ustawienia profilu na stronie '.GWF_SITENAME.'.',

	# Info
	'pi_help' =>
		'Aby wgrać avatar użyj zakładki głównych ustawień konta.<br/>'.
		'Aby dodać podpis pojawiający się w Twoich wiadomościach na forum użyj zakładki ustawień forum.<br/>'.
		'Również PW i inne moduły posiadają swoje oddzielne zakładki ustawień.<br/>'.
		'<b>Wszystkie ustawione tutaj opcje będą widoczne dla kazdego... także nie podawaj za dużo informacji o sobie</b>.<br/>'.
		'Jeśli ukryłeś e-mail sprawdź też ustawienia konta, czy flaga EMail również jest zaznaczona.<br/>'.
		'Istnieje możliwość ukrycia profilu przed gośćmi i robotami wyszukiwarek.',

	# Errors
	'err_hidden' => 'Widok profilu użytkownika jest ukryty.',
	'err_firstname' => 'Wprowadzone imię jest nieprawidłowe. Maksymalna długość: %1% znaków.',
	'err_lastname' => 'Wprowadzone nazwisko jest nieprawidłowe. Maksymalna długość: %1% znaków.',
	'err_street' => 'Wprowadzona nazwa ulicy jest nieprawidłowa. Maksymalna długość: %1% znaków.',
	'err_zip' => 'Wprowadzony kod pocztowy jest nieprawidłowy. Maksymalna długość: %1% znaków.',
	'err_city' => 'Wprowadzona nazwa miasta jest nieprawidłowa. Maksymalna długość: %1% znaków.',
	'err_tel' => 'Wprowadzony numer telefonu stacjonarnego jest nieprawidłowy. Maksymalna długość: %1% znaków.',
	'err_mobile' => 'Wprowadzony numer telefonu komrórkowego jest nieprawidłowy. Maksymalna długość: %1% znaków.',
	'err_icq' => 'Wprowadzony numer ICQ-UIN jest nieprawidłowy. Maksymalna długość: %1% znaków.',
	'err_msn' => 'Wprowadzony numer MSN jest nieprawidłowy. Maksymalna długość: %1% znaków.',
	'err_jabber' => 'Wprowadzony identyfikator Jabber jest nieprawidłowy. Maksymalna długość: %1% znaków.',
	'err_skype' => 'Wprowadzona nazwa użytkownika Skype jest nieprawidłowa. Maksymalna długość: %1% znaków.',
	'err_yahoo' => 'Wprowadzony identyfikator Yahoo! jest nieprawidłowy. Maksymalna długość: %1% znaków.',
	'err_aim' => 'Wprowadzony numer AIM jest nieprawidłowy. Maksymalna długość: %1% znaków.',
	'err_about_me' => 'Twoja notatka &quot;O mnie&quot; jest nieprawidłowa. Maksymalna długość: %1% znaków.',
	'err_website' => 'Twoja strona internetowa nie istnieje bądź nie można nawiazać z nią połączenia.',

	# Messages
	'msg_edited' => 'Twój profil został wyedytowany.',

	# Headers
	'th_user_name' => 'Użytkownik',
	'th_user_level' => 'Poziom',
	'th_user_avatar' => 'Avatar',
	'th_gender' => 'Płeć',
	'th_firstname' => 'Imię',
	'th_lastname' => 'Nazwisko',
	'th_street' => 'Ulica',
	'th_zip' => 'Kod pocztowy',
	'th_city' => 'Miasto',
	'th_website' => 'Strona WWW',
	'th_tel' => 'Tel. stacjonarny',
	'th_mobile' => 'Tel. komórkowy',
	'th_icq' => 'ICQ',
	'th_msn' => 'MSN',
	'th_jabber' => 'Jabber',
	'th_skype' => 'Skype',
	'th_yahoo' => 'Yahoo!',
	'th_aim' => 'AIM',
	'th_about_me' => 'Kilka słów o Tobie',
	'th_hidemail' => 'Ukrywać e-mail w widoku profilu?',
	'th_hidden' => 'Ukrywać profil przed gośćmi?',
	'th_level_all' => 'Minimalny poziom na wszystko',
	'th_level_contact' => 'Minimalny poziom kontaktu',
	'th_hidecountry' => 'Ukrywać Twój kraj?',
	'th_registered' => 'Data rejestracji',
	'th_last_active' => 'Ostatina wizyta',
	'th_views' => 'Liczba wyświetleń profilu',

	# Form Titles
	'ft_settings' => 'Edytuj Swój profil',

	# Tooltips
	'tt_level_all' => 'Minimalny poziom użytkowników, którzy mogą zobaczyć Twój profil',
	'tt_level_contact' => 'Minimalny poziom użytkowników, którzy mogą zobaczyć dane do kontaktu z Tobą',

	# Buttons
	'btn_edit' => 'Zapisz ustawienia profilu',

	# Admin Config
	'cfg_prof_hide' => 'Pozwolić na ukrywanie profili?',
	'cfg_prof_max_about' => 'Maksymalna długosć dla pola &quot;O mnie&quot;',

	# V2.01 (Hide Guests)
	'th_hideguest' => 'Hide from guests?',

	# v2.02 (fixes)
	'err_level_all' => 'Your minimum user level to see your profile is invalid.',
	'err_level_contact' => 'Your minimum user level to see your contact data is invalid.',

	# v2.03 (fixes2)
	'title_about_me' => 'About %1%',

	# v2.04 (ext. profile)
	'th_user_country' => 'Country',
	'btn_pm' => 'PM',

	# v2.05 (more fixes)
	'at_mailto' => 'Send a mail to %1%',
	'th_email' => 'EMail',

	# v2.06 (birthday)
	'th_age' => 'Age',
	'th_birthdate' => 'Birthdate',

	# v2.07 (IRC+Robots)
	'th_irc' => 'IRC',
	'th_hiderobot' => 'Hide from web crawlers?',
	'tt_hiderobot' => 'Checkmark this if you don\'t want your profile get indexed by search engines.',
	'err_no_spiders' => 'This profile can not be watched by web crawlers.',
);

?>