<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD% [base64encodedString]. Decode a Base64 string to UTF8.',
		'no_b64' => 'Your input does not seem to be common base64.',
		'decoded' => 'Output: %s',
			
	),
	'de' => array(
		'help' => 'Nutze: %CMD% [base64encodedString]. Dekodiere eine Base64 Zeichenkette nach UTF8.',
		'no_b64' => 'Deine Eingabe scheint kein gewöhnliches Base64 zu sein.',
		'decoded' => 'Ausgabe: %s',
	),
);
$plugin = Dog::getPlugin();
if ('' === ($message = $plugin->msg()))
{
	$plugin->showHelp();
}

else if (false == ($utf8 = base64_decode($message)))
{
	$plugin->rply('no_b64');
}

else
{
	$plugin->rply('decoded', array($utf8));
}
