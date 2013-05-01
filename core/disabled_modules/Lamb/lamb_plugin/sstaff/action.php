<?php # Usage: %CMD% <target> <the message ...>. Do an CTCP action to an arbitary target. 
$bot instanceof Lamb;
$server instanceof Lamb_Server;
$t = explode(' ', trim($message), 2);
if (count($t) !== 2)
{
	echo $bot->getHelp('action');
	return;
}
$server->sendAction($t[0], $t[1]);
?>
