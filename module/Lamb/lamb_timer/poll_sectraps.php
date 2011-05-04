<?php
$server instanceof Lamb_Server;
if ($server->getHostname() !== 'irc.idlemonkeys.net') { return; }
//echo "SecTraps...\n";
require_once LAMB::DIR.'Lamb_WC_Forum.php';
lamb_wc_forum('ST', '[SecTraps]', 'http://www.wechall.net/nimda_forum.php?datestamp=%DATE%&limit=%LIMIT%', array('#securitytraps'), 5, array(80), true);
//echo "SecTraps done.\n";
?>