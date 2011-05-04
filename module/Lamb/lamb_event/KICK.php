<?php
$server instanceof Lamb_Server;
$channel_name = $args[0];
$nickname = $args[1];
$reason = $args[2];

# Remove user from channel
if (false !== ($channel = $server->getOrCreateChannel($channel_name)))
{
	$channel->removeUser($nickname);
}

# Lamb got kicked!
if ($server->getBotsNickname() === $nickname)
{
	if ($server->isAutoChannel($channel_name))
	{
		$server->join($channel_name);
	}
}

?>