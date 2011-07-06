<?php # Usage: %CMD% <target> <the message ...>. Send a message to an arbitary target. 
$bot instanceof Lamb;
$server instanceof Lamb_Server;
$t = explode(' ', trim($message), 2);
if (count($t) !== 2) {
	echo $bot->processMessageA($server, LAMB_TRIGGER.'help say', $from);
	return;
}
$server->sendPrivmsg($t[0], $t[1]);
