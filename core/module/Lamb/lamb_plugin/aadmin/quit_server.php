<?php # Usage: %CMD% [<id>]. Quit this server or another server by ID.
$bot instanceof Lamb;

if ($message === '') {
	return $bot->processMessageA($server, LAMB_TRIGGER.'help quit_server', $from);
}

if (is_numeric($message))
{
	$_server = $bot->getServer($message);
}
else
{
	$_server = false;
	foreach ($bot->getServers() as $srv)
	{
		$srv instanceof Lamb_Server;
		if (stripos($srv->getHostname(), $message) !== false)
		{
			$_server = $srv;
			break;
		}
	}
}

if ($_server === false)
{
	return $bot->reply('This server is unkown or not connected.');
}

$bot->reply('Issueing a quit.');

$_server->disconnect('Quit server has been issued by '.$user->getName().'.');
$bot->removeServer($_server);
$_server = Lamb_Server::getByID($_server->getID());
$bot->addServer($_server);
?>
