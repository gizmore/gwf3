<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD%. Drink some gin with %BOT% and dalfor!',
		'young' => 'You are too young for gin, have no age specified, or your brain would suffer too much!',
	),
);
$plugin = Dog::getPlugin();
switch(Dog::getUser()->getName())
{
	default: $plugin->rply('young');
} 
?>
