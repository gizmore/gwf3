<?php

$lang = array(

	'msg_sent_mail' => 'We have sent an email to %s. Please follow the instructions there.',
	'err_not_found' => 'No user found. Please submit either your email or your username.',
	'err_not_same_user' => 'No user found. Please submit either your email or your username .', # same message! no spoiled connection from uname=>email
	'err_no_mail' => 'We are sorry, but you do not have an email connected to your account. :(',
	'err_pass_retype' => 'Your retyped password does not match.',
	'msg_pass_changed' => 'Your password has been changed.',

	'pt_request' => 'Request a new password',
	'pt_change' => 'Change your password',
	
	'info_request' => 'Here you can request a new password for your account.<br/>Simply submit your username <b>or</b> email, and we will send you further instructions to your email address.',
	'info_change' => 'You can now enter a new password for your account, %s.',

	'title_request' => 'Request a new password',
	'title_change' => 'Set a new password',

	'btn_request' => 'Request',
	'btn_change' => 'Change',

	'th_username' => 'Username',
	'th_email' => 'Email',
	'th_password' => 'New Password',
	'th_password2' => 'Retype It',

	# The email (beware %s is twice. It`s an email. thats correct!)
	'mail_subj' => GWF_SITENAME.': Change Password',
	'mail_body' => 
		'Dear %1$s,<br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'You requested to change your password on '.GWF_SITENAME.'.<br/>'.PHP_EOL.
		'To do so, you have to visit the link below.<br/>'.PHP_EOL.
		'If you did not request a change, ignore this mail or contact us by <a href="mailto:%2$s">%2$s</a>.<br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'%3$s<br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'Kind Regards<br/>'.PHP_EOL.
		'The '.GWF_SITENAME.' Team'.PHP_EOL,

	# v2.01 (fixes)
	'err_weak_pass' => 'Your password is too weak. Minimum are %s chars.',
		
	#monnino fixes
	'cfg_captcha' => 'Use Captcha',
	'cfg_mail_sender' => 'E-Mail sender',
);

?>