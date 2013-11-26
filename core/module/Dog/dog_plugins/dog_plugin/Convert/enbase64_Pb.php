<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD% [some message to encode]. Encode a string with Base64.',
		'encoded' => 'Output: %s',
			
	),
	'de' => array(
		'help' => 'Nutze: %CMD% [Nachricht zum encodieren]. Kodiere eine Nachricht in Base64.',
		'encoded' => 'Ausgabe: %s',
	),
);

$plugin = Dog::getPlugin();

if ('' === ($message = $plugin->msg()))
{
	$plugin->showHelp();
}

else
{
	$plugin->rply('encoded', array(base64_encode($message)));
}
