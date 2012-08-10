<?php
$lang = array(
	'title' => 'Light in the Darkness',
	'info' =>
		'This challenge is the sequel to the &quot;Blinded by the lighter&quot; challenge.<br/>'.PHP_EOL.
		'Again your mission is to extract an md5 password hash out of the database.<br/>'.PHP_EOL.
		'This time your limit for this sql injection are %s queries.<br/>'.PHP_EOL.
		'Also you have to accomplish this task %s times consecutively, to prove you have solved the challenge.<br/>'.PHP_EOL.
		'Again you are given <a href="%s">the sourcecode</a> of the vulnerable script, also as <a href="%s">highlighted version</a>.<br/>'.PHP_EOL.
		'To restart the challenge, you can <a href="%s">execute a reset</a>.<br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'Thanks to Mawekl for his motivation!<br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'Good luck!',

	'msg_reset' => 'Your password has been scrambled for security reasons.',
	'msg_logged_in' => 'Welcome back, user. You would now be logged in after %s attempts.',
	'msg_consec_success' => 'Wow, you were able to retrieve the correct hash within the constraints. You need %s more consecutive success to solve the challenge.',
	'msg_old_pass' => 'We are sorry to hear you give up that quickly. To help you a bit here is your last hash: %s.',
		
	'err_too_slow' => 'You were too slow in this round. You can go faster.',
	'err_login' => 'Your password is wrong, user. This was your %s. attempt!',
	'err_attempt' => 'We are sorry but it took you %s attempts to retrieve the hash. The limit is %s.',
	'err_wrong' => 'Your answer is wrong. This was your %s. attempt!',

	'th_injection' => 'Password',
	'th_thehash' => 'Solution',
	'btn_inject' => 'Inject',
	'btn_submit' => 'Enter',
);
?>