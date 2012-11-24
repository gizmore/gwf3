<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD% <string here>. Print the length of an utf8 string. See %T%strlen.',
		'out' => 'UTF8 Length: %s.',
	),
);
$plugin = Dog::getPlugin();
if ('' === ($message = $plugin->msg()))
{
	return $plugin->showHelp();
}
$plugin->rply('out', array(GWF_String::strlen($message)));
?>
