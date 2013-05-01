<?php
$bot instanceof Lamb;
$server instanceof Lamb_Server;

$channel = strtolower(Common::substrUntil($message, ' '));

$nullpos = strpos($channel, '0');
if ( ($nullpos !== false) && ($nullpos < 3) )
{
	return $bot->reply('Hacker nonono!');
}

$channels = $server->getChannels();
if (!isset($channels[$channel]))
{
	$bot->reply('I am not on this channel... Not in my memories...');
}
else
{
//	$bot->reply('Attemp to part channel '.$channel.'...');
	$server->part($channel);
}
?>
