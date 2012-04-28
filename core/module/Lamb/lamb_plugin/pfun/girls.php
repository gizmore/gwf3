<?php
$girls = array(
	'PoisonIvy',
	'Unholy',
	'bb',
);
$girl = $girls[array_rand($girls)];
$bot->reply("I like {$girl}.");
?>