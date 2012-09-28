<?php
$girls = array(
	'PoisonIvy',
	'Wyshfire',
	'Unholy',
	'bb',
);
$girl = $girls[array_rand($girls)];
$bot->reply("I like {$girl}.");
?>