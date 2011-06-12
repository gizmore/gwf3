<?php # Usage: %CMD% [server]

# Pick Server
if ($message === '')
{
	$s = $server;
}
elseif (is_numeric($message))
{
	if (false === ($s = $bot->getServer((int)$message))) {
		$bot->reply('This server is unknown.');
		return;
	}
}
else
{
	foreach ($bot->getServers() as $serv)
	{
		if (strpos($serv->getName(), $message) !== false)
		{
			$s = $serv;
			break;
		}
	}
	if (!isset($s)) {
		$bot->reply('This server is unknown.');
		return;
	}
}
$s instanceof Lamb_Server;

$i = 0;

# Show channels
if ($s->getConnection()->isConnected())
{
	$channels = '';
	foreach ($s->getChannels() as $channel)
	{
		$channel instanceof Lamb_Channel;
		$channels .= sprintf(', %s(%d users)', $channel->getName(), count($channel->getUsers()));
	}
	if ($channels !== '') {
		$channels = substr($channels, 2);
	}
	$i++;
}
else { $channels = 'Not connected!'; }


$bot->reply(sprintf("I am on %d channels on server %d-%s: %s.", $i, $s->getID(), $s->getHostname(), $channels))
?>