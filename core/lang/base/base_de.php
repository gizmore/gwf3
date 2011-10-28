<?php

$lang = array(

	'ERR_DATABASE' => 'Datenbank Fehler in Datei %1$s Zeile %2$s.',
	'ERR_FILE_NOT_FOUND' => 'Datei nicht gefunden: %1$s',
	'ERR_MODULE_DISABLED' => 'Das Modul %1$s ist zur zeit deaktiviert.',
	'ERR_LOGIN_REQUIRED' => 'Für diese Funktion müssen sie angemeldet sein.',
	'ERR_NO_PERMISSION' => 'Zugriff Verweigert.',
	'ERR_WRONG_CAPTCHA' => 'Sie müssen die Buchstaben aus dem Captcha Bild richtig abtippen.',
	'ERR_MODULE_MISSING' => 'Modul %1$s konnte nicht gefunden werden.',
	'ERR_COOKIES_REQUIRED' => 'Ihre Sitzung ist abgelaufen. Bitte versuchen sie die Seite erneut zu laden.',
	'ERR_UNKNOWN_USER' => 'Dieser Benutzer ist unbekannt.',
	'ERR_UNKNOWN_COUNTRY' => 'Dieses Land ist unbekant.',
	'ERR_UNKNOWN_LANGUAGE' => 'Diese Sprache ist unbekant.',
	'ERR_UNKNOWN_GROUP' => 'Unbekannte Benutzergruppe.',
	'ERR_METHOD_MISSING' => 'Unbekannte Funktion %1$s in Modul %2$s.',
	'ERR_GENERAL' => 'Undefinierter Fehler in %1$s Zeile %2$s.',
	'ERR_WRITE_FILE' => 'Kann die Datei %1$s nicht beschreiben.',
	'ERR_CLASS_NOT_FOUND' => 'Unbekannte Klasse: %1$s.',
	'ERR_MISSING_VAR' => 'Fehlende Formular Daten für feld %1$s.',
	'ERR_MISSING_UPLOAD' => 'Sie müssen eine Datei hochladen.',
	'ERR_MAIL_SENT' => 'Es trat ein Fehler beim Senden der EMail auf.',
	'ERR_CSRF' => 'Ihr gesendetes Formular ist ungültig. Wahrscheinlich haben sie ein Formular zwei mal gesendet, oder Ihre Sitzung ist abgelaufen.',
	'ERR_HOOK' => 'Eine Erweiterung lieferte einen Fehler zurück: %1$s.',
	'ERR_PARAMETER' => 'Ungültiges argument in %1$s Zeile %2$s. Funktionsargument %3$s ist ungültig.',
	'ERR_DEPENDENCY' => 'Funktion benötigt ein fehlendes Modul: core/module/%1$s/method/%2$s benötigt Modul %3$s v%4$s.',
	'ERR_SEARCH_TERM' => 'Der Suchbegriff muss %1$s - %2$s Zeichen lang sein.',
	'ERR_SEARCH_NO_MATCH' => 'Ihre Suche nach &quot;%1$s&quot; ergab keine Treffer.',
	'ERR_POST_VAR' => 'Unerwartete Formulardaten: %1$s.',
	'ERR_DANGEROUS_UPLOAD' => 'Your uploaded file contains &quot;&lt;?&quot; which is considered dangerous and denied.',

	# GWF_Time
	'unit_sec_s' => 's',
	'unit_min_s' => 'm',
	'unit_hour_s' => 'h',
	'unit_day_s' => 'd',
	'unit_month_s' => 'M',
	'unit_year_s' => 'y',

	'M1' => 'Januar',
	'M2' => 'Februar',
	'M3' => 'März',
	'M4' => 'April',
	'M5' => 'Mai',
	'M6' => 'Juni',
	'M7' => 'Juli',
	'M8' => 'August',
	'M9' => 'September',
	'M10' => 'Oktober',
	'M11' => 'November',
	'M12' => 'Dezember',

	'm1' => 'Jan',
	'm2' => 'Feb',
	'm3' => 'Mär',
	'm4' => 'Apr',
	'm5' => 'Mai',
	'm6' => 'Jun',
	'm7' => 'Jul',
	'm8' => 'Aug',
	'm9' => 'Sep',
	'm10' => 'Okt',
	'm11' => 'Nov',
	'm12' => 'Dez',

	'D0' => 'Sonntag',
	'D1' => 'Montag',
	'D2' => 'Dienstag',
	'D3' => 'Mittwoch',
	'D4' => 'Donnerstag',
	'D5' => 'Freitag',
	'D6' => 'Samstag',

	'd0' => 'So',
	'd1' => 'Mo',
	'd2' => 'Di',
	'd3' => 'Mi',
	'd4' => 'Do',
	'd5' => 'Fr',
	'd6' => 'Sa',

	'ago_s' => 'vor %1$s Sekunde(n)',
	'ago_m' => 'vor %1$s Minute(n)',
	'ago_h' => 'vor %1$s Stunde(n)',
	'ago_d' => 'vor %1$s Tage(n)',

	###
	### GWF_DateFormat, is problematic, because en != en [us_gb]??
	### Here you can specify how a default dateformat looks for different iso languages.
	### Year: Y=1990, y=90
	### Month: m=01, n=1, M=January, N=Jan
	### Day: d=01, j=1, l=Tuesday, D=Tue
	### Hour: H:23 h=11
	### Minute: i:59
	### Second: s:59
	'df4' => 'Y', # 2009
	'df6' => 'M Y', # Januar 2009
	'df8' => 'D, j.N Y', # Di, 3.Jan 2009
	'df10' => 'j. N Y H:00', # 03.Jan2009-14:00
	'df12' => 'j. N Y - H:i',  # 03.Jan2009-14:59
	'df14' => 'j. N Y H:i:s',# 03.Jan2009-14:59:00

	# The data from the 5 sections above, merged for faster access.
	'datecache' => array(
		array('Jan','Feb','Mär','Apr','Mai','Jun','Jul','Aug','Sep','Okt','Nov','Dez'),
		array('Januar','Februar','März','April','Mai','Juni','Juli','August','September','Oktober','November','Dezember'),
		array('So','Mo','Di','Mi','Do','Fr','Sa'),
		array('Sonntag','Montag','Dienstag','Mittwoch','Donnerstag','Freitag','Samstag'),
		array(4=>'Y', 6=>'M Y', 8=>'D, j.N Y', 10=>'j. N Y H:00', 12=>'j. N Y - H:i', 14=>'j. N Y H:i:s'),
	),

	# GWF_Form
	'th_captcha1' => '<a href="http://de.wikipedia.org/wiki/Captcha">Captcha</a>', #<br/>Click the image to reload',
	'th_captcha2' => 'Tippen sie die 5 Buchstaben aus dem Bild ab',
	'tt_password' => 'Passwörter müssen mindestens 8 Zeichen lang sein.',
	'tt_captcha1' => 'Klicken sie auf das Captch Bild um ein neues anzufordern.',
	'tt_captcha2' => 'Tippen sie die Buchstaben ab um zu beweisen das sie ein Mensch sind.',

	# GWF_Category
	'no_category' => 'Alle Kategorien',
	'sel_category' => 'Wählen sie eine Kategorie',

	# GWF_Language
	'sel_language' => 'Wählen sie eine Sprache',
	'unknown_lang' => 'Unbekannte Sprache',

	# GWF_Country
	'sel_country' => 'Wählen sie ein Land',
	'unknown_country' => 'Unbekanntes Land',

	# GWD_User#gender
	'gender_male' => 'Männlich',
	'gender_female' => 'Weiblich',
	'gender_no_gender' => 'Unbekanntes Geschlecht',

	# GWF_User#avatar
	'alt_avatar' => '%1$s`s Benutzerbild',

	# GWF_Group
	'sel_group' => 'Wählen sie eine Benutzer-Gruppe',

	# Date select
	'sel_year' => 'Wählen sie ein Jahr',
	'sel_month' => 'Wählen sie einen Monat ',
	'sel_day' => 'Wählen sie einen Tag',
	'sel_older' => 'Älter als',
	'sel_younger' => 'Jünger als',

	### General Bits! ###
	'guest' => 'Gast',
	'unknown' => 'Unbekannt',
	'never' => 'Niemals',
	'search' => 'Suchen',
	'term' => 'Suchbegriff',
	'and' => 'und',
	'by' => 'von',

	'alt_flag' => '%1$s Flagge',

	# v2.01 (copyright)
	'copy' => '&copy; %1$s '.GWF_SITENAME.'. Alle Rechte reserviert.',
	'copygwf' => GWF_SITENAME.' verwendet <a href="http://gwf.gizmore.org">GWF</a>, das Freie-Webseiten-Gerüst.',

	# v2.02 (recaptcha+required_fields)
	'form_required' => '%1$s benötigtes Feld.',

	# v2.03 BBCode
	'bbhelp_b' => 'Fett',
	'bbhelp_i' => 'Kursiv',
	'bbhelp_u' => 'Unterstrichen',
	'bbhelp_code' => 'Quelltext hier',
	'bbhelp_quote' => 'Dieser Text ist ein Zitat',
	'bbhelp_url' => 'Linktext',
	'bbhelp_email' => 'E-Mail text',
	'bbhelp_noparse' => 'BBCode ist hier deaktivert',
	'bbhelp_level' => 'Dieser Text benötigt einen bestimmten Userlevel',
	'bbhelp_spoiler' => 'Unsichtbarer text. Durch Klick anzeigen.',

	# v2.04 BBCode3
	'quote_from' => 'Zitat von %1$s',
	'code' => 'Quelltext',
	'for' => 'für',

	# 2.05 Bits
	'yes' => 'Ja',
	'no' => 'Nein',

	# 2.06 spoiler
	'bbspoiler_info' => 'Click for spoiler',

	# 3.00 Filesize
	'filesize' => array('B','KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'YB', 'ZB'),
	'err_bb_level' => 'You need a userlevel of %1$s to see this content.',
);	

?>
