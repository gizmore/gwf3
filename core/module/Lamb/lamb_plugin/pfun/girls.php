<?php
$girls = array(
	'PoisonIvy',
//	'Xeo',
);
$girl = $girls[array_rand($girls)];
$bot->reply("I like {$girl}.");
?>