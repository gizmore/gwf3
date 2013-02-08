<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD% <number>. Check if input is a fibonnaci number.',
	),
);
$plugin = Dog::getPlugin();

$argv = $plugin->argv();

if (count($argv) !== 1)
{
	return $plugin->showHelp();
}

$arg = $argv[0];

if (Common::endsWith($arg, '0'))
{
	Dog::reply('Yes!');
}
else
{
	Dog::reply('No!');
}
?>
