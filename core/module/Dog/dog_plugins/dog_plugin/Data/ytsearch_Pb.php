<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD% <search terms>. Display a google search link.',
	),
);
$plugin = Dog::getPlugin();

$searchterm = 'site:www.youtube.com '.$plugin->msg().' -inurl:playlist -inurl:/all_comments/ -inurl:/user/ -inurl:redirect -inurl:/channel/ -inurl:/attribution/';

$plugin->reply('https://google.com/search?q=' . urlencode($searchterm));
