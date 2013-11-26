<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD% [<timestamp>] [<timezone>]. Convert a unix timestamp to a date.',
		'conv' => 'Timestamp %s will be %s.',
	),
);

$plugin = Dog::getPlugin();
if ('' === ($message = $plugin->msg()))
{
	return $plugin->showHelp();
}

$args = explode(' ', $message);
if (count($args) === 1)
{
	$args[] = 'CET';
}

if (count($args) !== 2)
{
	return $plugin->showHelp();
}

$plugin->rply('conv', array($args[0], GWF_Time::displayTimestamp($args[0], Dog::getLangISO(), 'Invalid date')));
?>
