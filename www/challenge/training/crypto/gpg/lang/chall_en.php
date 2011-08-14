<?php
$lang = array(
	'title' => 'Crypto: GPG',
	'info' =>
		'In this challenge your goal is to setup gpg encryption for your emails.<br/>'.PHP_EOL.
		'To do so, generate your keypairs locally and store your public key on wechall.<br/>'.PHP_EOL.
		'Then all your mails sent by wechall are encrypted.<br/>'.PHP_EOL.
		'To enable GPG encryption, please goto <a href="%1%">Your account settings</a>.<br/>'.PHP_EOL.
		'When you are done, click the button below to send you a mail.<br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'Happy Challenging!',

	'btn_send' => 'Send me encrypted mail please.',
	'err_login' => 'You have to login to solve this challenge!',
	'err_server' => 'This server does not support GPG encryption in php mails.',
	'err_no_gpg' => 'Please enable GPG encryption in your <a href="%1%">account settings</a>.',

	'mail_s' => 'WeChall: GPG Challenge',
	'mail_b' =>
		'Dear %1%,'.PHP_EOL.
		PHP_EOL.
		'I just want to tell you the solution to the GPG challenge.'.PHP_EOL.
		'It is: %2%'.PHP_EOL.
		PHP_EOL.
		'Kind Regards'.PHP_EOL.
		'The WeChall Bot!',
		
	'msg_mail_sent' => 'We have sent you an encrypted email to %1% which contains the solution.',
);
?>