<?php

$lang = array(

	'pt_login' => 'Přihlášení do '.GWF_SITENAME,
	'title_login' => 'Přihášení',
	
	'th_username' => 'Uživatelské jméno',
	'th_password' => 'Heslo',
	'th_login' => 'Přihlášení',
	'btn_login' => 'Přihlásit',

	'err_login' => 'Neznámé uživatelské jméno',
	'err_login2' => 'Špatné heslo. Máš ještě %1% pokusů, potom ti bude zablokovaný přístup na %2%.',
	'err_blocked' => 'Před dalším pokusem je potřeba počkat %1%.',

	'welcome' => 
		'Vítej na '.GWF_SITENAME.', %1%.<br/><br/>'.
		'Doufáme, že se ti naše stránky líbí a užíváš si jejich prohlížení.<br/>'.
		'Pokud máš nějaké otázky, neváhej nás kontaktovat!',

	'welcome_back' => 
		'Vítej zpátky na '.GWF_SITENAME.', %1%.<br/><br/>'.
		'Tvoje poslední aktivita byla %2% z této IP: %3%.',

	'logout_info' => 'Nyní jsi odhlášený.',

	# Admin Config
	'cfg_captcha' => 'Use Captcha?',	
	'cfg_max_tries' => 'Maximum Login Tries',	
	'cfg_try_exceed' => 'within this Duration',

	'info_no_cookie' => 'Tvůj prohlížeč nepodporuje cookies nebo nejsou povoleny pro '.GWF_SITENAME.', cookies jsou potřeba pro přihlášení.',
	
	'th_bind_ip' => 'Omezení Session na tuto IP',
	'tt_bind_ip' => 'Zabezpečení, které má bránit krádeži cookie.',

	'err_failures' => 'Bylo provedeno %1% neúspešných pokusů k přihlášení, tvůj účet může být předmětem neúspěsného útoku.',

	# v1.01 (login failures)
	'cfg_lf_cleanup_i' => 'Cleanup user failures after login?',
	'cfg_lf_cleanup_t' => 'Cleanup old failures after time',

	# v2.00 (login history)
	'msg_last_login' => 'Tvoje poslední přihlášení bylo %1% z %2% (%3%).<br/>Také si můžes prohlédnout <a href="%4%">historii přihlášení</a>.',
	'th_loghis_time' => 'Datum',
	'th_loghis_ip' => 'IP',
	'th_hostname' => 'Hostname',

	# v2.01 (clear hist)
	'ft_clear' => 'Clear login history',
	'btn_clear' => 'Clear',
	'msg_cleared' => 'Your login history has been cleared.',
	'info_cleared' => 'Your login history was last cleared at %1% from this IP: %2% / %3%',
);

?>