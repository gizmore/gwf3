<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: never smile. Enables Partyland mode: https://www.youtube.com/watch?feature=player_detailpage&v=E0Mi1ANe79o#t=529s',
	),
);

$plugin = Dog::getPlugin();

$server = Dog::getServer();

$channel = Dog::getChannel();
$channame = $channel->getName();

if (rand(0,2))
{
	return Dog::reply($plugin->getHelp());
}

$names = array();
foreach ($channel->getUsers() as $user)
{
	$names[] = $user->getName();
}

while (count($names) > 0)
{
	$_names = array_slice($names, 0, 10);
	$names = array_slice($names, 10);
	$_modes = str_repeat('o', count($_names));
	$_names = implode(' ', $_names);
	$server->sendRAW("MODE {$channame} +{$_modes} $_names");
}
