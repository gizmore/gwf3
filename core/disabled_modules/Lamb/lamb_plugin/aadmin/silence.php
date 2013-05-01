<?php # Usage: %CMD% [<on|off>]. Disable all triggers in the current channel.
$bot instanceof Lamb;
$server instanceof Lamb_Server;
$channel = $bot->getCurrentChannel();

if ($message === '')
{
}
else
{
	$message = strtolower($message);
	if ($message === 'on')
	{
		$channel->saveOption(Lamb_Channel::NO_RESPONSE, true);
	}
	elseif ($message === 'off')
	{
		$channel->saveOption(Lamb_Channel::NO_RESPONSE, false);
	}
	else
	{
		return $bot->getHelp('silence');
	}
}

if ($channel->allowsTrigger())
{
	$bot->reply('The channel allows bot commands.');
}
else
{
	$bot->reply('The channel does not allow bot commands.');
}
?>