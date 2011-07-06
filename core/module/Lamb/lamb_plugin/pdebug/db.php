<?php # Print database connection statistics. 
$bot instanceof Lamb;
$server instanceof Lamb_Server;
$db = gdo_db();
$c = $db->getQueryCount();
$ct = $db->getQueryTime();
//$dd = GWF_Time::displayAgeTS(microtime(true)-$d);
$t = microtime(true)-GWF_Settings::getSetting('_lamb3_startuptime');
$dt = GWF_Time::humanDuration($t);
$tps = $c / $t;
$qo = $db->getQueriesOpened();
$qc = $db->getQueriesClosed();
$bot->reply(sprintf("Database stats since last startup: Total DB time is %.02fs with %d queries within %s (%.02f qps). Queries opened/closed: %s/%s.", $ct, $c, $dt, $tps, $qo, $qc));
?>