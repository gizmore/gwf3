<?php
$bot instanceof Lamb;
$server instanceof Lamb_Server;
// ($args); 0=* 1=Nickname 2=ErrorMessage
Lamb_Log::log($args[2]);

$server->sendNickname();
?>
