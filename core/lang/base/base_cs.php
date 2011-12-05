<?php

$lang = array(

	'ERR_DATABASE' => 'Chyba databáze v souboru %s řádka %s.',
	'ERR_FILE_NOT_FOUND' => 'Soubor nenalezen: %s',
	'ERR_MODULE_DISABLED' => 'Modul %s není aktivován.',
	'ERR_LOGIN_REQUIRED' => 'Pro správné fungování musíte být nejprve přihlášeni.',
	'ERR_NO_PERMISSION' => 'Přístup zakázán.',
	'ERR_WRONG_CAPTCHA' => 'Písmena z obrázku nebyla opsána správně.',
	'ERR_MODULE_MISSING' => 'Modul %s nebyl nalezen.',
	'ERR_COOKIES_REQUIRED' => 'Tvoje session vypršela nebo nemáš aktivovaná cookie ve svém prohlížeci.<br/>Prosím zkus znovu načíst stránku.',
	'ERR_UNKNOWN_USER' => 'Neznámý uživatel.',
	'ERR_UNKNOWN_GROUP' => 'Neznámá skupina.',
	'ERR_UNKNOWN_COUNTRY' => 'Neznámý stát.',
	'ERR_UNKNOWN_LANGUAGE' => 'Neznámý jazyk.',
	'ERR_METHOD_MISSING' => 'Neznámá metoda: %s v modulu %s.',
	'ERR_GENERAL' => 'Neznámá chyba v %s řádka %s.',
	'ERR_WRITE_FILE' => 'Není možné zapsat do souboru: %s.',
	'ERR_CLASS_NOT_FOUND' => 'Neznámá třída: %s.',
	'ERR_MISSING_VAR' => 'Chybí HTTP POST var: %s.',
	'ERR_MISSING_UPLOAD' => 'Je třeba nahrát soubor.',
	'ERR_MAIL_SENT' => 'Nastala chyba při odesílání emailu.',
	'ERR_CSRF' => 'Tvůj formulářový token je neplatný. Možná jsi se ho pokoušel odeslat vícekrát nebo mezitím vypršela session.',
	'ERR_HOOK' => 'Hook vrátil false: %s.',
	'ERR_PARAMETER' => 'Neplatný parameter v %s řádka %s. Parametr funkce %s je neplatný.',
	'ERR_DEPENDENCY' => 'Nevyřešená závislost: moduly/%s/metoda/%s vyžadují modul %s v%s.',
	'ERR_SEARCH_TERM' => 'Vyhledávaný řetězec musí byt %s - %s znaků dlouhý.',
	'ERR_SEARCH_NO_MATCH' => 'To co jsi hledal &quot;%s&quot; nebylo nalezeno.',
	'ERR_POST_VAR' => 'Neočekávaná POST var: %s.',
	'ERR_DANGEROUS_UPLOAD' => 'Your uploaded file contains &quot;&lt;?&quot; which is considered dangerous and denied.',

	# GWF_Time
	'unit_sec_s' => 's',
	'unit_min_s' => 'm',
	'unit_hour_s' => 'h',
	'unit_day_s' => 'd',
	'unit_month_s' => 'M',
	'unit_year_s' => 'y',

	'M1' => 'Leden',
	'M2' => 'Únor',
	'M3' => 'Březen',
	'M4' => 'Duben',
	'M5' => 'Květen',
	'M6' => 'Červen',
	'M7' => 'Červenec',
	'M8' => 'Srpen',
	'M9' => 'Září',
	'M10' => 'Říjen',
	'M11' => 'Listopad',
	'M12' => 'Prosinec',

	'm1' => 'Led',
	'm2' => 'Úno',
	'm3' => 'Bře',
	'm4' => 'Dub',
	'm5' => 'Kvě',
	'm6' => 'Čer',
	'm7' => 'Čvc',
	'm8' => 'Srp',
	'm9' => 'Zář',
	'm10' => 'Říj',
	'm11' => 'Lis',
	'm12' => 'Pro',

	'D0' => 'Neděle',
	'D1' => 'Pondělí',
	'D2' => 'Úterý',
	'D3' => 'Středa',
	'D4' => 'Čtvrtek',
	'D5' => 'Pátek',
	'D6' => 'Sobota',

	'd0' => 'Ne',
	'd1' => 'Po',
	'd2' => 'Út',
	'd3' => 'St',
	'd4' => 'Čt',
	'd5' => 'Pá',
	'd6' => 'So',

	'ago_s' => 'před %s sekundami',
	'ago_m' => 'před %s minutami',
	'ago_h' => 'před %s hodinami',
	'ago_d' => 'před %s dny',

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

	# The data from the 5 sections above, merged for faster access.
	'datecache' => array(
		array('Led','Úno','Bře','Dub','Kvě','Čer','Čvc','Srp','Zář','Říj','Lis','Pro'),
		array('Leden','Únor','Březen','Duben','Květen','Červen','Červenec','Srpen','Září','Říjen','Listopad','Prosinec'),
		array('Ne','Po','Út','St','Čt','Pá','So'),
		array('Neděle','Pondělí','Úterý','Středa','Čtvrtek','Pátek','Sobota'),
		array(4=>'Y', 6=>'M Y', 8=>'D, M j, Y', 10=>'M d, Y - H:00', 12=>'M d, Y - H:i', 14=>'M d, Y - H:i:s'),
	),


	# GWF_Form
	'th_captcha1' => '<a href="http://en.wikipedia.org/wiki/Captcha">Captcha</a>', #<br/>Click the image to reload',
	'th_captcha2' => 'Opiš 5 znaků z captcha obrázku.',
	'tt_password' => 'Heslo by mělo mít minimálně 8 znaků.',
	'tt_captcha1' => 'Pro zobrazení nového obrázku klikni na captcha obrázek.',
	'tt_captcha2' => 'Opište obrázek na důkaz, že jste člověk.',

	# GWF_Category
	'no_category' => 'Všechny kategorie',
	'sel_category' => 'Vyber kategorii',

	# GWF_Language
	'sel_language' => 'Vyber jazyk',
	'unknown_lang' => 'Neznámý jazyk',

	# GWF_Country
	'sel_country' => 'Vyber stát',
	'unknown_country' => 'Neznámý stát',
	'alt_flag' => '%s',

	# GWF_User#gender
	'gender_male' => 'Muž',
	'gender_female' => 'Žena',
	'gender_no_gender' => 'Neuvedeno',

	# GWF_User#avatar
	'alt_avatar' => 'Avatar uživatele %s',

	# GWF_Group
	'sel_group' => 'Vyber skupinu uživatelů',

	# Date select
	'sel_year' => 'Vyber rok',
	'sel_month' => 'Vyber měsíc',
	'sel_day' => 'Vyber den',
	'sel_older' => 'Starší než',
	'sel_younger' => 'Mladší než',

	### General Bits! ###
	'guest' => 'Host',
	'unknown' => 'Neznámé',
	'never' => 'Nikdy',
	'search' => 'Vyhledávání',
	'term' => 'Řetězec',
	'by' => 'od',
	'and' => 'a',

	'alt_flag' => '%s vlajka',

	# v2.01 (copyright)
	'copy' => '&copy; %s '.GWF_SITENAME.'. Všechna práva vyhražena.',
	'copygwf' => GWF_SITENAME.' používá <a href="http://gwf.gizmore.org">GWF</a>, the BSD-Like Website Framework.',

	# v2.02 (recaptcha+required_fields)
	'form_required' => '%s je povinné.',

	# v2.03 BBCode
	'bbhelp_b' => 'tučné',
	'bbhelp_i' => 'kurzíva',
	'bbhelp_u' => 'podtržené',
	'bbhelp_code' => 'Kód',
	'bbhelp_quote' => 'Citát',
	'bbhelp_url' => 'Text odkazu',
	'bbhelp_email' => 'Adresa emailu',
	'bbhelp_noparse' => 'Vypni bb-decoding.',
	'bbhelp_level' => 'Tento text si viditelný jen pro uživatele s alespoň minimálními oprávněními.',
	'bbhelp_spoiler' => 'Neviditelný text, který se zobrazí po klikninutí.',

	# v2.04 BBCode3
	'quote_from' => 'Citát od %s',
	'code' => 'kód',
	'for' => 'pro',

	# 2.05 Bits
	'yes' => 'Ano',
	'no' => 'Ne',
	
	# 2.06 fix
	'bbspoiler_info' => 'Klikni pro spoiler',
	
	# 3.00 Filesize
	'filesize' => array('B','KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'YB', 'ZB'),
	'err_bb_level' => 'You need a userlevel of %s to see this content.',
);

?>
