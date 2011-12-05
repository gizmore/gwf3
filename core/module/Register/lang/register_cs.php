<?php
$lang = array(
	'pt_register' => 'Registrace na '.GWF_SITENAME,

	'title_register' => 'Registrace',

	'th_username' => 'Uživatelské jméno',
	'th_password' => 'Heslo',
	'th_email' => 'Email',
	'th_birthdate' => 'Datum narození',
	'th_countryid' => 'Stát',
	'th_tos' => 'Souhlasím s <br/>Podmínkami používání',
	'th_tos2' => 'Souhlasím s <br/><a href="%s">Podmínky používání</a>',
	'th_register' => 'Registrace',

	'btn_register' => 'Registrovat',
	

	'err_register' => 'Během registračního procesu došlo k chybě.',
	'err_name_invalid' => 'Vybrané uživatelské jméno je neplatné.',
	'err_name_taken' => 'Uživatelské jméno je již používáno.',
	'err_country' => 'Vybraný stát je neplatný.',
	'err_pass_weak' => 'Zadané heslo je příliš slabé. <b>Nepoužívej opětovně důležitá hesla?/b>.',
	'err_token' => 'Aktivační kód je neplatný. Účet je možná už aktivován.',
	'err_email_invalid' => 'Zadaný email je neplatný.',
	'err_email_taken' => 'Zadaný email se už používá.',
	'err_activate' => 'Během aktivace došlo k chybě.',
		
	'msg_activated' => 'Tvůj účet je aktivován. Nyní je možné se přihlásit.',
	'msg_registered' => 'Děkujeme za registraci.',

	'regmail_subject' => 'Registrace na '.GWF_SITENAME,
	'regmail_body' => 
		'Ahoj %s<br/>'.
		'<br/>'.
		'Děkujeme za registraci na '.GWF_SITENAME.'.<br/>'.
		'Pro dokončení registrace je potřeba aktivovat tvůj účet navštívením odkazu uvedeného níže.<br/>'.
		'Pokud ses neregistroval na '.GWF_SITENAME.', tak tento email ignoruj nebo nás kontaktuj na '.GWF_SUPPORT_EMAIL.'.<br/>'.
		'<br/>'.
		'%s<br/>'.
		'<br/>'.
		'%s'.
		'S pozdravem,<br/>'.
		GWF_SITENAME.' Team.',
	'err_tos' => 'Je nutné souhlasit s EULA.',

	'regmail_ptbody' => 
		'Údaje pro přihlášení:<br/><b>'.
		'Uživatelské jméno: %s<br/>'.
		'Heslo: %s<br/>'.
		'</b><br/>'.
		'Tento email je dobré smazat a uložit si heslo někde jinde.<br/>'.
		'Hesla neukládáme v otevřené podobě, doporučujeme dělat to samé.<br/>'.
		'<br/>',

	### Admin Config ###
	'cfg_auto_login' => 'AutoLogin after Activation',	
	'cfg_captcha' => 'Captcha for Register',
	'cfg_country_select' => 'Show country select',
	'cfg_email_activation' => 'Email registration',
	'cfg_email_twice' => 'Register same email twice?',
	'cfg_force_tos' => 'Show a forced TOS',
	'cfg_ip_usetime' => 'IP timeout for multi-register',
	'cfg_min_age' => 'Minimum age / Birthday selector',
	'cfg_plaintextpass' => 'Send Password to email in Plaintext',
	'cfg_activation_pp' => 'Activations per Admin Page',
	'cfg_ua_threshold' => 'Timeout for completing registration',

	'err_birthdate' => 'Zadaný datum narození je neplatný.',
	'err_minage' => 'Je nám líto, ale nejsi dostatečně starý, aby ses mohl registrovat. Musíš být minimálně %s let starý.',
	'err_ip_timeout' => 'Někdo se nedávno registroval z této IP.',
	'th_token' => 'Token',
	'th_timestamp' => 'Čas registrace',
	'th_ip' => 'Reg IP',
	'tt_username' => 'Uživatelské jméno musí začínat písmenem.'.PHP_EOL.'Může obsahovat jen písmena, číslice a podtržítko. Délka musí být 3 - %s znaků.', 
	'tt_email' => 'Pro registraci je vyžadován platný email.',

	'info_no_cookie' => 'Tvůj prohlížeč nepodporuje cookies nebo nejsou povoleny pro '.GWF_SITENAME.', cookies jsou potřeba pro přihlášení.',

	# v2.01 (fixes)
	'msg_mail_sent' => 'Email s instrukcemi jak aktivovat účet byl odeslán.',

	# v2.02 (Detect Country)
	'cfg_reg_detect_country' => 'Always auto-detect country',

	# v2.03 (Links)
	'btn_login' => 'Přihlásit',
	'btn_recovery' => 'Obnovení hesla',
	# v2.04 (Fixes)
	'tt_password' => 'Your password can be chosen freely. Please do not re-use important passwords. Consider a short phrase as password.',
	# v2.05 (Blacklist)
	'err_domain_banned' => 'Your email provider is on the blacklist.',
);
?>