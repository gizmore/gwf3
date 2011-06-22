<?php
$lang = array(
	'title' => 'Blinded by the light',
	'info' =>
		'Your mission is to extract an md5 password hash out of a database.<br/>'.PHP_EOL.
		'Your limit for this blind sql injection are %1% queries.<br/>'.PHP_EOL.
		'Again your are given <a href="%2%">the sourcecode</a> of the vulnerable script, also as <a href="%3%">highlighted version</a>.<br/>'.PHP_EOL.
		'To restart the challenge, you are allowed to <a href="%4%">execute a reset</a>.<br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'Good luck!',

	'msg_reset' => 'Your password has been scrambled for security reasons.',
	'msg_logged_in' => 'Welcome back, user. You would now be logged in after %1% attempts.',
	'err_login' => 'Your password is wrong, user. This was your %1%. attempt!',
	'err_attempt' => 'We are sorry but it took you %1% attempts to retrieve the hash. The limit is %2%.',
	'err_wrong' => 'Your answer is wrong. This was your %1%. attempt!',

	'th_injection' => 'Password',
	'th_thehash' => 'Solution',
	'btn_inject' => 'Inject',
	'btn_submit' => 'Enter',
);
?>