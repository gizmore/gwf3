<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD%. Play a motivating song on youtube.',
		'up' => '%s (Codemonkey get up get coffee)',
	),
);
$plugin = Dog::getPlugin();
$url = 'http://www.youtube.com/watch?v=TCEo9AXB5eA';
$plugin->rply('up', array($url));
?>
