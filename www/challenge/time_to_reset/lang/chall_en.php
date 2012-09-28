<?php
$lang = array(
	'title' => 'Time to Reset',
	'info' =>
		'I randomly browsed my todo and coded a challenge.<br/>'.PHP_EOL.
		'In this challenge you have to submit the password reset token for the user admin@wechall.net<br/>'.PHP_EOL.
		'Please note that your tokens are bound to your session.<br/>'.PHP_EOL.
		'You probably want to take a look at <a href="%s" title="Sourcecode of the TTR challenge">the sourcecode</a>, also available in a <a href="%s" title="Highlighted sourcecode of the TTR challenge">highlighted version</a><br/>'.PHP_EOL.
		'<p style="color:#eefeef" id="hint">The hint above is enough.</p>'.PHP_EOL.
		'Good Luck!<br/>'.PHP_EOL,

	'err_email' => 'Your email looks invalid.',
		
	'ft_reset' => 'Request a Password reset',
	'th_email' => 'Your email',
	'btn_reset' => 'Reset',
		
	'mail_subj' => 'TTR: Reset the password',
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
