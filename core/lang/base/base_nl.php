<?php
$lang = array(
	'ERR_DATABASE' => 'Database fout in bestand %s op regel %s.',
	'ERR_FILE_NOT_FOUND' => 'Bestand niet gevonden: %s',
	'ERR_MODULE_DISABLED' => 'De module %s is correct uitgevinkt.',
	'ERR_LOGIN_REQUIRED' => 'Voor deze functie moet je ingelogd zijn.',
	'ERR_NO_PERMISSION' => 'Geen permissies.',
	'ERR_WRONG_CAPTCHA' => 'Je moet de tekens op de afbeelding correct invoeren.',
	'ERR_MODULE_MISSING' => 'Module %s kan niet gevonden worden.',
	'ERR_COOKIES_REQUIRED' => 'Je sessie is afgesloten,je moet je cookies toelaten.<br/>Probeer de pagina opnieuw te laden.',
	'ERR_UNKNOWN_USER' => 'Deze gebruiker is niet bekend',
	'ERR_UNKNOWN_GROUP' => 'Deze groep is niet bekend',
	'ERR_UNKNOWN_COUNTRY' => 'Dit land is niet bekend',
	'ERR_UNKNOWN_LANGUAGE' => 'Deze taal is niet bekend',
	'ERR_METHOD_MISSING' => 'Onbekende methode: %s in Module %s.',
	'ERR_GENERAL' => 'Onbekende fouten in%s op regel %s.',
	'ERR_WRITE_FILE' => 'Kan het bestand niet beschrijven: %s.',
	'ERR_CLASS_NOT_FOUND' => 'Onbekende class: %s.',
	'ERR_MISSING_VAR' => 'Mist HTTP POST var: %s.',
	'ERR_MISSING_UPLOAD' => 'Je moet een bestand uploaden.',
	'ERR_MAIL_SENT' => 'Er is een fout opgetreden tijdens het versturen van een email.',
	'ERR_CSRF' => 'Een teken in het formulier is ongeldig, Misschien heb je een typefout gemaakt of je sessie is afgesloten.',
	'ERR_HOOK' => 'Een terugkerende fout.: %s.',
	'ERR_PARAMETER' => 'Foute invoer in %s op regel %s. Functie argument %s is fout.',
	'ERR_DEPENDENCY' => 'Onopgeloste probleem in: core/module/%s/methode/%s verschillende Module %s v%s.',
	'ERR_SEARCH_TERM' => 'De zoek term moet minimaal %s - %s characters lang zijn.',
	'ERR_SEARCH_NO_MATCH' => 'Je zoekt voor &quot;%s&quot; Heeft geen resultaten gevonden.',
	'ERR_POST_VAR' => 'Geen geaccepteerde post var: %s.',
	'ERR_DANGEROUS_UPLOAD' => 'Your uploaded file contains &quot;&lt;?&quot; which is considered dangerous and denied.',

	# GWF_Time
	'unit_sec_s' => 's',
	'unit_min_s' => 'm',
	'unit_hour_s' => 'h',
	'unit_day_s' => 'd',
	'unit_month_s' => 'M',
	'unit_year_s' => 'y',

	'M1' => 'Januari',
	'M2' => 'Februari',
	'M3' => 'Maart',
	'M4' => 'April',
	'M5' => 'Mei',
	'M6' => 'Juni',
	'M7' => 'Juli',
	'M8' => 'Augustus',
	'M9' => 'September',
	'M10' => 'Oktober',
	'M11' => 'November',
	'M12' => 'December',

	'm1' => 'Jan',
	'm2' => 'Feb',
	'm3' => 'Mar',
	'm4' => 'Apr',
	'm5' => 'Mei',
	'm6' => 'Jun',
	'm7' => 'Jul',
	'm8' => 'Aug',
	'm9' => 'Sep',
	'm10' => 'Okt',
	'm11' => 'Nov',
	'm12' => 'Dec',

	'D0' => 'Zondag',
	'D1' => 'Maandag',
	'D2' => 'Dinsdag',
	'D3' => 'Woensdag',
	'D4' => 'Donderdag',
	'D5' => 'Vrijdag',
	'D6' => 'Zaterdag',

	'd0' => 'Zo',
	'd1' => 'Ma',
	'd2' => 'Di',
	'd3' => 'Wo',
	'd4' => 'Do',
	'd5' => 'Vrij',
	'd6' => 'Za',

	'ago_s' => '%s seconde geleden',
	'ago_m' => '%s minuut geleden',
	'ago_h' => '%s uur geleden',
	'ago_d' => '%s dag geleden',

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
		array('Jan','Feb','Mar','Apr','Mei','Jun','Jul','Aug','Sep','Okt','Nov','Dec'),
		array('Januari','Februari','Maart','April','Mei','Juni','Juli','Augustus','September','Oktober','November','December'),
		array('Zo','Ma','Di','Wo','Do','Vrij','Za'),
		array('Zondag','Maandag','Dinsdag','Woensdag','Donderdag','Vrijdag','Zaterdag'),
		array(4=>'Y', 6=>'M Y', 8=>'D, M j, Y', 10=>'M d, Y - H:00', 12=>'M d, Y - H:i', 14=>'M d, Y - H:i:s'),
	),
	
	# GWF_Form
	'th_captcha1' => '<a href="http://en.wikipedia.org/wiki/Captcha">Captcha</a>', #<br/>Klik op de afbeelding om te herladen',
	'th_captcha2' => 'Schrijf de 5 letters van de afbeelding over',
	'tt_password' => 'Paswoorden moeten minimaal 8 tekens lang zijn.',
	'tt_captcha1' => 'Klik op de afbeelding voor een nieuw plaatje',
	'tt_captcha2' => 'Typ het plaatje over om te bewijzen dat je een persoon bent.',

	# GWF_Category
	'no_category' => 'Alle categorieën',
	'sel_category' => 'Selecteer een categorie',

	# GWF_Language
	'sel_language' => 'Selecteer een taal',
	'unknown_lang' => 'Onbekende taal',

	# GWF_Country
	'sel_country' => 'Selecteer een Locatie',
	'unknown_country' => 'Onbekende Locatie',
	'alt_flag' => '%s',

	# GWF_User#gender
	'gender_male' => 'Man',
	'gender_female' => 'Vrouw',
	'gender_no_gender' => 'Onbekend personage',

	# GWF_User#avatar
	'alt_avatar' => '%s`s Avatar',

	# GWF_Group
	'sel_group' => 'Selecteer een groep',

	# Date select
	'sel_year' => 'Selecteer jaar',
	'sel_month' => 'Selecteer maand',
	'sel_day' => 'Selecteer dag',
	'sel_older' => 'Ouder dan',
	'sel_younger' => 'Jonger dan',

	### General Bits! ###
	'guest' => 'Gast',
	'unknown' => 'Onbekend',
	'never' => 'Nooit',
	'search' => 'Zoeken',
	'term' => 'Term',
	'by' => 'Door',
	'and' => 'en',

	'alt_flag' => '%s Flag',

	# v2.01 (copyright)
	'copy' => '&copy; %s '.GWF_SITENAME.'. All rights reserved.',
	'copygwf' => GWF_SITENAME.' Gebruikt <a href="http://gwf.gizmore.org">GWF</a>, de BSD-Like Website Framework.',

	# v2.02 (recaptcha+required_fields)
	'form_required' => '%s means required.',

	# v2.03 BBCode
	'bbhelp_b' => 'Dik',
	'bbhelp_i' => 'Schuin',
	'bbhelp_u' => 'onderstreept',
	'bbhelp_code' => 'De code moet hier',
	'bbhelp_quote' => 'Deze Tekst is een quate',
	'bbhelp_url' => 'Link Tekst',
	'bbhelp_email' => 'Tekst  voor email link',
	'bbhelp_noparse' => 'Disable bb-decoding here.',
	'bbhelp_level' => 'Tekst dat een minumum gebruikers level nodig heeft',
	'bbhelp_spoiler' => 'Invisible Tekst that is shown with a click.',

	# v2.04 BBCode3
	'quote_from' => 'Quote van %s',
	'code' => 'code',
	'for' => 'voor',

	# 2.05 Bits
	'Yes' => 'Ja',
	'No' => 'Nee',

	# 2.06 spoiler
	'bbspoiler_info' => 'Click for spoiler',

	# 3.00 Filesize
	'filesize' => array('B','KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'YB', 'ZB'),
	'err_bb_level' => 'You need a userlevel of %s to see this content.',
);

?>