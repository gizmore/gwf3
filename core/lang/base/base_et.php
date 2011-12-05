<?php
$lang = array(
	'ERR_DATABASE' => 'Andmebaasi viga %s real %s.',
	'ERR_FILE_NOT_FOUND' => 'Faili ei leitud: %s',
	'ERR_MODULE_DISABLED' => 'Moodul %s on hetkel keelatud.',
	'ERR_LOGIN_REQUIRED' => 'Selle funktsiooni kasutamiseks pead olema sisselogitud.',
	'ERR_NO_PERMISSION' => 'Puudub luba.',
	'ERR_WRONG_CAPTCHA' => 'Sa pead pildil olevad tähed õigesti sisestama.',
	'ERR_MODULE_MISSING' => 'Moodulit %s ei leitud.',
	'ERR_COOKIES_REQUIRED' => 'Teie sessioon aegus või te peate lubama küpsised oma brauseris.<br/>Palun proovige lehekülge värskendada.',
	'ERR_UNKNOWN_USER' => 'Kasutaja on tundmatu.',
	'ERR_UNKNOWN_GROUP' => 'Grupp on tundmatu.',
	'ERR_UNKNOWN_COUNTRY' => 'Riik on tundmatu.',
	'ERR_UNKNOWN_LANGUAGE' => 'See keel on tundmatu.',
	'ERR_METHOD_MISSING' => 'Teadmata meetod %s moodulis %s.',
	'ERR_GENERAL' => 'Määramata viga %s real %s.',
	'ERR_WRITE_FILE' => 'Ei saa kirjutada faili%s.',
	'ERR_CLASS_NOT_FOUND' => 'Tundmatu klass: %s.',
	'ERR_MISSING_VAR' => 'Puudub HTTP POST var: %s.',
	'ERR_MISSING_UPLOAD' => 'Sa pead faili üles laadima.',
	'ERR_MAIL_SENT' => ' Teile e-maili saates esines viga..',
	'ERR_CSRF' => 'Teie märk on kehtetu. Võib-olla püüdsite Te postitada kaks korda, või samalajal aegus teie sessioon.',
	'ERR_HOOK' => 'A hook returned false: %s.',
	'ERR_PARAMETER' => 'Vigane argument %s real %s. Funktsiooni argument %s on vigane.',
	'ERR_DEPENDENCY' => 'Lahendanata sõltuvus: moodulid/%s/meetod/%s nõuab mooduleid %s v%s.',
	'ERR_SEARCH_TERM' => 'Otsisõna peab olema %s - %s tähte pikk.',
	'ERR_SEARCH_NO_MATCH' => 'Teie otsing &quot;%s&quote i andnud tulemusi.',
	'ERR_POST_VAR' => 'Ootamatu POST var: %s.',
	'ERR_DANGEROUS_UPLOAD' => 'Your uploaded file contains &quot;&lt;?&quot; which is considered dangerous and denied.',

	# GWF_Time
	'unit_sec_s' => 's',
	'unit_min_s' => 'm',
	'unit_hour_s' => 'h',
	'unit_day_s' => 'd',
	'unit_month_s' => 'M',
	'unit_year_s' => 'y',

	'M1' => 'Jaanuar',
	'M2' => 'Veebruar',
	'M3' => 'Märts',
	'M4' => 'Aprill',
	'M5' => 'Mai',
	'M6' => 'Juuni',
	'M7' => 'Juuli',
	'M8' => 'August',
	'M9' => 'September',
	'M10' => 'Oktoober',
	'M11' => 'November',
	'M12' => 'Detsember',

	'm1' => 'Jan',
	'm2' => 'Veb',
	'm3' => 'Mär',
	'm4' => 'Apr',
	'm5' => 'MaI',
	'm6' => 'Jun',
	'm7' => 'Jul',
	'm8' => 'Aug',
	'm9' => 'Sep',
	'm10' => 'Okt',
	'm11' => 'Nov',
	'm12' => 'Dets',

	'D0' => 'Pühapäev',
	'D1' => 'Esmaspäev',
	'D2' => 'Teisipäev',
	'D3' => 'Kolmapäev',
	'D4' => 'Neljapäev',
	'D5' => 'Reede',
	'D6' => 'Laupäev',

	'd0' => 'P',
	'd1' => 'E',
	'd2' => 'T',
	'd3' => 'K',
	'd4' => 'N',
	'd5' => 'R',
	'd6' => 'L',

	'ago_s' => '%s sekund(it) tagasi',
	'ago_m' => '%s minut(it) tagasi',
	'ago_h' => '%s tund(i) tagasi',
	'ago_d' => '%s päev(a) tagasi',

	###
	### TODO: GWF_DateFormat, on problemaatiline, kuna en != en [us/gb]
	###
	### Siin tuleb täpsustada, kuidas vaikimisi kuupäeva formaat otsib erinevaid keeli.
	### Teil on järgnevad asendajad:
	### Aasta:   Y=1990, y=90
	### Kuu:  m=01,   n=1,  M=Jaanuar, N=Jan
	### Päev:    d=01,   j=1,  d=Teisipäev, D=T
	### Tund:   H:23    h=11
	### Minut: m:59
	### Sekund: s:59
	'df4' => 'Y', # 2009
	'df6' => 'M Y', # January 2009
	'df8' => 'D, M j, Y', # T, 9. jaanuar, 2009
	'df10' => 'M d, Y - H:00', # 9. jaanuar, 2009 - 23:00
	'df12' => 'M d, Y - H:i',  # 9. jaanuar, 2009 - 23:59
	'df14' => 'M d, Y - H:i:s',# 9. jaanuar, 2009 - 23:59:59

	'datecache' => array(
		array('Jan','Veb','Mär','Apr','MaI','Jun','Jul','Aug','Sep','Okt','Nov','Dets'),
		array('Jaanuar','Veebruar','Märts','Aprill','Mai','Juuni','Juuli','August','September','Oktoober','November','Detsember'),
		array('P','E','T','K','N','R','L'),
		array('Pühapäev','Esmaspäev','Teisipäev','Kolmapäev','Neljapäev','Reede','Laupäev'),
		array(4=>'Y', 6=>'M Y', 8=>'D, M j, Y', 10=>'M d, Y - H:00', 12=>'M d, Y - H:i', 14=>'M d, Y - H:i:s'),
	),
	
	# GWF_Form
	'th_captcha1' => '<a href="http://en.wikipedia.org/wiki/Captcha">Captcha</a>', #<br/>Vajuta pildil, et värskendada',
	'th_captcha2' => 'Kirjuta need 5 tähte Captcha pildilt.',
	'tt_password' => 'Parool peaks olema vähemalt 8 tähe pikkune.',
	'tt_captcha1' => 'Uue pildi saamiseks vajuta Captcha pildil.',
	'tt_captcha2' => 'Tõestamaks, et sa oled inimene, kirjuta ümber need tähed.',

	# GWF_Category
	'no_category' => 'Kõik kategooriad',
	'sel_category' => 'Vali kategooria',

	# GWF_Language
	'sel_language' => 'Vali keel',
	'unknown_lang' => 'Tundmatu keel',

	# GWF_Country
	'sel_country' => 'Vali riik',
	'unknown_country' => 'Tundmatu riik',
	'alt_flag' => '%s',

	# GWF_User#gender
	'gender_male' => 'Mees',
	'gender_female' => 'Naine',
	'gender_no_gender' => 'Tundmatu sugu',

	# GWF_User#avatar
	'alt_avatar' => '%s`s Avatar',

	# GWF_Group
	'sel_group' => 'Vali kasutajagrupp',

	# Date select
	'sel_year' => 'Vali aasta',
	'sel_month' => 'Vali kuu',
	'sel_day' => 'Vali päev',
	'sel_older' => 'Vanem kui',
	'sel_younger' => 'Noorem kui',

	### General Bits! ###
	'guest' => 'Külaline',
	'unknown' => 'Tundmatu',
	'never' => 'Mitte kunagi',
	'search' => 'Otsing',
	'term' => 'märksõna',
	'by' => 'järgi',
	'and' => 'ja',

	'alt_flag' => '%s lipp',

	# v2.01 (autoriõigus)
	'copy' => '&copy; %s '.GWF_SITENAME.'. Kõik õigused reserveeritud.',
	'copygwf' => GWF_SITENAME.' kasutab <a href="http://gwf.gizmore.org">GWF</a>, the BSD-Like veebilehekülje raamistikku.',

	# v2.02 (recaptcha+required_fields)
	'form_required' => '%s vahendid vajalikud.',

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

	# v2.05 Bits
	'yes' => 'Jah',
	'no' => 'Ei',

	# 2.06 spoiler
	'bbspoiler_info' => 'Click for spoiler',

	# 3.00 Filesize
	'filesize' => array('B','KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'YB', 'ZB'),
	'err_bb_level' => 'You need a userlevel of %s to see this content.',
);

?>