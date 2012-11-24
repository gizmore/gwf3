<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD%. Dog sees a cat!',
		'r0' => 'Bark! Bark!',
		'r1' => 'Woof! Woof!',
		'r2' => 'shrug!',
	),
);
$plugin = Dog::getPlugin();
$plugin->replyAction($plugin->lang('r'.rand(0,2)));
?>
