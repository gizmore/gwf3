<?php # Reset a user password. Usage: %TRIGGER%passwd <username> <password>
$bot instanceof Lamb;
$server instanceof Lamb_Server;
$args = explode(' ', $message);
if (count($args) !== 2)
{
	$bot->processMessageA($server, LAMB_TRIGGER.'help passwd', $from);
	return;
}
if (false === ($user2 = $server->getUser($args[0]))) {
	$bot->reply('This user is unknown.');
	return;
}
if ($user2->isAdmin() && !$user->isAdmin()) {
	$bot->reply('You cannot change admin passwords.');
	return;
}
if (false === $user2->saveVar('lusr_password', md5($args[1]))) {
	$bot->reply('Datatbase error!');
	return;
}
$bot->reply(sprintf('The password for %s has been changed to %s.', $args[0], $args[1]));
?>