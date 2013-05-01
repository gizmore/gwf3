<?php
$bot instanceof Lamb;
$server instanceof Lamb_Server;
Lamb_Log::logError(sprintf('ERROR: %s: %s', $command, implode(', ', $args)));
Lamb_Log::debugCommand($server, $command, $from, $args)
?>
