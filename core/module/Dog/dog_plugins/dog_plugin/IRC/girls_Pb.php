<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD%. Show the IRC girls who %BOT% likes the most.',
		'like' => 'I like %s.',
	),
);

$plugin = Dog::getPlugin();

$girls = array(
	'PoisonIvy',
	'Wyshfire',
	'gemgale',
	'Unholy',
// 	'nour',
	'anjaa',
	'jenni',
	'Rhonda',
	'Trinary',
	'ziza',
	'Jhype',
// 	'Ronja',
	'anna_at_annaslut.com',
);

$girl = $girls[array_rand($girls)];

$plugin->rply('like', array($girl));
?>
