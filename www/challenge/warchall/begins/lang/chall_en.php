<?php
$lang = array(
	'title' => 'Warchall - Chapter I (Warchall begins)',
	'info' =>
		'You are now becoming a linux superhacker.<br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'Create an SSH account with the form below.<br/>'.PHP_EOL.
		'Then enter the 6 solutions to level 0-5 seperated by comma.<br/>'.PHP_EOL.
		'Example: bitwarrior,Solution1,Solution2,Solution3,Solution4,Solution5<br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'Proudly presented by the The Warchall(tm) Staff<br/>'.PHP_EOL.
		'<b>Thanks and shouts to xd-- from <a href="http://crazycoders.com">crazycoders.com</a> for idea, motivation and inspiration!</b><br/>'.PHP_EOL.
		'',

	'err_login' => 'You need to be logged in to create an SSH account for this challenge.',
	'err_score' => 'You only have %s points, but to create an SSH account you need %s points.',
	'err_unix_username' => 'Your wechall username can not get converted into a unix username for warchall.<br/>Only a-zA-Z is allowed. :(',
	'err_retype' => 'You did not retype your password correctly.',
	
	'ft_create_ssh_account' => '(RE)SET your SSH account',
	'th_password' => 'Password',
	'th_password2' => 'Retype',
	'btn_submit' => 'Go!',

	'msg_creating_account' =>
		'Ok Challenger, in about 1 minute you should be able to login via ssh -p 19198 %s@warchall.net<br/>Use the password you entered in the form.<br/><br/>Happy Challenging!<br/>The warchall team',
	
	'ft_setup_email' => 'Enable logfile EMails',
	'btn_setmail' => 'Toggle',
	'msg_nomails' => 'You should not receive logfile mails anymore.',
	'err_no_mail' => 'You don\'t have a valid contact mail.',
	'msg_mail' => 'You should now get mails with logfiles to your main contact mail.',
);
?>