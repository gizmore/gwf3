<?php # Usage: %Trigger%server. Print information of the server who got this message.
$message = sprintf('Server %d (%s:%s): %s (%s) - %s channels - Throttle is %.02f messages per second.', 
	$server->getID(), $server->getIP(), $server->getPort(), $server->getHostname(), (($server->isSSL() ?'TLS' :'plaintext')), $server->getChannelcount(), $server->getVar('serv_flood_amt')/3);
$bot->reply($message);
?>
