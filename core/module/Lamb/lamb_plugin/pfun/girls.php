<?php
$girls = array(
	'PoisonIvy',
	'Wyshfire',
	'gemgale',
	'Unholy',
	'bb',
);
$girl = $girls[array_rand($girls)];
$bot->reply("I like {$girl}.");
?>