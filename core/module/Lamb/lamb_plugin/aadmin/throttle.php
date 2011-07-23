<?php # Usage: %CMD% <level>. Set the trottle for a server. Level means messages within three seconds. Default is 5.
$server instanceof Lamb_Server;

if ($message === '')
{
	return $bot->reply(sprintf('This server has set it\'s throttle to %s.', $server->getVar('serv_flood_amt')));
//	return $bot->getHelp('throttle');
}

$min = 0;
$max = 10;
$level = intval($message, 10);



if ( ($level < $min) || ($level > $max) )
{
	return $bot->reply(sprintf('The throttle has to be between %s and %s.', $min, $max));
}

if (false === $server->saveVar('serv_flood_amt', $level))
{
	return $bot->reply('Database error.');
}

$bot->reply(sprintf('The throttle has been set to %s for server %s-%s.', $level, $server->getID(), $server->getHostname()));
?>
