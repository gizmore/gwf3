<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD% [<user>]. Give or grab a whisky to settle the day.',
		'give1' => 'passes 1 glass of scotch whisky to %s.',
		'give2' => 'and %s pass 1 glass of scotch whisky to %s.',
	),
	'de' => array(
		'help' => 'Nutze: %CMD% [<user>]. Gib jemandem oder gönne Dir ein Glas Whisky um den Abend zu geniessen.',
		'give1' => 'reicht %s ein Glas Whisky.',
		'give2' => 'und %s reichen %s ein Glas Whisky. Wohl bekommt´s.',
	),
);
$plugin = Dog::getPlugin();
$user = Dog::getUser();
$unam = $user->getName();

# Output
$args = $plugin->argv();
if ( (count($args) === 1) && ( $args[0] != '') && ( $args[0] != $unam) )
{
	$plugin->rplyAction('give2', array($unam, $args[0]));
}
else 
{
	$plugin->rplyAction('give1', array($unam));
}
