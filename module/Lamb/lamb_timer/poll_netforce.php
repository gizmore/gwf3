<?php
$server instanceof Lamb_Server;
if ($server->getHostname() !== 'irc.idlemonkeys.net') { return; }
//echo "NetForce...\n";
require_once LAMB::DIR.'Lamb_WC_Forum.php';
lamb_wc_forum('NF', '[Net-Force]', 'http://net-force.nl/wechall/forum_news.php?datestamp=%DATE%&limit=%LIMIT%', array('#net-force', '#wechall', '#shadowlamb', '#sr'));
//echo "NetForce Done.\n";
?>