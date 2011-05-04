<?php # Usage: %Trigger%server. Print information of the server who got this message.
$ssl = $server->isSSL() ? 'SSL' : 'PLAINTEXT';
$message = sprintf('Server %d (%s:%s): %s (%s) - %s channels', $server->getID(), $server->getIP(), $server->getPort(), $server->getName(), $ssl, count($server->getChannels()));
$bot->reply($message);
?>
