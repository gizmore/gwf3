<?php # Usage: %CMD% <channel>. Make the bot "hop" a channel.
$channel = Common::substrUntil($message, ' ', $message);
if ($channel === '')
{
	$channel = $bot->getCurrentChannel()->getName();
}

$bot->reply('Attempt to part channel '.$channel.'...');
$server->part($channel);
$bot->reply('Attempt to join channel '.$channel.'...');
$server->join($channel);
?>
