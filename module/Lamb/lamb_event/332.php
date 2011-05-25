<?php
# RPL_TOPIC
$server instanceof Lamb_Server;

$channel_name = $args[0];
$topic = $args[1];

if (false === ($channel = $server->getChannel($channel_name)))
{
	echo "Unknown channel in event TOPIC: {$channel_name}\n";
	return;
}

$channel->saveTopic($topic);
?>