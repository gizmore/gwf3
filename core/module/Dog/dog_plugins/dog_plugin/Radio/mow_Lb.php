<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD%. Show where you can best listen to Man O War!',
	),
	'de' => array(
		'help' => 'Nutze: %CMD%. Ermittle zuverlässig, wo man am besten Man O War rocken kann!',
	),
	'fr' => array(
		'help' => 'Shit: %CMD%. Montrez nous où vous pouvez écouter le meilleur de Man O War!',
	),
);
$plugin = Dog::getPlugin();
$plugin->reply('http://mp3:iloveyou@mp3.gizmore.org/metal/Manowar "o');
