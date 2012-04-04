<?php
$girls = array(
	'PoisonIvy',
	'IceRain',
);
$girl = $girls[array_rand($girls)];
$bot->reply("I like {$girl}.");
?>