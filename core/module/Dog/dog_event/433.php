<?php # :irc.giz.org 433 * Dog :Nickname is already in use.
$server = Dog::getServer();
$nick = $server->nextNick();
$server->sendRAW("NICK {$nick->getName()}");
?>
