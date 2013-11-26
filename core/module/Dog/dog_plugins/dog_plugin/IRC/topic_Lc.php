<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD% <topic here ...>. Let %BOT% set the channels topic.',
	),
);
$plugin = Dog::getPlugin();

$argv = $plugin->argv();
$argc = count($argv);

if ($argc === 0)
{
	return $plugin->showHelp();
}

$channel = Dog::getChannel();

Dog::getServer()->sendRAW("TOPIC {$channel->getName()} :{$plugin->msg()}")
?>
