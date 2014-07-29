<?php
$lang = array(
	'pt_register' => 'Register at '.GWF_SITENAME,

	'title_register' => 'Register',

	'th_username' => 'Username',
	'th_password' => 'Password',
	'th_email' => 'Email',
	'th_birthdate' => 'Birthdate',
	'th_countryid' => 'Country',
	'th_tos' => 'I agree to the<br/>Terms of Use',
	'th_tos2' => 'I agree to the<br/><a href="%s">Terms of Use</a>',
	'th_register' => 'Register',

	'btn_register' => 'Register',
	

	'err_register' => 'An error occured during the registration process.',
	'err_name_invalid' => 'Your chosen username is invalid.',
	'err_name_taken' => 'The username is already taken.',
	'err_country' => 'Your chosen country is invalid.',
	'err_pass_weak' => 'Your password is too weak. Also, <b>Do not re-use important passwords</b>.',
	'err_token' => 'Your activation code is invalid. Maybe you are already activated.',
	'err_email_invalid' => 'Your email is invalid.',
	'err_email_taken' => 'Your email is already taken.',
	'err_activate' => 'An error occured during activation.',
		
	'msg_activated' => 'Yoru account is now activated. Please try to login now.',
	'msg_registered' => 'Thank you for registering.',

	'regmail_subject' => 'Register at '.GWF_SITENAME,
	'regmail_body' => 
		'Hello %s<br/>'.
		'<br/>'.
		'Thank you for registering at '.GWF_SITENAME.'.<br/>'.
		'To complete the registration, you have to activate your account first, by visiting the link below.<br/>'.
		'If you did not register at '.GWF_SITENAME.', please ignore this mail, or contact us at '.GWF_SUPPORT_EMAIL.'.<br/>'.
		'<br/>'.
		'%s<br/>'.
		'<br/>'.
		'%s'.
		'Kind Regards,<br/>'.
		'The '.GWF_SITENAME.' Team.',
	'err_tos' => 'You have to agree to the EULA.',

	'regmail_ptbody' => 
		'Your Login Credentials are:<br/><b>'.
		'Username: %s<br/>'.
		'Password: %s<br/>'.
		'</b><br/>'.
		'It is a good idea to delete this email and store the password somewhere else.<br/>'.
		'We do not store your password in plaintext, you should not do that either.<br/>'.
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
	'cfg_reg_toslink' => 'Link to TOS',

	'err_birthdate' => 'Your birthdate is invalid.',
	'err_minage' => 'We are sorry, but you are not old enough to register. You need to be at least %s years old.',
	'err_ip_timeout' => 'Someone recently registered an account with this IP.',
	'th_token' => 'Token',
	'th_timestamp' => 'Register Time',
	'th_ip' => 'Reg IP',
	'tt_username' => 'The username has to start with a letter.'.PHP_EOL.'It may only contain letters, digits and the underscore. Length has to be 3 - %s chars.', 
	'tt_email' => 'A valid EMail is required to register.',

	'info_no_cookie' => 'Your Browser does not support cookies or does not allow them for '.GWF_SITENAME.', but cookies are required for login.',

	# v2.01 (fixes)
	'msg_mail_sent' => 'An EMail with instructions to activate your account has been sent to you.',

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