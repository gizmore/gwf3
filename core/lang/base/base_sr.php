<?php
# translation by Bejker
$lang = array(
	'ERR_DATABASE' => 'База података има грешку у фајлу %s Линија %s.',
	'ERR_FILE_NOT_FOUND' => 'Фајл није пронађен: %s',
	'ERR_MODULE_DISABLED' => 'Модул %s је тренутно онемогућен.',
	'ERR_LOGIN_REQUIRED' => 'За ову функцију морате бити улоговани.',
	'ERR_NO_PERMISSION' => 'Није дозвољено.',
	'ERR_WRONG_CAPTCHA' => 'Морате укуцати слова са слике тачно.',
	'ERR_MODULE_MISSING' => 'Модул %s не може бити нађен.',
	'ERR_COOKIES_REQUIRED' => 'Време сесије је истекло или Вам нису подржани кукији у претраживачу.<br/>Молимо освежите страницу.',
	'ERR_UNKNOWN_USER' => 'Корисник је непознат.',
	'ERR_UNKNOWN_GROUP' => 'Група је непозната.',
	'ERR_UNKNOWN_COUNTRY' => 'Држава је непозната.',
	'ERR_UNKNOWN_LANGUAGE' => 'Језик је непознат.',
	'ERR_METHOD_MISSING' => 'Непознат метод: %s у модулу %s.',
	'ERR_GENERAL' => 'Непозната грешка у %s Линија %s.',
	'ERR_WRITE_FILE' => 'Не може се исписати фајл: %s.',
	'ERR_CLASS_NOT_FOUND' => 'Непозната класа: %s.',
	'ERR_MISSING_VAR' => 'Недостаје HTTP POST променљива: %s.',
	'ERR_MISSING_UPLOAD' => 'Морате аплодовати фајл.',
	'ERR_MAIL_SENT' => 'Појавила се грешка за време слања мејла.',
	'ERR_CSRF' => 'Ваш токен формулара је невалидан. Можда сте покушали дуплирати текст, или је у међувремену истекла сесија.',
	'ERR_HOOK' => 'A hook returned false: %s.',
	'ERR_PARAMETER' => 'Неисправан аргумент у %s линија %s. Аргумент функције %s је невалидан.',
	'ERR_DEPENDENCY' => 'Unresolved Dependency: core/module/%s/method/%s requires Module %s v%s.',
	'ERR_SEARCH_TERM' => 'Термин за претрагу мора бити %s - %s карактера дугачак.',
	'ERR_SEARCH_NO_MATCH' => 'Тражени термин &quot;%s&quot; није пронађен.',
	'ERR_POST_VAR' => 'Неочекивана POST променљива: %s.',
	'ERR_DANGEROUS_UPLOAD' => 'Your uploaded file contains &quot;&lt;?&quot; which is considered dangerous and denied.',

	# GWF_Time
	'unit_sec_s' => 's',
	'unit_min_s' => 'm',
	'unit_hour_s' => 'h',
	'unit_day_s' => 'd',
	'unit_month_s' => 'M',
	'unit_year_s' => 'y',

	'M1' => 'Јануар',
	'M2' => 'Фебруар',
	'M3' => 'Март',
	'M4' => 'Април',
	'M5' => 'Мај',
	'M6' => 'Јун',
	'M7' => 'Јул',
	'M8' => 'Август',
	'M9' => 'Септембар',
	'M10' => 'Октобар',
	'M11' => 'Новембар',
	'M12' => 'Децембар',

	'm1' => 'Jan',
	'm2' => 'Feb',
	'm3' => 'Mar',
	'm4' => 'Apr',
	'm5' => 'May',
	'm6' => 'Jun',
	'm7' => 'Jul',
	'm8' => 'Aug',
	'm9' => 'Sep',
	'm10' => 'Oct',
	'm11' => 'Nov',
	'm12' => 'Dec',

	'D0' => 'Понедељак',
	'D1' => 'Уторак',
	'D2' => 'Среда',
	'D3' => 'Четвртак',
	'D4' => 'Петак',
	'D5' => 'Субота',
	'D6' => 'Недеља',

	'd0' => 'Sun',
	'd1' => 'Mon',
	'd2' => 'Tue',
	'd3' => 'Wed',
	'd4' => 'Thu',
	'd5' => 'Fri',
	'd6' => 'Sat',

	'ago_s' => '%s seconds ago',
	'ago_m' => '%s minutes ago',
	'ago_h' => '%s hours ago',
	'ago_d' => '%s days ago',

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
		array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'),
		array('Јануар','Фебруар','Март','Април','Мај','Јун','Јул','Август','Септембар','Октобар','Новембар','Децембар'),
		array('Sun','Mon','Tue','Wed','Thu','Fri','Sat'),
		array('Недеља','Понедељак','Уторак','Среда','Четвртак','Петак','Субота'),
		array(4=>'Y', 6=>'M Y', 8=>'D, M j, Y', 10=>'M d, Y - H:00', 12=>'M d, Y - H:i', 14=>'M d, Y - H:i:s'),
	),


	# GWF_Form
	'th_captcha1' => '<a href="http://en.wikipedia.org/wiki/Captcha">Captcha</a>', #<br/>Click the image to reload',
	'th_captcha2' => 'Укуцајте 5 слова са слике',
	'tt_password' => 'Шифра мора бити најмање 8 карактера дугачка.',
	'tt_captcha1' => 'Кликните на Слику да затражите нову.',
	'tt_captcha2' => 'Поново укуцајте слова са слике да потврдите да сте човек.',

	# GWF_Category
	'no_category' => 'Све Категорије',
	'sel_category' => 'Одабери Категорију',

	# GWF_Language
	'sel_language' => 'Одабери Језик',
	'unknown_lang' => 'Непознат Језик',

	# GWF_Country
	'sel_country' => 'Одабери Државу ',
	'unknown_country' => 'Непозната Држава',
	'alt_flag' => '%s',

	# GWF_User#gender
	'gender_male' => 'Мушко',
	'gender_female' => 'Женско',
	'gender_no_gender' => 'Непознат Пол',

	# GWF_User#avatar
	'alt_avatar' => '%s`s Avatar',

	# GWF_Group
	'sel_group' => 'Одабери Корисничку Групу',

	# Date select
	'sel_year' => 'Одабери Годину',
	'sel_month' => 'Одабери Месец',
	'sel_day' => 'Одабери Дан',
	'sel_older' => 'Старији Од',
	'sel_younger' => 'Млађи Од',

	### General Bits! ###
	'guest' => 'Guest',
	'unknown' => 'Unknown',
	'never' => 'Never',
	'search' => 'Search',
	'term' => 'Term',
	'by' => 'by',
	'and' => 'and',

	'alt_flag' => '%s Flag',

	# v2.01 (copyright)
	'copy' => '&copy; %s '.GWF_SITENAME.'. All rights reserved.',
	'copygwf' => GWF_SITENAME.' is using <a href="http://gwf.gizmore.org">GWF2</a>, the BSD-Like Website Framework.',

	# v2.02 (recaptcha+required_fields)
	'form_required' => '%s Обавезно попунити.',

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
	'yes' => 'Yes',
	'no' => 'No',
	
	# 2.06 spoiler
	'bbspoiler_info' => 'Click for spoiler',

	# 3.00 Filesize
	'filesize' => array('B','KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'YB', 'ZB'),
	'err_bb_level' => 'You need a userlevel of %s to see this content.',
);
?>
