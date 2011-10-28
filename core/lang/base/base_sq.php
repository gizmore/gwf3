<?php
$lang = array(
	'ERR_DATABASE' => 'Gabim bazës së të dhënave ne skedar %1$s Zeile %2$s.',
	'ERR_FILE_NOT_FOUND' => 'Skedar nuk osht gjetur: %1$s',
	'ERR_MODULE_DISABLED' => 'Moduli %1$s eshte ne moment me aftësi të kufizuara.',
	'ERR_LOGIN_REQUIRED' => 'Funksionale për ta ata duhet të jenë të regjistruar.',
	'ERR_NO_PERMISSION' => 'Refuzohet hyrja.',
	'ERR_WRONG_CAPTCHA' => 'Ju duhet letra nga imazhi captcha saktë shtyp në makinë shkrimi.',
	'ERR_MODULE_MISSING' => 'Moduli 1% nuk mund të gjendet.',
	'ERR_COOKIES_REQUIRED' => 'Sesioni juaj ka skaduar. Ju lutemi provoni faqe për të ringarkoni.',
	'ERR_UNKNOWN_USER' => 'Ky përdorues është i panjohur.',
	'ERR_UNKNOWN_COUNTRY' => 'Ky vend është i panjohur.',
	'ERR_UNKNOWN_LANGUAGE' => 'Kjo gjuhë është e panjohur.',
	'ERR_UNKNOWN_GROUP' => 'Grupet Panjohur.',
	'ERR_METHOD_MISSING' => 'Funksioni %1$s i panjohur në modulin %2$s.',
	'ERR_GENERAL' => 'gabim papërcaktuara %1$s Linjë %2$s.',
	'ERR_WRITE_FILE' => 'Nuk Mund file %1$s nuk e përshkruajnë.',
	'ERR_CLASS_NOT_FOUND' => 'Klasës I Panjohur: %1$s.',
	'ERR_MISSING_VAR' => 'Mungesa e të dhënave formë për fushën %1$s.',
	'ERR_MISSING_UPLOAD' => 'Ju duhet të ngarkoni një skedar.',
	'ERR_MAIL_SENT' => 'Pati një gabim duke dërguar një email tek.',
	'ERR_CSRF' => 'Formë juaj postuar është i pavlefshëm. Ata ndoshta kanë dërguar një formë dy herë, apo sesionin tuaj ka skaduar.',
	'ERR_HOOK' => 'Një zgjerim i dha përsëri një gabim: %1$s.',
	'ERR_PARAMETER' => 'Invalid argument në %1$s Linjë %2$s. Argumenti Funksioni %3$s është i pavlefshëm.',
	'ERR_DEPENDENCY' => 'Funksioni kërkon një modul të humbur: core/module/%1$s/method/%2$s Moduli i kërkuar %3$s v%4$s.',
	'ERR_SEARCH_TERM' => 'Termi kërko duhet %1$s - %2$s Figurë.',
	'ERR_SEARCH_NO_MATCH' => 'Kërkimi juaj për &quot;%1$s&quot; kthyer asnjë rezultat.',
	'ERR_POST_VAR' => 'Të dhënat papritur formë: %1$s.',
	'ERR_DANGEROUS_UPLOAD' => 'Your uploaded file contains &quot;&lt;?&quot; which is considered dangerous and denied.',

	# GWF_Time
	'unit_sec_s' => 's',
	'unit_min_s' => 'm',
	'unit_hour_s' => 'h',
	'unit_day_s' => 'd',
	'unit_month_s' => 'M',
	'unit_year_s' => 'y',

	'M1' => 'Janar',
	'M2' => 'Shkurt',
	'M3' => 'Mars',
	'M4' => 'Prill',
	'M5' => 'Maj',
	'M6' => 'Qershor',
	'M7' => 'Korrik',
	'M8' => 'Gusht',
	'M9' => 'Shtator',
	'M10' => 'Tetor',
	'M11' => 'Nëntor',
	'M12' => 'Dhjetor',

	'm1' => 'jan',
	'm2' => 'shk',
	'm3' => 'mar',
	'm4' => 'pri',
	'm5' => 'mai',
	'm6' => 'qer',
	'm7' => 'kor',
	'm8' => 'gus',
	'm9' => 'tet',
	'm10' => 'sht',
	'm11' => 'nen',
	'm12' => 'dhj',

	'D0' => 'E diel',
	'D1' => 'E hënë',
	'D2' => 'E martë',
	'D3' => 'E mërkurë',
	'D4' => 'E enjte',
	'D5' => 'E premte',
	'D6' => 'E shtunë',

	'd0' => 'die',
	'd1' => 'hen',
	'd2' => 'mar',
	'd3' => 'mer',
	'd4' => 'enj',
	'd5' => 'pre',
	'd6' => 'sht',

	'ago_s' => 'para %1$s sekunda',
	'ago_m' => 'para %1$s minuta',
	'ago_h' => 'para %1$s ore',
	'ago_d' => 'para %1$s dite',

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
	'df12' => 'j. N Y H:i',  # 03.Jan2009-14:59
	'df14' => 'j. N Y H:i:s',# 03.Jan2009-14:59:00

	'datecache' => array(
		array('jan','shk','mar','pri','mai','qer','kor','gus','tet','sht','nen','dhj'),
		array('Janar','Shkurt','Mars','Prill','Maj','Qershor','Korrik','Gusht','Shtator','Tetor','Nëntor','Dhjetor'),
		array('die','hen','mar','mer','enj','pre','sht'),
		array('E diel','E hënë','E martë','E mërkurë','E enjte','E premte','E shtunë'),
		array(4=>'Y', 6=>'M Y', 8=>'D, j.N Y', 10=>'j. N Y H:00', 12=>'j. N Y H:i', 14=>'j. N Y H:i:s'),
	),

	# GWF_Form
	'th_captcha1' => '<a href="http://de.wikipedia.org/wiki/Captcha">Captcha</a>', #<br/>Click the image to reload',
	'th_captcha2' => 'Tap off pesë letra nga imazhi',
	'tt_password' => 'Fjalëkalimet duhet të jetë të paktën 8 shkronja e gjatë.',
	'tt_captcha1' => 'Kliko mbi imazhin për Captch një kërkesë të re.',
	'tt_captcha2' => 'Tap letra për të provuar se ata janë për në një njeri.',

	# GWF_Category
	'no_category' => 'Të Gjitha Kategoritë',
	'sel_category' => 'Zgjidhni një kategori',

	# GWF_Language
	'sel_language' => 'Zgjidhni një gjuhë',
	'unknown_lang' => 'Gjuha Panjohur',

	# GWF_Country
	'sel_country' => 'Zgjidhni një vend',
	'unknown_country' => 'Vendi Panjohur',

	# GWD_User#gender
	'gender_male' => 'Mashkull',
	'gender_female' => 'Femër',
	'gender_no_gender' => 'Gjinia Panjohur',

	# GWF_User#avatar
	'alt_avatar' => '%1$s`s Avatar',

	# GWF_Group
	'sel_group' => 'Zgjidhni një Grupi User',

	# Date select
	'sel_year' => 'Zgjidhni nje vjet',
	'sel_month' => 'Zgjidhni një muaj ',
	'sel_day' => 'Zgjidhni një ditë',
	'sel_older' => 'Më të vjetër se',
	'sel_younger' => 'Më të rinj se',

	### General Bits! ###
	'guest' => 'Mysafir',
	'unknown' => 'I panjohur',
	'never' => 'Kurrë',
	'search' => 'Kërkim',
	'term' => 'Fjale-kyce',
	'and' => 'dhe',
	'by' => 'e',

	'alt_flag' => '%1$s Flamur',

	# v2.01 (copyright)
	'copy' => '&copy; %1$s '.GWF_SITENAME.'. Alle Rechte reserviert.',
	'copygwf' => GWF_SITENAME.' verwendet <a href="http://gwf.gizmore.org">GWF</a>, das Freie-Webseiten-Gerüst.',

	# v2.02 (recaptcha+required_fields)
	'form_required' => '%1$s fushë e nevojshme.',

	# v2.03 BBCode
	'bbhelp_b' => 'Yndyrë',
	'bbhelp_i' => 'Kursiv',
	'bbhelp_u' => 'Nënvizoj',
	'bbhelp_code' => 'Burimi këtu',
	'bbhelp_quote' => 'Ky tekst është një kuotë',
	'bbhelp_url' => 'Link Tekst',
	'bbhelp_email' => 'E-mail tekst',
	'bbhelp_noparse' => 'BBCode është i çaktivizuar',
	'bbhelp_level' => 'Ky tekst kërkon një nivel të caktuar përdorues',
	'bbhelp_spoiler' => 'tekstin e padukshme. Duke klikuar tek anzeigen.estimmten Përdoruesi Niveli',

	# v2.04 BBCode3
	'quote_from' => 'Postuar nga %1$s',
	'code' => 'Shikoni tekstin',
	'for' => 'per',

	# 2.05 Bits
	'yes' => 'Po',
	'no' => 'Nuk ka',

	# 2.06 spoiler
	'bbspoiler_info' => 'Click for spoiler',

	# 3.00 Filesize
	'filesize' => array('B','KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'YB', 'ZB'),
	'err_bb_level' => 'You need a userlevel of %1$s to see this content.',
);	

?>