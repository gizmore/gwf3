<?php
$lang = array(

	'ERR_DATABASE' => 'Database error in file %1% line %2%.',
	'ERR_FILE_NOT_FOUND' => 'File not found: %1%',
	'ERR_MODULE_DISABLED' => 'The module %1% is currently disabled.',
	'ERR_LOGIN_REQUIRED' => 'For this function you need to be logged in.',
	'ERR_NO_PERMISSION' => 'Permission denied.',
	'ERR_WRONG_CAPTCHA' => 'You have to type the letters from the picture correctly.',
	'ERR_MODULE_MISSING' => 'Module %1% could not been found.',
	'ERR_COOKIES_REQUIRED' => 'Your Session Timed Out or you need to enable cookies in your browser.<br/>Please try to refresh the page.',
	'ERR_UNKNOWN_USER' => 'The User is unknown.',
	'ERR_UNKNOWN_GROUP' => 'The Group is unknown.',
	'ERR_UNKNOWN_COUNTRY' => 'The Country is unknown.',
	'ERR_UNKNOWN_LANGUAGE' => 'This Language is unknown.',
	'ERR_METHOD_MISSING' => 'Unknown Method: %1% in Module %2%.',
	'ERR_GENERAL' => 'Undefined error in %1% Line %2%.',
	'ERR_WRITE_FILE' => 'Can not write file: %1%.',
	'ERR_CLASS_NOT_FOUND' => 'Unknown Class: %1%.',
	'ERR_MISSING_VAR' => 'Missing HTTP POST var: %1%.',
	'ERR_MISSING_UPLOAD' => 'You have to upload a file.',
	'ERR_MAIL_SENT' => 'There occured an error while sending you an email.',
	'ERR_CSRF' => 'Your formular token is invalid. Maybe you tried to double post, or your session ran out of time meanwhile.',
	'ERR_HOOK' => 'A hook returned false: %1%.',
	'ERR_PARAMETER' => 'Invalid argument in %1% line %2%. Function argument %3% is invalid.',
	'ERR_DEPENDENCY' => 'Unresolved Dependency: modules/%1%/method/%2% requires Module %3% v%4%.',
	'ERR_SEARCH_TERM' => 'The Search Term has to be %1% - %2% characters long.',
	'ERR_SEARCH_NO_MATCH' => 'Your search for &quot;%1%&quot; did not find a match.',
	'ERR_POST_VAR' => 'Unexpected POST var: %1%.',

	# GWF_Time
	'unit_sec_s' => 's',
	'unit_min_s' => 'm',
	'unit_hour_s' => 'h',
	'unit_day_s' => 'd',
	'unit_month_s' => 'M',
	'unit_year_s' => 'y',

	'M1' => 'January',
	'M2' => 'February',
	'M3' => 'March',
	'M4' => 'April',
	'M5' => 'May',
	'M6' => 'June',
	'M7' => 'July',
	'M8' => 'August',
	'M9' => 'September',
	'M10' => 'October',
	'M11' => 'November',
	'M12' => 'December',

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

	'D0' => 'Sunday',
	'D1' => 'Monday',
	'D2' => 'Tuesday',
	'D3' => 'Wednesday',
	'D4' => 'Thursday',
	'D5' => 'Friday',
	'D6' => 'Saturday',

	'd0' => 'Sun',
	'd1' => 'Mon',
	'd2' => 'Tue',
	'd3' => 'Wed',
	'd4' => 'Thu',
	'd5' => 'Fri',
	'd6' => 'Sat',

	'ago_s' => '%1% seconds ago',
	'ago_m' => '%1% minutes ago',
	'ago_h' => '%1% hours ago',
	'ago_d' => '%1% days ago',

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
		array('January','February','March','April','May','June','July','August','September','October','November','December'),
		array('Sun','Mon','Tue','Wed','Thu','Fri','Sat'),
		array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'),
		array(4=>'Y', 6=>'M Y', 8=>'D, M j, Y', 10=>'M d, Y - H:00', 12=>'M d, Y - H:i', 14=>'M d, Y - H:i:s'),
	),


	# GWF_Form
	'th_captcha1' => '<a href="http://en.wikipedia.org/wiki/Captcha">Captcha</a>', #<br/>Click the image to reload',
	'th_captcha2' => 'Write the 5 letters from the Captcha Image',
	'tt_password' => 'Passwords should be at least 8 characters long.',
	'tt_captcha1' => 'Click the captcha Image to request a new one.',
	'tt_captcha2' => 'Retype the image to proof you are a human.',

	# GWF_Category
	'no_category' => 'All Categories',
	'sel_category' => 'Select a Category',

	# GWF_Language
	'sel_language' => 'Select a Language',
	'unknown_lang' => 'Unknown Language',

	# GWF_Country
	'sel_country' => 'Select a Country',
	'unknown_country' => 'Unknown Country',
	'alt_flag' => '%1%',

	# GWF_User#gender
	'gender_male' => 'Male',
	'gender_female' => 'Female',
	'gender_no_gender' => 'Unknown Gender',

	# GWF_User#avatar
	'alt_avatar' => '%1%`s Avatar',

	# GWF_Group
	'sel_group' => 'Select a Usergroup',

	# Date select
	'sel_year' => 'Select Year',
	'sel_month' => 'Select Month',
	'sel_day' => 'Select Day',
	'sel_older' => 'Older than',
	'sel_younger' => 'Younger than',

	### General Bits! ###
	'guest' => 'Guest',
	'unknown' => 'Unknown',
	'never' => 'Never',
	'search' => 'Search',
	'term' => 'Term',
	'by' => 'by',
	'and' => 'and',

	'alt_flag' => '%1% Flag',

	# v2.01 (copyright)
	'copy' => '&copy; %1% '.GWF_SITENAME.'. All rights reserved.',
	'copygwf' => GWF_SITENAME.' is using <a href="http://gwf.gizmore.org">GWF</a>, the BSD-Like Website Framework.',

	# v2.02 (recaptcha+required_fields)
	'form_required' => '%1% means required.',

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
	'quote_from' => 'Quote from %1%',
	'code' => 'code',
	'for' => 'for',

	# 2.05 Bits
	'yes' => 'Yes',
	'no' => 'No',
	
	# 2.06 spoiler
	'bbspoiler_info' => 'Click for spoiler',
	
	# 3.00 Filesize
	'filesize' => array('B','KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'YB', 'ZB')
);

?>
