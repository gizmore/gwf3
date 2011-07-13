<?php
$bot instanceof Lamb;
$server instanceof Lamb_Server;

$channel_name = $args[0];
$message = trim($args[1]);

if ($server->isLogging())
{
	Lamb_Log::logChat($server, $message);
}

if (Common::startsWith($message, LAMB_TRIGGER))
{
	$bot->onTrigger($server, $from, $channel_name, $message);
}
else
{
	$bot->onPrivmsg($server, $from, $channel_name, $message);
}
?>