<?php
$lang = array(
	'title' => 'Blinded by the light',
	'info' =>
		'Your mission is to extract an md5 password hash out of a database.<br/>'.PHP_EOL.
		'Your limit for this blind sql injection are %s queries.<br/>'.PHP_EOL.
		'Again your are given <a href="%s">the sourcecode</a> of the vulnerable script, also as <a href="%s">highlighted version</a>.<br/>'.PHP_EOL.
		'To restart the challenge, you are allowed to <a href="%s">execute a reset</a>.<br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'%s'. # Easteregg
		'<br/>'.PHP_EOL.
		'Good luck!',

	'msg_reset' => 'Your password has been scrambled for security reasons.',
	'msg_logged_in' => 'Welcome back, user. You would now be logged in after %s attempts.',
	'err_login' => 'Your password is wrong, user. This was your %s. attempt!',
	'err_attempt' => 'We are sorry but it took you %s attempts to retrieve the hash. The limit is %s.',
	'err_wrong' => 'Your answer is wrong. This was your %s. attempt!',

	'th_injection' => 'Password',
	'th_thehash' => 'Solution',
	'btn_inject' => 'Inject',
	'btn_submit' => 'Enter',
);
?>