<?php # PING :irc.giz.org
Dog::getServer()->sendRAW('PONG '.Dog::argv(0), false);
?>
