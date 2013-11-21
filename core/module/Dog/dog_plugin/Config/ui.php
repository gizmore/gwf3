<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD% [<setting>] [<value>]. Show or set the user interface settings for your user.',
	),
);

$plugin = Dog::getPlugin();
$argv = $plugin->argv();
$argc = count($argv);

if ($argc > 2)
{
	$plugin->showHelp();
}
elseif ($argc === 0)
{
	
}
elseif ($argc === 1)
{

}
elseif ($argc === 2)
{

}
