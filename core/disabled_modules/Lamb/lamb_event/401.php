<?php #:natalya.psych0tik.net 401 Richard Orpheus :No such nick/channel
#CMD: 401
#FROM: natalya.psych0tik.net
#ARGS: Richard,Orpheus,No such nick/channel
//Lamb_Log::logDebug(sprintf('Removing user %s from memory ... ', $args[1]));
$server->remUser($args[1]);
?>