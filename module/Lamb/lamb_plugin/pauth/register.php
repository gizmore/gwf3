<?php # Usage: %TRIGGER%register <password>. Registers you with Lamb and logs you in. Use %TRIGGER%register <oldpass> <newpass> to change your password.
$split = explode(' ', $message);
if (count($split) === 2)
{
	if (md5($split[0]) !== $user->getVar('lusr_password'))
	{
		$bot->reply(sprintf('You have to submit your old password. Usage: %sregister <oldpass> <newpass>', LAMB_TRIGGER));
	}
	else
	{
		$user->saveVar('lusr_password', md5($split[1]));
		$user->setLoggedIn(true);
		$bot->reply(sprintf('Your password has been changed to %s. You are now logged in.', $split[1]));
	}
}
elseif ($user->isRegistered())
{
	$bot->reply('You are already registered.');
}
elseif ( (count($split) !== 1) || (strlen($split[0])<4) )
{
	$bot->reply(sprintf('Please submit a valid password.'));
}
else
{
	$user->saveVar('lusr_password', md5($split[0]));
	$user->setLoggedIn(true);
	$bot->reply(sprintf('You have successfully registered with Lamb. Your password is %s. You are now logged in.', $split[0]));
}
?>