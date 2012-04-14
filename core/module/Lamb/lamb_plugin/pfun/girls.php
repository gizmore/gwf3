<?php
$girls = array(
	'PoisonIvy',
	'Unholy',
);
$girl = $girls[array_rand($girls)];
$bot->reply("I like {$girl}.");
?>