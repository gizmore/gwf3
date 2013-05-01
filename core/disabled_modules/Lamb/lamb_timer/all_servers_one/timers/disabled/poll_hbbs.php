<?php
$lamb = Lamb::instance();
$server instanceof Lamb_Server;
if (strpos($server->getHostname(), '2600') === false) { return; }

require_once LAMB::DIR.'Lamb_WC_Forum.php';
//lamb_wc_forum('HBBS', '[HBBS]', 'http://?datestamp=%DATE%&limit=%LIMIT%', array('#hbbs','#shadowlamb'), 5, false, false);
echo "HBBS NOW!\n";
?>