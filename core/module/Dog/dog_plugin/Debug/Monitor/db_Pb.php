<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD%. Print database connection statistics.',
		'stats' => 'Database stats since last startup: Total DB time is %.02fs with %d queries within %s (%.02f qps). Queries opened/closed: %s/%s.',
	),
	'de' => array(
		'help' => 'Nutze: %CMD%. Zeige DATENBANKZUGRIFFSSTATISTIKEN!!!!!',
		'stats' => 'Datenbank Statistiken seit dem letzten Startvorgang: Verbrachte Zeit in der DB ist %.02fs mit %d Abfragen in %s (%.02f QpS). Abfragen Offen/Beendet: %s/%s.',
	),
);
$db = gdo_db();
$c = $db->getQueryCount();
$ct = $db->getQueryTime();
$t = microtime(true) - Dog_Init::getStartupTime();
$dt = GWF_Time::humanDuration($t);
$tps = $c / $t;
$qo = $db->getQueriesOpened();
$qc = $db->getQueriesClosed();
Dog::getPlugin()->rply('stats', array($ct, $c, $dt, $tps, $qo, $qc));
?>
