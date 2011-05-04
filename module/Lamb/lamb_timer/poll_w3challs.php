<?php
$server instanceof Lamb_Server;
if ($server->getHostname() !== 'irc.idlemonkeys.net') { return; }
//echo "W3Challs...\n";
require_once LAMB::DIR.'Lamb_WC_Forum.php';
lamb_wc_forum('W3C', '[W3Challs]', 'http://w3challs.com/wechall/forum_news.php?datestamp=%DATE%&limit=%LIMIT%');
?>