<?php

$lang = array(

	'page_title' => 'Kontakt '.GWF_SITENAME,
	'page_meta' => 'Foo',

	'contact_title' => 'Kontakt',
	'contact_info' =>
		'Siin saad meiega kontakteeruda läbi e-maili. Palun avalda meile õige e-mail, siis me saame vajaduse korral sulle vastata.<br/>'.
		'Samuti võid saata sa meile ka meili <a href="mailto:%s">%s</a> mõne teise programmiga.',
	'form_title' => 'PEALKIRI',
	'th_email' => 'Sinu e-mail',
	'th_message' => 'Sinu sõnum',
	'btn_contact' => 'Saada meile kiri',

	'mail_subj' => GWF_SITENAME.': Uus kiri',
	'mail_body' => 
		'Uus e-mail saadetud.<br/>'.PHP_EOL.
		'Kellelt: %s<br/>'.PHP_EOL.
		'Sõnum:<br/>'.PHP_EOL.
		'%s<br/>'.PHP_EOL.
		'',

	'info_skype' => '<br/>Sa võid meiega ka ühendust võtta läbi Skype’i: %s.',

	'err_email' => 'Vigane e-mail. Sa võid selle kasti tühjaks jätta.',
	'err_message' => 'Sinu sõnum on liiga pikk või liiga lühike.',

	# Admin Config
	'cfg_captcha' => 'Kasuta Captcha',	
	'cfg_email' => 'Saada sõnumid (email)',
	'cfg_icq' => 'ICQ Kontakti andmed',
	'cfg_skype' => 'Skype kontakti andmed',
	'cfg_maxmsglen' => 'Maksimaalne sõnumi pikkus',

	# Sendmail
	'th_user_email' => 'Sinu e-maili aadress',
	'ft_sendmail' => 'Saada %s e-mail',
	'btn_sendmail' => 'Saada meil',
	'err_no_mail' => 'See kasutaja ei taha saada e-maile.',
	'msg_mailed' => 'E-mail on saadetud %s.',
	'mail_subj_mail' => GWF_SITENAME.': EMail from %s',
	'mail_subj_body' => 
		'Hello %s'.PHP_EOL.
		PHP_EOL.
		'Teile on sõnum %s poolt leheküljelt '.GWF_SITENAME.' lehekülg:'.PHP_EOL.
		PHP_EOL.
		PHP_EOL.
		'%s',

	# V2.01 (List Admins)
	'list_admins' => 'Adminid: %s.',
	'cfg_captcha_member' => 'Show captcha for members?',
);

?>