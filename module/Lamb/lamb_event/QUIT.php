<?php
$quit_message = $args[0];
$server instanceof Lamb_Server;
if (false === ($user = $server->getUserFromOrigin($from))) {
	return;
}
$username = $user->getName();
foreach ($server->getChannelsFor($username) as $channel) {
	$channel->removeUser($username);
}
$server->remUser($username);
?>