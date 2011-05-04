<?php # Usage: %TRIGGER%login <password>. Logs you in. Not needed if you are logged in to NickServ already.
if ($user->isLoggedIn())
{
	$bot->reply('You are already logged in. Maybe by NickServ.');
}
elseif (!$user->isRegistered())
{
	$bot->reply(sprintf('You are not registered. Try %sregister <password> first.', LAMB_TRIGGER));
}
elseif (strlen($message) <= 3)
{
	$bot->reply('Please submit a password with at least 4 characters.');
}
elseif ($user->getVar('lusr_password') !== md5($message))
{
	$bot->reply('Your password is wrong.');
}
else
{
	$user->setLoggedIn(true);
	$bot->reply('You are now logged in.');
}
?>