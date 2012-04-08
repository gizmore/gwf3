<?php # Remove the password for a user. Usage: %CMD% <username>
$bot instanceof Lamb;
$server instanceof Lamb_Server;
$args = explode(' ', $message);
if (count($args) !== 1)
{
	return $bot->processMessageA($server, LAMB_TRIGGER.'help nopass', $from);
	return;
}

if (false === ($user2 = $server->getUser($args[0])))
{
	$bot->reply('This user is unknown.');
	return;
}

if ($user2->isAdmin() && !$user->isAdmin())
{
	$bot->reply('You cannot remove admin passwords.');
	return;
}

if (false === $user2->saveVar('lusr_password', ''))
{
	$bot->reply('Datatbase error!');
	return;
}

$bot->reply(sprintf('The password for %s has been removed.', $args[0]));
?>
