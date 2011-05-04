<?php # %TRIGGER%nick <nickname> Change the bot`s nickname.
$bot instanceof Lamb;
$server instanceof Lamb_Server;
if (preg_match('/^([a-z0-9]+)$/i', $message, $matches)) {
	$bot->reply('Changing nickname to '.$matches[1]);
	$server->changeNick($matches[1]);
}

?>
