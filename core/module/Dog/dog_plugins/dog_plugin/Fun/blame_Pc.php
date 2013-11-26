<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD%. Figure out who is to blame.',
		'blame' => 'I blame %s.',
	),
);

$plugin = Dog::getPlugin();

# tehron'ed version
$goats = array_map(array('Dog', 'softhyphe'), array("spaceone", "spaceone", "spaceone"));
shuffle($goats);
$rand_keys = array_rand($goats, count($goats));
shuffle($goats);

if  (  (false !== ($channel = Dog::getChannel()))
	&& (!strcasecmp($channel->getName(), '#revolutionelite')) )
{
	$scapegoat = 'sabretooth';
}
else
{
	$scapegoat = $goats[$rand_keys[rand(0, count($goats) - 1)]];
}

$plugin->rply('blame', array($scapegoat));
?>
