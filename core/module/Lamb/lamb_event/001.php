<?php
# RPL_WELCOME
#$server->addUser($args[0]); // Add the bot to userlist
$server->identify();
$server->sendBotMode();
$server->autojoinChannels();
$server->probeCapabilites(); 
?>