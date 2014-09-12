<?php
$lang = array(
	'en' => array(
		'help' => 'Wo-Wo-World... of Wonders... http://www.youtube.com/watch?v=lQE5V8QCx9w',
	),
);
$plugin = Dog::getPlugin();

Dog::reply($plugin->lang('help'));
