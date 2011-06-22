<?php
$quit_message = $args[0];
$server instanceof Lamb_Server;
if (false === ($user = $server->getUserFromOrigin($from)))
{
	Lamb_Log::logError(sprintf('!!! Cannot get user from origin: %s.', $from));
	return;
}
$server->remUser($user->getName());
?>