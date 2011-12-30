<?php
$lang = array(
	'title' => 'Fixus',
	'info' =>
		'Your mission is now to maintain access to the solution boards for the Z challenges.<br/>'.
		'Your plan is to gather information about the challenge solutions and gain more points on WeChall.net.<br/>'.
		'Because Z is a naive, click-before-think guy, he clicks on every link you send him.<br/>'.
		'Your plan is to send Z a malicious, but innocent looking link, and once he logs in WeChall, you will be able to login in the credentials of Z - and read the solution boards as well.<br/>'.
		'Gizmore did a good job against XSS and CSRF, so you have to find another flaw to log in.<br/>'.
		'After examining the WeChall source code, you found a hidden login page for the Z solution boards.<br/>'.
		'<br/>'.
		'<a href="%1$s">Goto Login</a><br/>'.
		'<br/>'.
		'<a href="%2$s">Goto Secret Forum</a><br/>',
	'send_to_z' => 'Send a link to Z',
	'err_bad' => 'This won\'t work!',
	'err_screwed' => 'This won\'t work, you screwed it all up, buddy!!!',
	'msg_sent' => 'Link Send. Hopefully he will click it and has to login ;D',
	'go_back' => 'Go back to the task',
	'btn_login' => 'Login To Admin Panel',
	'hello' => 'Hello %1$s<br/><br/>',
	'hello_z' => 'You may now access <a href="%1$s">the Forum</a>.<br/>',
	'hello_other' => 'You may not access anything here since your rights are not sufficient.<br/>',
	'pls_login' => 'Please %1$s to Access the Secret Admin Forum.', # %1$s==Login<A>nchor
	'no_perm' => 'Your rights are not sufficient to see this board.<br/>%1$s',
	'solved' => 'Well done. Challenge solved.<br/>You now have access to the solutionboard for this challenge :)',
);
?>