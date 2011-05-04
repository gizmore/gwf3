<?php
$channel_name = $args[0];
$part_message = isset($args[1]) ? $args[1] : '';
$server instanceof Lamb_Server;

if (false === ($user = $server->getUserFromOrigin($from, $channel_name))) {
	return;
}

if (false !== ($channel = $server->getOrCreateChannel($channel_name)))
{
	$channel->removeUser($user->getName());
//	$server->removeChannel($channel);
}
else {
	Lamb_Log::log("Channel not Found in events/PART.php: $channel_name.");
}
?>