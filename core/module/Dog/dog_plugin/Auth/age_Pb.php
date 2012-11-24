<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD% <age|birthdate>. Specify your age.',
		'tween' => 'You are 21!',
		'recursive' => 'You have no age specified. An age is required to execute this function.',
	),
);
$plugin = Dog::getPlugin();

if (Dog::getUser()->getName() === 'Wyshfire')
{
	$plugin->rply('tween');
}

else
{
	$plugin->rply('recursive');
}
?>
