<?php

$lang = array(

	'page_title' => 'kontakti '.GWF_SITENAME,
	'page_meta' => 'Foo',

	'contact_title' => 'kontakti',
	'contact_info' =>
		'Täällä voit ottaa meihin yhteyttä sähköpostitse. Pyydän teitä antamaan voimassa olevavan sähköpostiosoiteen, jotta voimme lähettää sinulle vastauksen, haluttaessa.<br/>'.
		'Voit lähettää myös sähköpostin tänne <a href="mailto:%s">%s</a> Millä tahansa muulla sähköposti ohjelmalla.',
	'form_title' => 'Ota meihin yhteyttä',
	'th_email' => 'sinun EMail',
	'th_message' => 'Sinun viesti',
	'btn_contact' => 'lähetä meille Mailia',

	'mail_subj' => GWF_SITENAME.': uusi yhteys EMail',
	'mail_body' => 
		'Uusi sähköposti on lähettänyt yhteydenottolomakkeella.<br/>'.PHP_EOL.
		'From: %s<br/>'.PHP_EOL.
		'Message:<br/>'.PHP_EOL.
		'%s<br/>'.PHP_EOL.
		'',

	'info_skype' => '<br/>Voit myös ottaa meihin yhteyttä skypellä: %s.',

	'err_email' => 'Sähköpostiosoitteesi ei kelpaa. Voit jättää kentän tyhjäksi, jos haluat.',
	'err_message' => 'Viestisi on liian lyhyt tai pitkä.',

	# Admin Config
	'cfg_captcha' => 'Käytä Captchaa',
	'cfg_email' => 'Lähettää viestejä(sähköpostiin)',
	'cfg_icq' => 'ICQ Kontakti tiedot',
	'cfg_skype' => 'Skype kontakti tiedot',
	'cfg_maxmsglen' => 'Maksimi. Viestin pituus',

	# Sendmail
	'th_user_email' => 'Sinun sähköposti osoite',
	'ft_sendmail' => 'Lähetä %s sähköpostia',
	'btn_sendmail' => 'Lähetä Sähköpostia',
	'err_no_mail' => 'Tämä käyttäjä ei halua sähköpostia.',
	'msg_mailed' => 'Sähköposti lähetetty %s.',
	'mail_subj_mail' => GWF_SITENAME.': Sait sähköpostia %s',
	'mail_subj_body' => 
		'Terve %s'.PHP_EOL.
		PHP_EOL.
		'Siellä on sähköpostia lähetetty sinulle %s  '.GWF_SITENAME.' website:'.PHP_EOL.
		PHP_EOL.
		PHP_EOL.
		'%s',

	# V2.01 (List Admins)
	'list_admins' => 'Adminit: %s.',
	'cfg_captcha_member' => 'Show captcha for members?',
);

?>