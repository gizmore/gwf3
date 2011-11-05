<?php
$bot instanceof Lamb;
$server instanceof Lamb_Server; # 1
#$from # from 2
$origin = $args[0]; # origin 3
$message = trim($args[1]); # msg 4

//if (false === ($user = $server->getUserFromOrigin($from, $origin)))
if ( (false === ($user = $server->getUserFromOrigin($from))) && (false === ($user = $server->getUserByNickname($from))) )
{
	return Lamb_Log::logError(sprintf('Cannot getUserFromOrigin(%s, %s) onPrivmsg on server %s.', $from, $origin, $server->getHostname()));
}

############################
### Anonet IRC-Cloud Fix ###
############################
# Ignore anonetworks where the bot is also online and which are linked via irc-cloud protocol (thx srn) 
if (Lamb_User::isOnAnonetS($server->getBotsNickname()))
{
	$ignored_anonet_links = array('HackInt');
	if (in_array($user->getAnonetPrefix(), $ignored_anonet_links))
	{
		return; 
	}
}

//$sender_nick = $user->getName();
//$sender_nick = substr($sender_nick, strpos($sender_nick, '/', 1)+1);
//echo "Send by {$sender_nick}\n";

// Anonet IRC-Cloud Fix
// Ignore cross links
//if ($user->isOnAnonet() !== Lamb_User::isOnAnonetS($server->getBotsNickname()))
//{
//	return;
//}
//// Ignore own messages 
//{
//	$ano_nickname = $user->getName();
//	$ano_nickname = substr($ano_nickname, strpos($ano_nickname, '/', 1)+1);
//	$bot_nickname = $server->getBotsNickname();
//	$bot_nickname = substr($bot_nickname, strpos($bot_nickname, '/', 1)+1);
//	var_dump($ano_nickname, $bot_nickname);
//	if ($bot_nickname === $ano_nickname)
//	{
//		return;
//	}
//}

 
if ($server->isLogging())
{
	Lamb_Log::logChat($server, $message);
}

if (Common::startsWith($message, LAMB_TRIGGER))
{
	$bot->onTrigger($server, $user, $from, $origin, $message);
}
else
{
	$bot->onPrivmsg($server, $user, $from, $origin, $message);
}
?>