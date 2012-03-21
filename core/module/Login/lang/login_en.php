<?php

$lang = array(

	'pt_login' => 'Login to '.GWF_SITENAME,
	'title_login' => 'Login',
	
	'th_username' => 'Username',
	'th_password' => 'Password',
	'th_login' => 'Login',
	'btn_login' => 'Login',
	'btn_register' => 'Register',
	'btn_recovery' => 'Recovery',

	'err_login' => 'Unknown Username',
	'err_login2' => 'Wrong Password. You now have %s tries left until you are blocked for %s.',
	'err_blocked' => 'Please wait %s until you try again.',

	'welcome' => 
		'Welcome to '.GWF_SITENAME.', %s.<br/><br/>'.
		'We hope you like our site and have fun while browsing.<br/>'.
		'In case you have questions, do not hesitate to contact us!',

	'welcome_back' => 
		'Welcome back to '.GWF_SITENAME.', %s.<br/><br/>'.
		'Your last activity was %s from this IP: %s.',

	'logout_info' => 'You are now logged out.',

	# Admin Config
	'cfg_captcha' => 'Use Captcha?',	
	'cfg_max_tries' => 'Maximum Login Tries',	
	'cfg_try_exceed' => 'within this Duration',

	'info_no_cookie' => 'Your Browser does not support cookies or does not allow them for '.GWF_SITENAME.', but cookies are required for login.',
	
	'th_bind_ip' => 'Restrict Session to this IP',
	'tt_bind_ip' => 'A security measurement to prevent cookie theft.',

	'err_failures' => 'There have been %s login failures and you might have been subject of an unsuccessful or future attack.',

	# v1.01 (login failures)
	'cfg_lf_cleanup_i' => 'Cleanup user failures after login?',
	'cfg_lf_cleanup_t' => 'Cleanup old failures after time',

	# v2.00 (login history)
	'msg_last_login' => 'Your last login was %s from %s (%s).<br/>You can also <a href="%s">review your login history here</a>.',
	'th_loghis_time' => 'Date',
	'th_loghis_ip' => 'IP',
	'th_hostname' => 'Hostname',

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
		'We just wanted to let you know.'.PHP_EOL.
		PHP_EOL.
		'Sincerely,'.
		PHP_EOL.
		'The '.GWF_SITENAME.' script',
	
	# monnino fixes
	'cfg_send_alerts' => 'Send alerts',
	'err_already_logged_in' => 'You are already logged in.',
);

?>