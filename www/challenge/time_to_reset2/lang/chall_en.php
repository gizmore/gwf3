<?php
# See time_to_reset challenge, only info and title changed!
$lang = array(
	'title' => 'Time to Reset - II',
	'info' =>
		'As announced, this is a sequel to the TTR challenge.<br/>'.PHP_EOL.
		'%s has proven that it is solveable, and an awesome exploit. Again you have to submit the <a href="%s">password reset</a> token for the user admin@wechall.net<br/>'.PHP_EOL.
		'Please note that your tokens are bound to your session.<br/>'.PHP_EOL.
		'You probably want to take a look at <a href="%s" title="Sourcecode of the TTR2 challenge">the sourcecode</a>, also available in a <a href="%s" title="Highlighted sourcecode of the TTR2 challenge">highlighted version</a><br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'Thanks go to noother for proving that stuff can still be owned in creative ways :)<br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'Good Luck!<br/>'.PHP_EOL,

	'err_email' => 'Your email looks invalid.',
		
	'ft_reset' => 'Request a Password reset',
	'th_email' => 'Your email',
	'btn_reset' => 'Reset',
		
	'mail_subj' => 'TTR2: Reset the password', # TTR2!
	'mail_body' =>
		'Dear User,'.PHP_EOL.
		''.PHP_EOL.
		'You requested a password reset token, and it is: %s'.PHP_EOL.
		''.PHP_EOL.
		'Cheers!'.PHP_EOL.
		'Lamb3'.PHP_EOL,
		
	'msg_mail_sent' => 'We probably have sent an email to you.',
		
	'msg_reset_own' => 'Woho, you have somehow gathered the reset token for %s!',
);
?>
