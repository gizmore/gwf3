<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD% [<user>]. Give or grab a whiskey to settle the day.',
		'give1' => 'passes 1 jar of moonshine to %s.',
		'give2' => 'and %s pass 1 jar of moonshine to %s.',
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
