<?php
$bot instanceof Lamb;
$channel_name = $args[0];
$part_message = isset($args[1]) ? $args[1] : '';
$server instanceof Lamb_Server;

if (false === ($user = $server->getUserFromOrigin($from, $channel_name)))
{
	return;
}

if ($user->getName() === $server->getBotsNickname())
{
	$server->onPart($channel_name);
}

elseif (false !== ($channel = $server->getOrCreateChannel($channel_name)))
{
	$channel->removeUser($user->getName());
}

else
{
	Lamb_Log::logError("Channel not Found in events/PART.php: $channel_name.");
}
?>
