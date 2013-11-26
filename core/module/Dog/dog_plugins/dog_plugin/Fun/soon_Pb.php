<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD%. Show gizmore´s definition of soon. Use it when gizmore types "soon".',
		'out' => 'soon: A unix timestamp larger than %d. Value might be off, due to timezone ignorance.',
	),
);
$plugin = Dog::getPlugin();
$plugin->reply($plugin->lang('out', time()));
