<?php
$bot instanceof Lamb;
$server instanceof Lamb_Server;
// ($args); 0=* 1=Nickname 2=ErrorMessage
//Lamb_Log::debugCommand($server, 433, $from, $args);
$server->selectNextNickname();
$server->sendNickname();
$server->identify();
?>
