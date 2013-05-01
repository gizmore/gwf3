<?php
$bot instanceof Lamb;
$server instanceof Lamb_Server;
$nickname = $args[0];

if (false === ($old_user = $server->getUserFromOrigin($from))) {
	return;
}

if ($old_user->getName() === $server->getBotsNickname())
{
	$server->changeNick($args[0]);
}

if (false === ($new_user = $server->getUserByNickname($nickname))) {
	return;
}

$server->addUser($nickname);
foreach ($server->getChannelsFor($old_user->getName()) as $channel)
{
	$channel instanceof Lamb_Channel;
	$channel->addUser($new_user);
}

$server->remUser($old_user->getName());

?>