<?php
$bot instanceof Lamb;
$server instanceof Lamb_Server;

$channel = strtolower(Common::substrUntil($message, ' '));
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
