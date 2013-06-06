<?php
$lang = array(
	'en' => array(
		'help' => 'You can use this function to goto bed. It works!',
		'm1' => 'nighty night %s!',
		'm2' => 'good night %s.',
	),
);
$plugin = Dog::getPlugin();
$channel = Dog::getChannel();
$plugin->reply($plugin->lang('m'.rand(1,2), array(Dog::getUser()->displayName())));
