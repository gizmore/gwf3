<?php # Usage: %TRIGGER%quit_server [<id>]. Quit this server or another server by ID.
$bot instanceof Lamb;

if ($message === '') {
	return $bot->processMessageA($server, LAMB_TRIGGER.'help quit_server', $from);
}

//global $LAMB_JOIN_SERVER_CONFIRM;

//if (is_numeric($message))
//{
//	return $bot->processMessageA($server, LAMB_TRIGGER.'help join_server', $from);
////	if (false === ($server = Lamb_Server::getByID())) {
////		return $bot->reply('Unknown Server');
////	}
//}
//else
//{
//	$args = explode(' ', $message);
//	$hostname = $args[0];
//	$nickname = isset($args[1]) ? $args[1] : 'Lamb';
//	$password = isset($args[2]) ? $args[2] : '';
//	$channels = isset($args[3]) ? $args[3] : '';
//	$admins = isset($args[4]) ? $args[4] : LAMB_OWNER;
//	
//	$host = Common::substrFrom($hostname, '://', $hostname);
//	$host = Common::substrUntil($host, ':');
//	if ($host === ($ip = gethostbyname($host)))
//	{
//		$bot->reply('Can not resolve hostname: '.$host);
//		return;
//	}
//	else
//	{
//		$message = 'Resolved IP: '.$ip.'. ';
//	}
//	
//	$server = new Lamb_Server($hostname, $nickname, $password, $channels, $admins);
//}
//
//if (false === $bot->getServer($server->getID())) {
//	$bot->reply($message.'Unknown Server!');
//}
//$bot->removeServer($server);
?>
