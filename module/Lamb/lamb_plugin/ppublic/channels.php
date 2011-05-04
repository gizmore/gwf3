<?php # Usage: %TRIGGER%channels [server]

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
	
}
else { $channels = 'Not connected!'; }


$bot->reply(sprintf('Channels on Server %d(%s): %s.', $s->getID(), $s->getHostname(), $channels))
?>