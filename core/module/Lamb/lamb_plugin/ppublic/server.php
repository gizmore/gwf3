<?php # Usage: %Trigger%server. Print information of the server who got this message.
$message = sprintf('Server %d (%s:%s): %s (%s) - %s channels', 
	$server->getID(), $server->getIP(), $server->getPort(), $server->getHostname(), (($server->isSSL() ?'TLS' :'plaintext')), $server->getChannelcount());
$bot->reply($message);
?>
