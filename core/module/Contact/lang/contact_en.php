<?php

$lang = array(

	'page_title' => 'Contact '.GWF_SITENAME,
	'page_meta' => 'Foo',

	'contact_title' => 'Contact',
	'contact_info' =>
		'Here you can contact us by EMail. Please support us with a valid email, so we can send you a response, if desired.<br/>'.
		'You could also send us a mail to <a href="mailto:%s">%s</a> with any other mail program.',
	'form_title' => 'Contact us',
	'th_email' => 'Your EMail',
	'th_message' => 'Your Message',
	'btn_contact' => 'Send us Mail',

	'mail_subj' => GWF_SITENAME.': New Contact Mail',
	'mail_body' => 
		'A new Email has been sent by the contact form.<br/>'.PHP_EOL.
		'From: %s<br/>'.PHP_EOL.
		'Message:<br/>'.PHP_EOL.
		'%s<br/>'.PHP_EOL.
		'',

	'info_skype' => '<br/>You can also contact us via skype: %s.',

	'err_email' => 'Your email is invalid. You can leave the field blank if you want.',
	'err_message' => 'Your message is too short or too long.',

	# Admin Config
	'cfg_captcha' => 'Use Captcha',	
	'cfg_email' => 'Send Messages to (email)',
	'cfg_icq' => 'ICQ Contact data',
	'cfg_skype' => 'Skype contact data',
	'cfg_maxmsglen' => 'Max. message length',

	# Sendmail
	'th_user_email' => 'Your email address',
	'ft_sendmail' => 'Send %s an email',
	'btn_sendmail' => 'Send Mail',
	'err_no_mail' => 'This user does not want to receive email.',
	'msg_mailed' => 'An email has been sent to %s.',
	'mail_subj_mail' => GWF_SITENAME.': EMail from %s',
	'mail_subj_body' => 
		'Hello %s'.PHP_EOL.
		PHP_EOL.
		'There has been an email sent to you from %s by the '.GWF_SITENAME.' website:'.PHP_EOL.
		PHP_EOL.
		PHP_EOL.
		'%s',

	# V2.01 (List Admins)
	'list_admins' => 'Admins: %s.',
	
	'cfg_captcha_member' => 'Show captcha for members?',
);
?>