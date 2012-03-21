<?php
$lang = array(

	'pt_login' => 'Kirjaudu sisään kohteeseen '.GWF_SITENAME,
	'title_login' => 'Kirjaudu sisään',
	
	'th_username' => 'Käyttäjänimi',
	'th_password' => 'Salasana',
	'th_login' => 'Kirjautuminen',
	'btn_login' => 'Kirjautuminen',
	'btn_register' => 'Register',
	'btn_recovery' => 'Recovery',

	'err_login' => 'Tuntematon käyttäjänimi',
	'err_login2' => 'Väärä salasana. Sinulla on %s yritystä jäljellä ennen kuin sinut estetään seuraavaksi ajaksi: %s.',
	'err_blocked' => 'Ole hyvä ja odota %s ennen kuin yrität uudestaan.',

	'welcome' => 
		'Tervetuloa '.GWF_SITENAME.'-sivuille, %s.<br/><br/>'.
		'Toivottavasti pidät sivuistamme ja selaaminen on hauskaa.<br/>'.
		'Mikäli sinulla on jotakin kysyttävää, älä epäröi kysyä meiltä!',

	'welcome_back' => 
		'Tervetuloa takaisin '.GWF_SITENAME.'-sivuille, %s.<br/><br/>'.
		'Viimeisin toimintasi oli %s IP-osoitteesta: %s.',

	'logout_info' => 'Olet nyt kirjautunut ulos.',

	# Admin Config
	'cfg_captcha' => 'Käytä Captchaa?',	
	'cfg_max_tries' => 'Kirjautumisyritysen enimmäismäärä',	
	'cfg_try_exceed' => 'tämän ajan sisällä',

	'info_no_cookie' => 'Selaimesi ei tue keksejä (Cookies), tai ei salli niitä '.GWF_SITENAME.'-sivuilla, mutta kirjautuminen vaatii keksit',
	
	'th_bind_ip' => 'Rajoita istunto tähän IP-osoitteeseen',
	'tt_bind_ip' => 'Turvatoimi keksivarkaiden varalle.',

	'err_failures' => 'On tapahtunut %s epäonnistunutta kirjautumista ja saatat olla epäonnistuneen tai tulevan hyökkäyksen kohde.',

	# v1.01 (login failures)
	'cfg_lf_cleanup_i' => 'Puhdista käyttäjän epäonnistumiset kirjautumisen jälkeen?',
	'cfg_lf_cleanup_t' => 'Puhdista vanhat epäonnistumiset tietyn ajan kuluttua',

	# v2.00 (login history)
	'msg_last_login' => 'Viimeisin kirjautumisesi oli %s from %s (%s).<br/>Voit myös <a href="%s">tarkistaa kirjautumishistoriasi täältä</a>.',
	'th_loghis_time' => 'Päiväys',
	'th_loghis_ip' => 'IP ',
	'th_hostname' => 'Hostname ',

	# v2.01 (clear hist)
	'ft_clear' => 'Clear login history',
	'btn_clear' => 'Clear',
	'msg_cleared' => 'Your login history has been cleared.',
	'info_cleared' => 'Your login history was last cleared at %s from this IP: %s / %s',

	# v2.02 (email alerts)
	'alert_subj' => GWF_SITENAME.': Login failures',
	'alert_body' =>
		'Dear %s,'.PHP_EOL.
		PHP_EOL.
		'There was a failed login attempt from this IP: %s.'.PHP_EOL.
		PHP_EOL.
		'We just let you know.'.PHP_EOL.
		PHP_EOL.
		'Sincerely,'.
		PHP_EOL.
		'The '.GWF_SITENAME.' script',
		
	# monnino fixes
	'cfg_send_alerts' => 'Send alerts',
	'err_already_logged_in' => 'You are already logged in.',
);
?>