<?php
$lang = array(
	'pt_login' => 'Lidhem me '.GWF_SITENAME,
	'title_login' => 'Lidhem',
	
	'th_username' => 'Emri i përdoruesit',
	'th_password' => 'Fjalëkalim',
	'th_login' => 'Lidhem',
	'btn_login' => 'Lidhem',
	'btn_register' => 'Register',
	'btn_recovery' => 'Recovery',

	'err_login' => 'Emri i përdoruesit Panjohur',
	'err_login2' => 'Falsches Passwort. Keni %s Përpjekjet para llogari për %s do të bllokohet.',
	'err_blocked' => 'Ju lutem prisni %s përpara se të provoni përsëri.',

	'welcome' => 
		'Mirë se vini në'.GWF_SITENAME.', %s.<br/><br/>'.
		'Ne shpresojmë që ju si faqen tonë dhe të argëtohen ndërsa në shfletim.<br/>'.
		'Nëse keni pyetje, ju lutem mos hezitoni të na kontaktoni.', 

	'welcome_back' => 
		'Mirë se vini përsëri në'.GWF_SITENAME.', %s.<br/><br/>'.
		'Aktiviteti i saj e fundit ishte më %s nga kjo IP Address: %s.', 

	'logout_info' => 'Ju tani janë jashtë.',

	# Admin Config
	'cfg_captcha' => 'përdorim Captcha?',	
	'cfg_max_tries' => 'gjykimet maximale ne',	
	'cfg_try_exceed' => 'kësaj kohe',
	
	'info_no_cookie' => 'Shfletuesi juaj nuk e përkrah cookie-t, ose nuk është i lejuar ato. Për të kyçeni këto janë të nevojshme, megjithatë.',

	'th_bind_ip' => 'Sesioni limit për këtë IP',
	'tt_bind_ip' => 'Një masë e sigurisë për të parandaluar vjedhjen e cookie.',

	'err_failures' => 'Që prej fundit të saj fjalëkalimin identifikoheni %s ishte një herë gabimisht. Ju mund të jenë viktima të një sulmi të dështuar apo të ardhshme.',

	# v1.01 (login failures)
	'cfg_lf_cleanup_i' => 'Incorrect hyrje fshini atë pas të identifikohem?',
	'cfg_lf_cleanup_t' => 'hyrje të pasaktë pas kësaj kohe fshini',

	# v2.00 (login history)
	'msg_last_login' => 'login juaj ishte ngecje në %s e %s (%s).<br/>Ju mund të <a href="%s">këtu të gjitha hyrje tuaja Shiko</a>.',
	'th_loghis_time' => 'Data',
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