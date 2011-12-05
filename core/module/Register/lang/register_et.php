<?php

$lang = array(
	'pt_register' => 'Registreeri '.GWF_SITENAME,

	'title_register' => 'Registreeri',

	'th_username' => 'Kasutajanimi',
	'th_password' => 'Salasõna',
	'th_email' => 'E-mail',
	'th_birthdate' => 'Sünniaeg',
	'th_countryid' => 'Riik',
	'th_tos' => 'Ma nõustun <br/>Kasutustingimustega',
	'th_tos2' => 'Ma nõustun <br/><a href="%s">Kasutustingimustega</a>',
	'th_register' => 'Registreeri',

	'btn_register' => 'Registreeri',
	

	'err_register' => 'Registreerimisel ilmes viga.',
	'err_name_invalid' => 'Teie valitud kasutajanimi on ebasobiv.',
	'err_name_taken' => 'Kasutajanimi on juba registreeritud.',
	'err_country' => 'Teie valitud kasutajanimi on ebasobiv.',
	'err_pass_weak' => 'Teie salasõna on liiga nõrk. Samuti, <b>ärge kasutage olulisi paroole mitmes kohas</b>.',
	'err_token' => 'Teie aktiveerimiskood on vigane. Võib-olla on teie kasutaja juba aktiveeritud.',
	'err_email_invalid' => 'Teie e-mail on vigane.',
	'err_email_taken' => 'Teie e-mail on juba registreeritud.',
	'err_activate' => 'Aktiveerimisel ilmes viga.',
		
	'msg_activated' => 'Teie kasutaja on nüüd aktiveeritud. Palun proovige nüüd sisse logida.',
	'msg_registered' => 'Aitäh, et registreerusite.',

	'regmail_subject' => 'Registreeri '.GWF_SITENAME,
	'regmail_body' => 
		'Tere %s<br/>'.
		'<br/>'.
		'Täname registreerimast '.GWF_SITENAME.'.<br/>'.
		'Et lõpetada registreerimine, peate te oma kasutaja aktiveerima, külastades allolevat linki.<br/>'.
		'Kui sa ei registreerinud leheküljel '.GWF_SITENAME.', palun ignoreeri seda kirja või kontakteeru meiega '.GWF_SUPPORT_EMAIL.'.<br/>'.
		'<br/>'.
		'%s<br/>'.
		'<br/>'.
		'%s'.
		'Siirad tervitused,<br/>'.
		'The '.GWF_SITENAME.' Meeskond.',
	'err_tos' => 'Te peate nõustuma EULA-ga.',

	'regmail_ptbody' => 
		'Teie sisselogimisandmed on:<br/><b>'.
		'kasutajanimi: %s<br/>'.
		'Salasõna: %s<br/>'.
		'</b><br/>'.
		'On hea mõte kustutada see e-mail ning salvestada oma parool teise kohta.<br/>'.
		'Me ei salvesta oma paroole tekstina, ka teie ei tohiks seda teha.<br/>'.
		'<br/>',

	### Admin Config ###
	'cfg_auto_login' => 'Automaatne sisselogimine pärast aktiveerimist',	
	'cfg_captcha' => 'Captcha registreerimiseks',
	'cfg_country_select' => 'Näita riigivalikut',
	'cfg_email_activation' => 'E-maili registreerimine',
	'cfg_email_twice' => 'Registreeri sama e-maili kaks korda?',
	'cfg_force_tos' => 'Näita sunnitud TOS',
	'cfg_ip_usetime' => 'IP aegus mitmik-registreerimisel',
	'cfg_min_age' => 'Minimaalne vanus / Sünnikuupäeva valik',
	'cfg_plaintextpass' => 'Saada parool e-maili tekstina',
	'cfg_activation_pp' => 'Aktiveerimis Admini lehe kohta',
	'cfg_ua_threshold' => 'Aegumine, et lõpetada registreerimineation',

	'err_birthdate' => 'Teie sünnikuupäev on vigane.',
	'err_minage' => 'Meil on kahju, kuid sa ei ole piisavalt vana, et registreerida. Sa pead olema vähemalt %s aastat vana.',
	'err_ip_timeout' => 'Keegi on hiljuti sellelt IP-lt juba kasutaja registreerinud.',
	'th_token' => 'Märk',
	'th_timestamp' => 'Registreerimise aeg',
	'th_ip' => 'Registreerimise IP',
	'tt_username' => 'Kasutajanimi peab algama tähega.'.PHP_EOL.'See võib sisaldada ainult tähti, numbreid ning alljooni. Pikkus peab olema 3-%s tähte.', 
	'tt_email' => 'Registreerimiseks on vaja tõest e-maili.',

	'info_no_cookie' => 'Teie brauser ei toeta küpsiseid või ei ole need lubatud '.GWF_SITENAME.' jaoks, kuid küpsised peavad olema sisselogimiseks lubatud.',

	# v2.01 (fixes)
	'msg_mail_sent' => 'E-mail kasutaja aktiveerimise instruktsioonidega on saadetud teie poolt sisestatud e-mailile.',

	# v2.02 (Detect Country)
	'cfg_reg_detect_country' => 'Always auto-detect country',

	# v2.03 (Links)
	'btn_login' => 'Login',
	'btn_recovery' => 'Password recovery',
	# v2.04 (Fixes)
	'tt_password' => 'Your password can be chosen freely. Please do not re-use important passwords. Consider a short phrase as password.',
	# v2.05 (Blacklist)
	'err_domain_banned' => 'Your email provider is on the blacklist.',
);
?>