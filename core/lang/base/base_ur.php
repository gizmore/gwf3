<?php
$lang = array(
	'ERR_DATABASE' => 'فائل %s کی لائن %s میں ڈیٹابیس ایرر',
	'ERR_FILE_NOT_FOUND' => 'فائل نہیں ملی: %s ۔',
	'ERR_MODULE_DISABLED' => 'ماڈیول %s فی الحال ڈس ایبل ہے',
	'ERR_LOGIN_REQUIRED' => 'اس کام کے لئے آپ کو لاگ ان ہونا پڑے گا',
	'ERR_NO_PERMISSION' => 'اجازت نہیں ہے',
	'ERR_WRONG_CAPTCHA' => 'تصویر دیکھ اسکے مطابق درست الفاظ درج کیجئے',
	'ERR_MODULE_MISSING' => 'ماڈیول %s نہیں مل سکا',
	'ERR_COOKIES_REQUIRED' => 'براہ مہربانی صفحہ کو ریفریش کیجئے۔<br/>یاآپ کا سیشن ایکسپائر ہو گیا ہے یا پھر آپ کو براوزر میں کوکیز کو بحال کرنا پڑے گا۔',
	'ERR_UNKNOWN_USER' => 'نامعلوم استعمال کنندہ۔',
	'ERR_UNKNOWN_GROUP' => 'نامعلوم گروپ۔',
	'ERR_UNKNOWN_COUNTRY' => 'نامعلوم ملک۔',
	'ERR_UNKNOWN_LANGUAGE' => 'یہ زبان نامعلوم ہے۔',
	'ERR_METHOD_MISSING' => 'نامعلوم میتھڈ: ماڈیول %s میں %s ۔',
	'ERR_GENERAL' => 'فائل %s کی لائن %s میں نامعلوم ایرر',
	'ERR_WRITE_FILE' => 'Can not write file: %s.',
	'ERR_CLASS_NOT_FOUND' => 'نامعلوم کلاس: %s ۔',
	'ERR_MISSING_VAR' => 'ویری ایبل ناموجود: %s ۔ HTTP POST',
	'ERR_MISSING_UPLOAD' => 'فائل اپ لوڈ کیجئے۔',
	'ERR_MAIL_SENT' => 'آپ کو ای میل بھیجنے کے دوران ایک ایرر آگیا۔',
	'ERR_CSRF' => 'آپ کا فورم ٹوکن ناقابل شناخت ہے، شاید آپ نے ایک ہی پوسٹ دوبارہ کرنے کی کوشش کی ہے یا پھر اس دوران آپ کا سیشن ایکسپائر ہو گیا ہے۔',
	'ERR_HOOK' => 'A hook returned false: %s.',###TODO
	'ERR_PARAMETER' => 'کی لائن %s  میں ناقابل شناخت آرگیومنٹ۔ فنکشن آرگیومنٹ %s  ناقابل شناخت ہے۔۔	%s',
	'ERR_DEPENDENCY' => 'کمزور تابعیت: ماڈیول %s کے میتھڈ %s  کو %s اور %s ماڈیول چاہئیں۔',
	'ERR_SEARCH_TERM' => ' %s - %s تلاش کے لئے دئیے گئے کم از کم الفاظ کی تعداد ',
	'ERR_SEARCH_NO_MATCH' => 'کا کوئی نتیجہ نہیں نکلا &quot;%s&quot; آپکی تلاش برائے',
	'ERR_POST_VAR' => 'ویری ایبل غیر متوقع: %s ۔ POST',
	'ERR_DANGEROUS_UPLOAD' => 'Your uploaded file contains &quot;&lt;?&quot; which is considered dangerous and denied.',

	# GWF_Time
	'unit_sec_s' => 's',
	'unit_min_s' => 'm',
	'unit_hour_s' => 'h',
	'unit_day_s' => 'd',
	'unit_month_s' => 'M',
	'unit_year_s' => 'y',

	'M1' => 'جنوری',
	'M2' => 'فروری',
	'M3' => 'مارچ',
	'M4' => 'اپریل',
	'M5' => 'مئِ',
	'M6' => 'جون',
	'M7' => 'جولائ',
	'M8' => 'اگست',
	'M9' => 'ستمبر',
	'M10' => 'اکتوبر',
	'M11' => 'نومبر',
	'M12' => 'دسمبر',

	'm1' => 'جنوری',
	'm2' => 'فروری',
	'm3' => 'مارچ',
	'm4' => 'اپریل',
	'm5' => 'مئِ',
	'm6' => 'جون',
	'm7' => 'جولائی',
	'm8' => 'اگست',
	'm9' => 'ستمبر',
	'm10' => 'اکتوبر',
	'm11' => 'نومبر',
	'm12' => 'دسمبر',

	'D0' => 'اتوار',
	'D1' => 'سوموار',
	'D2' => 'منگل',
	'D3' => 'بدھ',
	'D4' => 'جمعرات',
	'D5' => 'جمعہ',
	'D6' => 'ہفتہ',

	'd0' => 'اتوار',
	'd1' => 'سوموار',
	'd2' => 'منگل',
	'd3' => 'بدھ',
	'd4' => 'جمعرات',
	'd5' => 'جمعہ',
	'd6' => 'ہفتہ',

	'ago_s' => '%s seconds ago','سیکنڈ پہلے۔	%s',
	'ago_m' => '%s minutes ago','منٹ پہلے۔	%s',
	'ago_h' => '%s hours ago','گھنٹے پہلے۔	%s',
	'ago_d' => '%s days ago','دن پہلے۔	%s',

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
		array('جنوری','فروری','مارچ','اپریل','مئِ','جون','جولائی','اگست','ستمبر','اکتوبر','نومبر','دسمبر'),
		array('جنوری','فروری','مارچ','اپریل','مئِ','جون','جولائ','اگست','ستمبر','اکتوبر','نومبر','دسمبر'),
		array('اتوار','سوموار','منگل','بدھ','جمعرات','جمعہ','ہفتہ'),
		array('اتوار','سوموار','منگل','بدھ','جمعرات','جمعہ','ہفتہ'),
		array(4=>'Y', 6=>'M Y', 8=>'D, M j, Y', 10=>'M d, Y - H:00', 12=>'M d, Y - H:i', 14=>'M d, Y - H:i:s'),
	),

	# GWF_Form
	'th_captcha1' => '<a href="http://en.wikipedia.org/wiki/Captcha">Captcha</a>', #<br/>Click the image to reload',
	'th_captcha2' => 'کاپچا تصویر سے پانچ حروف لکھئے۔',
	'tt_password' => 'پاسورڈ کم از کم آٹھ حروف لمبا ہونا چاہئے۔',
	'tt_captcha1' => 'نئی کاپچا تصویر کے لئے کاپچا تصویر پر کلک کیجئے۔',
	'tt_captcha2' => 'تصدیق کے لئے تصویر پر موجود حروف کو دوبارہ ٹائپ کیجئے۔',

	# GWF_Category
	'no_category' => 'تمام درجات',
	'sel_category' => 'ایک درجہ منتخب کیجئے',

	# GWF_Language
	'sel_language' => 'زبان منتخب کیجئے',
	'unknown_lang' => 'نامعلوم زبان',

	# GWF_Country
	'sel_country' => 'ملک منتخب کیجئے',
	'unknown_country' => 'نامعلوم ملک',
	'alt_flag' => '%s',

	# GWF_User#gender
	'gender_male' => 'مذکر',
	'gender_female' => 'مونث',
	'gender_no_gender' => 'جنس نامعلوم',

	# GWF_User#avatar
	'alt_avatar' => 'کا اوتار	%s',

	# GWF_Group
	'sel_group' => 'ایک یوزر گروپ منتخب کیجئے',

	# Date select
	'sel_year' => 'سال منتخب کیجئے',
	'sel_month' => 'مہینہ منتخب کیجئے',
	'sel_day' => 'دن منتخب کیجئے',
	'sel_older' => 'سے بڑا',
	'sel_younger' => 'سے چھوٹا',

	### General Bits! ###
	'guest' => 'مہمان',
	'unknown' => 'نامعلوم',
	'never' => 'کبھی نہیں',
	'search' => 'تلاش',
	'term' => 'Term',
	'by' => 'by',
	'and' => 'اور',

	'alt_flag' => '%s Flag',

	# v2.01 (copyright)
	'copy' => '&copy; %s '.GWF_SITENAME.'. جملہ حقوق محفوظ',
	'copygwf' => GWF_SITENAME.' استعمال کر رہا ہے <a href="http://gwf.gizmore.org">GWF</a>, کی طرح کا ویب سائیٹ فریم ورک BSD-Like',

	# v2.02 (recaptcha+required_fields)
	'form_required' => 'کا مطلب ہے، ضروری	%s',

	# v2.03 BBCode
	'bbhelp_b' => 'دبیز تحریر',
	'bbhelp_i' => 'ترچھی تحریر',
	'bbhelp_u' => 'خط کشیدہ تحریر',
	'bbhelp_code' => 'یہاں کوڈ لکھا جائے گا۔',
	'bbhelp_quote' => 'یہ والی تحریر ایک اقتباس ہے۔',
	'bbhelp_url' => 'تحریر کو لنک کریں۔',
	'bbhelp_email' => 'ای میل کے لنک کے لئے تحریر۔',
	'bbhelp_noparse' => 'یہاں سے بی بی- ڈیکوڈنگ کو ڈس ایبل کیجئے۔',
	'bbhelp_level' => 'وہ تحریر جسے دیکھنے کے لئے استعمال کنندہ کا کم از کم کسی خاص درجہ کا حامل ہونا ضروری ہو۔',
	'bbhelp_spoiler' => 'غیر مرئی تحریر جو کہ کلک کرنے سے نظر آئے گی۔',

	# v2.04 BBCode3
	'quote_from' => 'سے اقتباس	%s',
	'code' => 'کوڈ',
	'for' => 'برائے',

	# 2.05 Bits
	'yes' => 'جی ہاں',
	'no' => ' نہیں',

	# 2.06 spoiler
	'bbspoiler_info' => 'Click for spoiler',

	# 3.00 Filesize
	'filesize' => array('B','KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'YB', 'ZB'),
	'err_bb_level' => 'You need a userlevel of %s to see this content.',
);
