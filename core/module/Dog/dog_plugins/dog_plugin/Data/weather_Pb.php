<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD% <some location>. Get weather information from google.',
		'err_google' => 'Cannot connect to google.',
		'err_decode' => 'An error occurred in the response processor.',
		'weather' => "Wetter in \x02%s\x02: %s, %s°C, %s.",
	),
);
$plugin = Dog::getPlugin();
$msg = $plugin->msg();


if ($msg === '')
{
	return $plugin->showHelp();
}

return $plugin->rply('NOT WORKING');

$url = "http://www.google.com/ig/api?weather=".urlencode($msg)."&hl=".Dog::getLangISO();

if (false === ($file = GWF_HTTP::getFromURL($url)))
{
	return $plugin->rply('err_google');
}

try
{
	$file = utf8_encode($file);
	if (false !== ($xml = simplexml_load_string($file)))
	{
		$temp = $xml->weather->forecast_information->city;
		$location = $xml->weather->forecast_information->city->attributes()->data;
		$condition = $xml->weather->current_conditions->condition->attributes()->data;
		$temp_c = $xml->weather->current_conditions->temp_c->attributes()->data;
		$humidity = $xml->weather->current_conditions->humidity->attributes()->data;
		$plugin->rply('weather', array($location, $condition, $temp_c, $humidity));
	}
}
catch (Exception $e)
{
}
$plugin->rply('err_decode');
