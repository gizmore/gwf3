<?php
$server instanceof Lamb_Server;
$channel = Common::substrUntil($message, ' ');
$channels = $server->getChannels();
if (!isset($channels[$channel]))
{
	$bot->reply('I am not on this channel... not in my memories...');
}
else
{
	$bot->reply('Attemp to part channel '.$channel.'...');
	$server->part($channel);
}
?>
