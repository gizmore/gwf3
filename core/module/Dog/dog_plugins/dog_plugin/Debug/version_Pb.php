<?php # Usage: %CMD%. Show version of the bot.
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD%. Show the version of %BOT%(tm).',
		'out' => '%s runs %BOT% version %s - %s - %s. %s %s - PHP %s - Time is %s.',
		'nb' => 'non-blocking-io'
	),
);

$owner = 'gizmore';
#DOG
$version = '4.00';
$console = 'console';
$blocking = 'non-blocking-io';
$plugin = Dog::getPlugin();

$plugin->rply('out', array($owner, $version, $console, $blocking, php_uname('s'), php_uname('r'), PHP_VERSION, date('H:i:s')));
?>
