<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD% <some location>. Get weather information by location name or zipcode. Provided by wttr.in.',
		'err_fetch' => 'Cannot connect to weather provider.',
	),
);
$plugin = Dog::getPlugin();
$msg = $plugin->msg();


if ($msg === '')
{
	return $plugin->showHelp();
}

$url = "https://wttr.in/" . urlencode($msg) . '?format=3';
$response = GWF_HTTP::getFromURL($url);

if ($response === false)
{
	return $plugin->rply('err_fetch');
}

$plugin->reply(urldecode($response));
