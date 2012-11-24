<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD% <string here>. Print the length of an ascii string. See %T%strlen8.',
		'out' => 'Bytes: %s.',
	),
);
$plugin = Dog::getPlugin();
if ('' === ($message = $plugin->msg()))
{
	return $plugin->showHelp();
}
$plugin->rply('out', array(strlen($message)));
?>
