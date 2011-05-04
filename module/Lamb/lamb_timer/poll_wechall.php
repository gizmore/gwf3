<?php
$server instanceof Lamb_Server;
if ($server->getHostname() !== 'irc.idlemonkeys.net') { return; }
//echo "WeChall...\n";
require_once LAMB::DIR.'Lamb_WC_Forum.php';
lamb_wc_forum('WC', '[WeChall]', 'http://www.wechall.net/nimda_forum.php?datestamp=%DATE%&limit=%LIMIT%', array(), 5, true, array(80));
//echo "WeChall done.\n";
?>