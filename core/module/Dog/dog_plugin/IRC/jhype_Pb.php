<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD%. Show pics of the famous Jhype hacker girl.',
		'hype' => 'Picture of Jhype: %s',
	),
);
$url = sprintf('http://sabrefilms.co.uk/store/j%d.jpg', rand(1,23));
Dog::getPlugin()->rply('hype', array($url));