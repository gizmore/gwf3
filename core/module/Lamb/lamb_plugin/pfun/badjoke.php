<?php # You can use this function when maddinw makes any joke.
$bot = Lamb::instance();

if (false === ($channel = $bot->getCurrentChannel()))
{
	$bot->reply('Does not work in private!');
	return;
}

$server = $bot->getCurrentServer();

switch (rand(0,2))
{
	case 0: return $server->sendPrivmsg($channel->getName(), 'Ba dum tssss!');
	case 1: return $server->sendAction($channel->getName(), 'makes the cricket sound.');
	case 2: return $server->sendAction($channel->getName(), 'makes the tumbleweed sound.');
}
?>
