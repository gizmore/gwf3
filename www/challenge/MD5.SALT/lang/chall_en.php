<?php
$lang = array(
	'title' => 'MD5.SALT',
	'info' => 
		'Your mission is to login as Admin.<br/>'.
		'The application is vulnerable to sql injection, but the signup process seems a bit &quot;weird&quot;.<br/>'.
		'I am sure you can login as Admin somehow.<br/>'.
		'It is also possible to register via the login form. Simply enter a new username and your desired password.<br/>'.
		'<br/>'.
		'Good luck!<br/>'.
		'<br/>'.
		'Hint: You know the table is called &quot;users&quot; and which holds the columns &quot;username&quot; and &quot;password&quot;.',

	'credits' => 'Thanks go out to %1$s for motivation and idea.',

	'err_username' => 'This username is unknown',
	'err_password' => 'Your password is wrong!',
	'err_fool' => 'You are not allowed to register here with your real wechall password. Next time think twice about re-using passwords!',
	
	'msg_registered' => 'You registered succesfully as %1$s.',
	'msg_checking' => 'Hello %1$s... checking your credentials...',
	'msg_welcome_back' => 'Welcome back %1$s, you are now logged in.',

	'th_user' => 'Username',
	'th_pass' => 'Password',
	'btn_login' => 'Login!',
);
?>