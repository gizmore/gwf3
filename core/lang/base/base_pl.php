<?php
$lang = array(
	'ERR_DATABASE' => 'Błąd bazy danych w pliku %s, wiersz %s.',
	'ERR_FILE_NOT_FOUND' => 'Nie znaleziono pliku: %s',
	'ERR_MODULE_DISABLED' => 'Moduł %s jest obecnie zablokowany.',
	'ERR_LOGIN_REQUIRED' => 'Aby skorzystać z tej funkcji musisz być zalogowany.',
	'ERR_NO_PERMISSION' => 'Brak dostępu.',
	'ERR_WRONG_CAPTCHA' => 'Nie wprowadzono poprawnych danych z obrazka.',
	'ERR_MODULE_MISSING' => 'Nie znaleziono modułu %s.',
	'ERR_COOKIES_REQUIRED' => 'Twoja sesja wygasła lub obsługa plików cookie jest wyłączona.<br/>Spróbuj odświerzyć strone.',
	'ERR_UNKNOWN_USER' => 'Nieznany użytkownik.',
	'ERR_UNKNOWN_GROUP' => 'Nieznana grupa.',
	'ERR_UNKNOWN_COUNTRY' => 'Nieznany kraj.',
	'ERR_UNKNOWN_LANGUAGE' => 'Nieznany język.',
	'ERR_METHOD_MISSING' => 'Nieznana metoda %s w module %s.',
	'ERR_GENERAL' => 'Nieznany błąd w module %s, wiersz %s.',
	'ERR_WRITE_FILE' => 'Nie można zapisać pliku: %s.',
	'ERR_CLASS_NOT_FOUND' => 'Nieznana klasa: %s.',
	'ERR_MISSING_VAR' => 'Brakująca zmienna HTTP POST: %s.',
	'ERR_MISSING_UPLOAD' => 'Musisz wybrać plik do przesłania.',
	'ERR_MAIL_SENT' => 'Wystąpił błąd podczas wysyłania emaila.',
	'ERR_CSRF' => 'Twój token forumlarza jest niewłaściwy. Być może próbujesz wysłać drugi raz tą samą wiadmość lub twoja sesja wygasła.',
	'ERR_HOOK' => 'Hook zwrócił fałsz: %s.',
	'ERR_PARAMETER' => 'Niewłaściwy argument w pliku %s, wiersz %s. Argument %s jest niewłaściwy.',
	'ERR_DEPENDENCY' => 'Nierozwiązana zależność: moduł/%s/metoda/%s wymaga modułu %s v%s.',
	'ERR_SEARCH_TERM' => 'The Search Term has to be %s - %s characters long.',
	'ERR_SEARCH_NO_MATCH' => 'Nie znaleziono wyników dla wyrażenia &quot;%s&quot;.',
	'ERR_POST_VAR' => 'Nieoczekiwana zmienna POST: %s.',
	'ERR_DANGEROUS_UPLOAD' => 'Your uploaded file contains &quot;&lt;?&quot; which is considered dangerous and denied.',

	# GWF_Time
	'unit_sec_s' => 's',
	'unit_min_s' => 'm',
	'unit_hour_s' => 'h',
	'unit_day_s' => 'd',
	'unit_month_s' => 'M',
	'unit_year_s' => 'y',

	'M1' => 'Styczeń',
	'M2' => 'Luty',
	'M3' => 'Marzec',
	'M4' => 'Kwiecień',
	'M5' => 'Maj',
	'M6' => 'Czerwiec',
	'M7' => 'Lipiec',
	'M8' => 'Sierpień',
	'M9' => 'Wrzesień',
	'M10' => 'Październik',
	'M11' => 'Listopad',
	'M12' => 'Grudzień',

	'm1' => 'Sty',
	'm2' => 'Lut',
	'm3' => 'Mar',
	'm4' => 'Kwi',
	'm5' => 'Maj',
	'm6' => 'Cze',
	'm7' => 'Lip',
	'm8' => 'Sie',
	'm9' => 'Wrz',
	'm10' => 'Paź',
	'm11' => 'Lis',
	'm12' => 'Gru',

	'D0' => 'Niedziela',
	'D1' => 'Poniedziałek',
	'D2' => 'Wtorek',
	'D3' => 'Środa',
	'D4' => 'Czwartek',
	'D5' => 'Piątek',
	'D6' => 'Sobota',

	'd0' => 'N',
	'd1' => 'Pn',
	'd2' => 'Wt',
	'd3' => 'Śr',
	'd4' => 'Cz',
	'd5' => 'Pn',
	'd6' => 'So',

	'ago_s' => '%s sekund temu',
	'ago_m' => '%s minut temu',
	'ago_h' => '%s godzin temu',
	'ago_d' => '%s dni temu',

	###
	### TODO: GWF_DateFormat, is problematic, because en != en [us/gb]
	###
	### Here you have to specify how a default dateformats looks for different languages.
	### You have the following substitutes:
	### Year:   Y=1990, y=90
	### Month:  m=01,   n=1,  M=January, N=Jan
	### Day:    d=01,   j=1,  l=Tuesday, D=Tue
	### Hour:   H:23    h=11
	### Minute: i:59
	### Second: s:59
	'df4' => 'Y', # 2009
	'df6' => 'M Y', # January 2009
	'df8' => 'D, M j, Y', # Tue, January 9, 2009
	'df10' => 'M d, Y - H:00', # January 09, 2009 - 23:00
	'df12' => 'M d, Y - H:i',  # January 09, 2009 - 23:59
	'df14' => 'M d, Y - H:i:s',# January 09, 2009 - 23:59:59

	'datecache' => array(
		array('Sty','Lut','Mar','Kwi','Maj','Cze','Lip','Sie','Wrz','Paź','Lis','Gru'),
		array('Styczeń','Luty','Marzec','Kwiecień','Maj','Czerwiec','Lipiec','Sierpień','Wrzesień','Październik','Listopad','Grudzień'),
		array('N','Pn','Wt','Śr','Cz','Pn','So'),
		array('Niedziela','Poniedziałek','Wtorek','Środa','Czwartek','Piątek','Sobota'),
		array(4=>'Y', 6=>'M Y', 8=>'D, M j, Y', 10=>'M d, Y - H:00', 12=>'M d, Y - H:i', 14=>'M d, Y - H:i:s'),
	),

	# GWF_Form
	'th_captcha1' => '<a href="http://en.wikipedia.org/wiki/Captcha">Captcha</a>', #<br/>Click the image to reload',
	'th_captcha2' => 'Przepisz 5 liter z obrazka',
	'tt_password' => 'Hasło powinno mieć przynajmniej 8 znaków.',
	'tt_captcha1' => 'Kliknij na obrazek, aby wygenerować nowy.',
	'tt_captcha2' => 'Przepisz ponownie treść z obrazka, aby udowodnić, że jesteś człowiekiem.',

	# GWF_Category
	'no_category' => 'Wszystkie kategorie',
	'sel_category' => 'Wybierz kategorię',

	# GWF_Language
	'sel_language' => 'Wybierz język',
	'unknown_lang' => 'Nieznany język',

	# GWF_Country
	'sel_country' => 'Wybierz kraj',
	'unknown_country' => 'Nieznany kraj',
	'alt_flag' => '%s',

	# GWF_User#gender
	'gender_male' => 'Mężczyzna',
	'gender_female' => 'Kobieta',
	'gender_no_gender' => 'Nieznana płeć',

	# GWF_User#avatar
	'alt_avatar' => '%s Avatar',

	# GWF_Group
	'sel_group' => 'Wybierz grupę użytkowników',

	# Date select
	'sel_year' => 'Wybierz rok',
	'sel_month' => 'Wybierz miesiąc',
	'sel_day' => 'Wybierz dzień',
	'sel_older' => 'Starszy niż',
	'sel_younger' => 'Młodszy niż',

	### General Bits! ###
	'guest' => 'Gość',
	'unknown' => 'Nieznany',
	'never' => 'Nigdy',
	'search' => 'Szukaj',
	'term' => 'Termin',
	'by' => 'przez',
	'and' => 'i',

	'alt_flag' => '%s Flag',

	# v2.01 (copyright)
	'copy' => '&copy; %s '.GWF_SITENAME.'. All rights reserved.',
	'copygwf' => GWF_SITENAME.' is using <a href="http://gwf.gizmore.org">GWF</a>, the BSD-Like Website Framework.',

	# v2.02 (recaptcha+required_fields)
	'form_required' => '%s means required.',

	# v2.03 BBCode
	'bbhelp_b' => 'bold',
	'bbhelp_i' => 'italic',
	'bbhelp_u' => 'underlined',
	'bbhelp_code' => 'Code goes here',
	'bbhelp_quote' => 'The text here is a quote',
	'bbhelp_url' => 'Link text',
	'bbhelp_email' => 'Text for email link',
	'bbhelp_noparse' => 'Disable bb-decoding here.',
	'bbhelp_level' => 'Text that needs a minimum userlevel to be viewable.',
	'bbhelp_spoiler' => 'Invisible text that is shown with a click.',

	# v2.04 BBCode3
	'quote_from' => 'Quote from %s',
	'code' => 'code',
	'for' => 'for',

	# 2.05 Bits
	'yes' => 'Tak',
	'no' => 'Nr',

	# 2.06 spoiler
	'bbspoiler_info' => 'Click for spoiler',

	# 3.00 Filesize
	'filesize' => array('B','KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'YB', 'ZB'),
	'err_bb_level' => 'You need a userlevel of %s to see this content.',
);

?>
