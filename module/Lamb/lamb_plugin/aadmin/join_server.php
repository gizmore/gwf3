<?php # Usage: %TRIGGER%join_server <server:port> [nick] [pass] [channels] [admins]. Let the bot join another irc server.
$bot instanceof Lamb;
$server instanceof Lamb_Server;
$db = gdo_db();
$table = GWF_TABLE_PREFIX.'lamb_server';

if ($message === '')
{
	return $bot->processMessageA($server, LAMB_TRIGGER.'help join_server', $from);
//	$query = "SELECT serv_id, serv_name FROM $table ORDER BY serv_id ASC";
//	if (false === ($servers = $db->queryAll($query, false))) {
//		$bot->reply('Database error!');
//		return;
//	}
//	$out = '';
//	foreach ($servers as $s)
//	{
//		$out .= sprintf(', %s(%s)', Common::getTLD($s[1]), $s[0]);
//	}
//	$out = sprintf('%s server(s) in the database: %s.', count($servers), substr($out, 2));
//	$bot->reply($out);
//	return;
}

//global $LAMB_JOIN_SERVER_CONFIRM;

$out = '';
if (is_numeric($message))
{
	$out .= "Trying to connect to server $message...";
	if (false === ($server = Lamb_Server::getByID($message))) {
		$bot->reply($out.' Unknown Server!');
		return;
	}
}
elseif (preg_match('/^(\\d{1,3}\\.\\d{1,3}\\.\\d{1,3}\\.\\d{1,3}) .*/', $message, $matches))
{
	$args = explode(' ', $message);
	$hostname = $matches[1];
	$out .= ('Trying to connect to server '.$hostname.'...');
	$server = new Lamb_Server($matches[1], $nicknames, $password, $channels, $admin);
	$nickname = isset($args[1]) ? $args[1] : 'Lamb2';
	$password = isset($args[2]) ? $args[2] : '';
	$channels = isset($args[3]) ? $args[3] : '';
	$admins = isset($args[4]) ? $args[4] : LAMB_OWNER;
	$server = new Lamb_Server($hostname, $nickname, $password, $channels, $admins);
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
	$server = new Lamb_Server($hostname, $nickname, $password, $channels, $admins);
}


if (false === $bot->addServer($server)) {
	$bot->reply($out.' Duplicate Server!');
}
else {
	$bot->reply($message.' Connecting...');
}
?>
