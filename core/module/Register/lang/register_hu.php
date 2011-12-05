<?php
$lang = array(
	'pt_register' => 'Regisztrálás itt: '.GWF_SITENAME,

	'title_register' => 'Regisztrálás',

	'th_username' => 'Felhasználói név',
	'th_password' => 'Jelszó',
	'th_email' => 'E-mail',
	'th_birthdate' => 'Születési dátum',
	'th_countryid' => 'Ország',
	'th_tos' => 'Elfogadom a<br/>felhasználási feltételeket',
	'th_tos2' => 'Elfogadom a<br/><a href="%s">felhasználási feltételeket</a>',
	'th_register' => 'Regisztrálás',

	'btn_register' => 'Regisztrálás',
	

	'err_register' => 'Hiba történt a regisztrálási folyamat közben.',
	'err_name_invalid' => 'Ez a felhasználói név érvénytelen.',
	'err_name_taken' => 'Ez a felhasználói név már foglalt.',
	'err_country' => 'A választott ország érvénytelen.',
	'err_pass_weak' => 'Túl gyenge jelszó. <b>Fontos jelszavakat sose használj több helyen.</b>.',
	'err_token' => 'Érvénytelen aktiválási kód. Talán már aktiválva vagy.',
	'err_email_invalid' => 'Érvénytelen e-mail cím.',
	'err_email_taken' => 'Ezt az e-mail címet már valaki más használja.',
	'err_activate' => 'Hiba történt az aktiváció során.',
		
	'msg_activated' => 'Sikeres aktiválás. Próbálj meg belépni.',
	'msg_registered' => 'Köszönjük, hogy regisztráltálT.',

	'regmail_subject' => 'Regisztráció : '.GWF_SITENAME,
	'regmail_body' => 
		'Hello %s<br/>'.
		'<br/>'.
		'Köszönjük hogy regisztráltál a(z) '.GWF_SITENAME.' oldalra.<br/>'.
		'A regisztráció befejezéséhez először aktiválnod kell a fiókot. Ezt úgy teheted meg, hogy az alábbi URL-t meglátogatod.<br/>'.
		'Ha nem regisztráltál a(z) '.GWF_SITENAME.' oldalon, hagyd figyelmen kívül vagy lépj kapcsolatba velünk: '.GWF_SUPPORT_EMAIL.'.<br/>'.
		'<br/>'.
		'%s<br/>'.
		'<br/>'.
		'%s'.
		'Üdvözlettel,<br/>'.
		'A(z) '.GWF_SITENAME.' csapata.',
	'err_tos' => 'Hiba: Egyet kell értened az EULA-val a regisztrációhoz.',

	'regmail_ptbody' => 
		'A belépési adataid:<br/><b>'.
		'Felhasználói név: %s<br/>'.
		'Jelszó: %s<br/>'.
		'</b><br/>'.
		'Jó ötlet törölni ezt az e-mailt és a jelszót máshol tárolni.<br/>'.
		'Mi sem tároljuk a jelszavad nyílt szöveges formában, így te se tedd ezt.<br/>'.
		'<br/>',

	### Admin Config ###
	'cfg_auto_login' => 'Automatikus belépés aktiválás után',	
	'cfg_captcha' => 'CAPTCHA a regisztrációhoz',
	'cfg_country_select' => 'Mutasd a választható országokat',
	'cfg_email_activation' => 'E-mail regisztráció',
	'cfg_email_twice' => 'Kétszer regisztráljam ugyanazt az e-mail címet?',
	'cfg_force_tos' => 'Mutasd a TOS-t',
	'cfg_ip_usetime' => 'IP időtúllépés a többszörös regisztrációnál',
	'cfg_min_age' => 'Minimum év / Születésnap választó',
	'cfg_plaintextpass' => 'Jelszó küldése nyílt szöveges formában az e-mailben',
	'cfg_activation_pp' => 'Admin oldalankénti aktivációk száma',
	'cfg_ua_threshold' => 'Félbeszakadt regisztráció befejezése ennyi idő után:',

	'err_birthdate' => 'Érvénytelen születési dátum.',
	'err_minage' => 'Sajnáljuk, de nem vagy elég idős ahhoz, hog regisztrálj. Legalább %s évesnek kell lenned.',
	'err_ip_timeout' => 'Valaki nemrég regisztrált egy fiókot ezzel az IP-vel.',
	'th_token' => 'Token',
	'th_timestamp' => 'Regisztráció ideje',
	'th_ip' => 'Regisztrációs IP',
	'tt_username' => 'A felhasználói névnek betűvel kell kezdődnie.'.PHP_EOL.'Csak betűt, számot és alulvonást tartalmazhat. Length has to be 3 - %s chars.', 
	'tt_email' => 'Érvényes e-mail cím szükséges a regisztrációhoz.',

	'info_no_cookie' => 'A böngésződ vagy nem támogatja a sütiket, nincs engedélyezve a(z) '.GWF_SITENAME.' oldal számára, pedig a sütik nélkül nem tudod használni az oldalt.',


	# v2.01 (fixes)
	'msg_mail_sent' => 'Egy E-mailt küldtünk neked, amiben benne van, hogyan tudod aktiválni a fiókodat.',

	# v2.02 (Detect Country)
	'cfg_reg_detect_country' => 'Ország automatikus felismerése',

	# v2.03 (Links)
	'btn_login' => 'Bejelentkezés',
	'btn_recovery' => 'Jelszó visszaállítás',
	# v2.04 (Fixes)
	'tt_password' => 'Your password can be chosen freely. Please do not re-use important passwords. Consider a short phrase as password.',
	# v2.05 (Blacklist)
	'err_domain_banned' => 'Your email provider is on the blacklist.',
);
?>