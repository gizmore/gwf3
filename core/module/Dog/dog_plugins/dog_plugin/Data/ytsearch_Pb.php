<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD% <search terms>. Use a google dork to search for youtube videos :=)',
	),
	'de' => array(
		'help' => 'Nutze: %CMD% <Suchbegriff>. Nutze einen "Google-Dork" um auf Youtube nach Videos zu suchen (how search was meant to be)  :=)',
	),
);
$plugin = Dog::getPlugin();

#$searchterm = 'site:www.youtube.com '..' -inurl:playlist -inurl:/all_comments/ -inurl:/user/ -inurl:redirect -inurl:/channel/ -inurl:/attribution/';

$plugin->reply('http://ytsearch.net/' . urlencode($plugin->msg()));
