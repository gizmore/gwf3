<?php # Usage: %CMD% <channel>. Make the bot join a channel.
$channel = Common::substrUntil($message, ' ', $message);
$channels = $server->getChannels();

if ($channel === '')
{
	return $bot->getHelp('join');
}


//if (isset($channels[$channel]))
//{
//	$bot->reply('I am already on that channel.');
//}
//else
//{

	if ($channel{0} === '#')
	{
		$bot->reply('Attempt to join channel '.$channel.'...');
		$server->join($channel);
	}
//}
?>
