<?php # %CMD% <nickname> Change the bot`s nickname.
$bot instanceof Lamb;
$server instanceof Lamb_Server;

if ($message === '')
{
	$bot->reply(sprintf('My current nick here is %s.', $server->getCurrentNick()));
}

elseif (preg_match('/^([a-z0-9]+)$/i', $message, $matches))
{
	$bot->reply('Changing nickname to '.$matches[1]);
	$server->changeNick($matches[1]);
	$server->sendNickname();
}

else
{
	$bot->getHelp('nick');
}
?>
