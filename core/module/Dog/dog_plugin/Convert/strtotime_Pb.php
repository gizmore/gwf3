<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD% <date string>. Convert a time string like "31-12-1999 23:59" to a unix timestamp.',
		'out' => 'Unix Timestamp: %s.',
	),
	'de' => array(
		'help' => 'Nutze: %CMD% <Datum>. Konvertiere ein Datumsformat wie z.B. "31-12-1999 23:59" in einen UNIX Zeitstempel.',
		'out' => 'UNIX Zeitstempel: %s.',
	),
);

$plugin = Dog::getPlugin();

if (false !== ($time = strtotime($plugin->msg())))
{
	$plugin->rply('out', array($time));
}
else
{
	$plugin->showHelp();
}
