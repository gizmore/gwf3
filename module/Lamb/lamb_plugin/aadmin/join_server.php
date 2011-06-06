<?php # Usage: %CMD% <server:port> [nick] [pass] [channels] [admins]. Let the bot join another irc server.
$bot instanceof Lamb;
$server instanceof Lamb_Server;
if ($message === '')
{
	return $bot->getHelp('join_server');
}
$out = '';
if (is_numeric($message))
{
	if (false === ($server = Lamb_Server::getByID($message)))
	{
		$bot->reply($out.' Unknown Server!');
		return;
	}
	$out .= sprintf('Trying to connect to server %d (%s)', $server->getID(), $server->getHostname());
}
elseif (preg_match('/^(\\d{1,3}\\.\\d{1,3}\\.\\d{1,3}\\.\\d{1,3}) .*/', $message, $matches))
{
	$args = explode(' ', $message);
	$hostname = $matches[1];
	$out .= ('Trying to connect to server '.$hostname.'...');
	$nickname = isset($args[1]) ? $args[1] : 'Lamb2';
	$password = isset($args[2]) ? $args[2] : '';
	$channels = isset($args[3]) ? $args[3] : '';
	$admins = isset($args[4]) ? $args[4] : LAMB_OWNER;
	$server = Lamb_Server::factory($hostname, $nickname, $password, $channels, $admins);
}
else
{
	$args = explode(' ', $message);
	$hostname = $args[0];
	$out .= ('Trying to connect to server '.Common::getTLD($hostname).'...');
	$nickname = isset($args[1]) ? $args[1] : 'Lamb2';
	$password = isset($args[2]) ? $args[2] : '';
	$channels = isset($args[3]) ? $args[3] : '';
	$admins = isset($args[4]) ? $args[4] : LAMB_OWNER;
	$host = Common::substrFrom($hostname, '://', $hostname);
	$host = Common::substrUntil($host, ':');
	if ($host === ($ip = gethostbyname($host)))
	{
		$bot->reply($out." Can not resolve hostname: $host!");
		return;
	}
	else
	{
		$out .= ' IP: '.$ip.'...';
	}
	
	$server = Lamb_Server::factory($hostname, $nickname, $password, $channels, $admins);
}


if (false === $bot->addServer($server))
{
	$bot->reply($out.' Duplicate Server!');
}
elseif (false === $server->replace())
{
	$bot->reply('Database error!');
}
else
{
	$bot->reply($message.' Connecting...');
}
?>
