<?php
$lang = array(
	'ERR_DATABASE' => 'Tietokantavirhe tiedostossa %s linjalla %s.',
	'ERR_FILE_NOT_FOUND' => 'Tiedostoa ei löytynyt: %s',
	'ERR_MODULE_DISABLED' => 'Moduuli %s ei ole käytössä.',
	'ERR_LOGIN_REQUIRED' => 'Kirjaudu sisään käyttääksesi toimintoa.',
	'ERR_NO_PERMISSION' => 'Ei käyttöoikeutta.',
	'ERR_WRONG_CAPTCHA' => 'Kirjoita kuvan kirjaimet oikein.',
	'ERR_MODULE_MISSING' => 'Moduulia %s ei löytynyt.',
	'ERR_COOKIES_REQUIRED' => 'Istunto aikakatkaistiin tai sinun täytyy aktivoida cookiet selaimessasi.<br/>Yritä päivittää sivu.',
	'ERR_UNKNOWN_USER' => 'Tuntematon käyttäjä.',
	'ERR_UNKNOWN_GROUP' => 'Tuntematon ryhmä.',
	'ERR_UNKNOWN_COUNTRY' => 'Tuntematon maa.',
	'ERR_UNKNOWN_LANGUAGE' => 'Tuntematon kieli.',
	'ERR_METHOD_MISSING' => 'Tuntematon metodi: %s moduulissa %s.',
	'ERR_GENERAL' => 'Määrittämätön virhe %s linjalla %s.',
	'ERR_WRITE_FILE' => 'Ei voi kirjoittaa tiedostoon: %s.',
	'ERR_CLASS_NOT_FOUND' => 'Tuntematon luokka: %s.',
	'ERR_MISSING_VAR' => 'Puuttuva HTTP Post var: %s.',
	'ERR_MISSING_UPLOAD' => 'Sinun täytyy lähettää tiedosto.',
	'ERR_MAIL_SENT' => 'Virhe havaittiin lähetettäessä sinulle sähköpostia.',
	'ERR_CSRF' => 'Formulaarinen merkkisi on vahingoittunut. Ehkä yritit tuplapostausta tai istuntosi aika loppui.',
	'ERR_HOOK' => 'Koukku (hook) tuotti epätoden: %s.',
	'ERR_PARAMETER' => 'Virheellinen argumentti %s linjalla %s. Toimintoargumentti %s on virheellinen.',
	'ERR_DEPENDENCY' => 'Selvittämätön riippuvuus: core/module/%s/method/%s vaatii moduulin %s v%s.',
	'ERR_SEARCH_TERM' => 'Hakusanan täytyy olla %s - %s merkkiä pitkä.',
	'ERR_SEARCH_NO_MATCH' => 'Haullasi &quot;%s&quot; ei löytynyt mitään.',
	'ERR_POST_VAR' => 'Odottamaton POST var: %s.',
	'ERR_DANGEROUS_UPLOAD' => 'Your uploaded file contains &quot;&lt;?&quot; which is considered dangerous and denied.',

	# GWF_Time
	'unit_sec_s' => 's',
	'unit_min_s' => 'm',
	'unit_hour_s' => 'h',
	'unit_day_s' => 'd',
	'unit_month_s' => 'M',
	'unit_year_s' => 'y',

	'M1' => 'Tammikuu',
	'M2' => 'Helmikuu',
	'M3' => 'Maaliskuu',
	'M4' => 'Huhtikuu',
	'M5' => 'Toukokuu',
	'M6' => 'Kesäkuu',
	'M7' => 'Heinäkuu',
	'M8' => 'Elokuu',
	'M9' => 'Syyskuu',
	'M10' => 'Lokakuu',
	'M11' => 'Marraskuu',
	'M12' => 'Joulukuu',

	'm1' => 'Tam',
	'm2' => 'Hel',
	'm3' => 'Maal',
	'm4' => 'Huht',
	'm5' => 'Touk',
	'm6' => 'Kes',
	'm7' => 'Hein',
	'm8' => 'Elok',
	'm9' => 'Syys',
	'm10' => 'Lok',
	'm11' => 'Mar',
	'm12' => 'Joul',

	'D0' => 'Sunnuntai',
	'D1' => 'Maanantai',
	'D2' => 'Tiistai',
	'D3' => 'Keskiviikko',
	'D4' => 'Torstai',
	'D5' => 'Perjantai',
	'D6' => 'Lauantai',

	'd0' => 'Sun',
	'd1' => 'Maan',
	'd2' => 'Tiis',
	'd3' => 'Kesk',
	'd4' => 'Tors',
	'd5' => 'Per',
	'd6' => 'Lau',

	'ago_s' => '%s sekuntia sitten',
	'ago_m' => '%s minuuttia sitten',
	'ago_h' => '%s tuntia sitten',
	'ago_d' => '%s päivää sitten',

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
		array('Tam','Hel','Maal','Huht','Touk','Kes','Hein','Elok','Syys','Lok','Mar','Joul'),
		array('Tammikuu','Helmikuu','Maaliskuu','Huhtikuu','Toukokuu','Kesäkuu','Heinäkuu','Elokuu','Syyskuu','Lokakuu','Marraskuu','Joulukuu'),
		array('Sun','Maan','Tiis','Kesk','Tors','Per','Lau'),
		array('Sunnuntai','Maanantai','Tiistai','Keskiviikko','Torstai','Perjantai','Lauantai'),
		array(4=>'Y', 6=>'M Y', 8=>'D, M j, Y', 10=>'M d, Y - H:00', 12=>'M d, Y - H:i', 14=>'M d, Y - H:i:s'),
	),

	# GWF_Form
	'th_captcha1' => '<a href="http://fi.wikipedia.org/wiki/Kuvavarmennus_%28tietotekniikka%29">Kuvavarmennus</a>',
	'th_captcha2' => 'Kirjoita viisi kirjainta Captcha-kuvasta',
	'tt_password' => 'Salasanan tulisi olla ainakin 8 merkkiä pitkä.',
	'tt_captcha1' => 'Paina Captcha-kuvaa saadaksesi uuden kuvan.',
	'tt_captcha2' => 'Kirjoita (kuva) uudelleen todistaaksesi, että olet ihminen.',

	# GWF_Category
	'no_category' => 'Kategoriat',
	'sel_category' => 'Valitse kategoria',

	# GWF_Language
	'sel_language' => 'Valitse kieli',
	'unknown_lang' => 'Tuntematon kieli',

	# GWF_Country
	'sel_country' => 'Valitse maa',
	'unknown_country' => 'Tuntematon maa',
	'alt_flag' => '%s',

	# GWF_User#gender
	'gender_male' => 'Mies',
	'gender_female' => 'Nainen',
	'gender_no_gender' => 'Tuntematon',

	# GWF_User#avatar
	'alt_avatar' => '%s`n Avatar',

	# GWF_Group
	'sel_group' => 'Valitse käyttäjäryhmä',

	# Date select
	'sel_year' => 'Valitse vuosi',
	'sel_month' => 'Valitse kuukausi',
	'sel_day' => 'Valitse päivä',
	'sel_older' => 'Vanhempi kuin',
	'sel_younger' => 'Nuorempi kuin',

	### General Bits! ###
	'guest' => 'Vieras',
	'unknown' => 'Tuntematon',
	'never' => '(Ei) koskaan',
	'search' => 'Haku',
	'term' => 'Termi',
	'by' => ':llä',
	'and' => 'ja',

	'alt_flag' => '%s Lippu',

	# v2.01 (copyright)
	'copy' => '&copy; %s '.GWF_SITENAME.'. Kaikki oikeudet pidätetään.',
	'copygwf' => GWF_SITENAME.' käyttää <a href="http://gwf.gizmore.org">GWF</a>,:a BSD:n kaltaista web-sivukehikkoa.',

	# v2.02 (recaptcha+required_fields)
	'form_required' => '%s pakollinen kenttä.',

	# v2.03 BBCode
	'bbhelp_b' => 'Lihavointi',
	'bbhelp_i' => 'Kursivointi',
	'bbhelp_u' => 'Alleviivaus',
	'bbhelp_code' => 'Lisää lainauksesi [code] -tagien sisään',
	'bbhelp_quote' => 'Lisää lainauksesi [quote] -tagien sisään',
	'bbhelp_url' => 'Lisää linkki',
	'bbhelp_email' => 'Lisää sähköpostilinkki',
	'bbhelp_noparse' => 'Poista bb-dekoodaus käytöstä.',
	'bbhelp_level' => 'Teksti, jonka näkemiseen tarvitset tietyn käyttäjätason.',
	'bbhelp_spoiler' => 'Näkymätön teksti, jonka saa esiin klikkaamalla.',

	# v2.04 BBCode3
	'quote_from' => 'Lainaus käyttäjältä %s',
	'code' => 'code',
	'for' => 'for',
	
	# 2.05 Bits
	'yes' => 'Kyllä',
	'no' => 'Ei',

	# 2.06 spoiler
	'bbspoiler_info' => 'Click for spoiler',

	# 3.00 Filesize
	'filesize' => array('B','KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'YB', 'ZB'),
	'err_bb_level' => 'You need a userlevel of %s to see this content.',
);
?>