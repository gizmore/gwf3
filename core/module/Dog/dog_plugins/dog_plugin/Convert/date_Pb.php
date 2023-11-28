<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD% [<timestamp>]. Convert a unix timestamp to a date.',
		'conv' => 'Timestamp %s is %s.',
	),
);

$plugin = Dog::getPlugin();
if ('' === ($message = $plugin->msg()))
{
	$plugin->showHelp();
	return;
}

if (!is_numeric($message))
{
	$plugin->showHelp();
	return;
}

$timestamp = (int) $message;
$plugin->rply('conv', array($timestamp, GWF_Time::displayTimestamp($timestamp, Dog::getLangISO(), 'Invalid date')));
