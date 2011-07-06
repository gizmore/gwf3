<?php
$bot instanceof Lamb;
$server instanceof Lamb_Server;
$target = Common::substrUntil($message, ' ', $message);
$message = Common::substrFrom($message, ' ', '');
$server->sendNotice($target, $message);
?>
