<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD% <date string>. Convert a time string like "31-12-1999 23:59" to a unix timestamp.',
		'out' => 'Unix Timestamp: %s.',
	),
);

$plugin = Dog::getPlugin();

if (false !== ($time = strtotime($message)))
{
	$plugin->rply('out', array($time));
}
else
{
	$plugin->showHelp();
}
?>
