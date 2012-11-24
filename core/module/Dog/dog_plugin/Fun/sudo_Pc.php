<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD% <linux command line>. Execute a command on the server.',
		'wish' => 'You wish ;)',
	),
);
$plugin = Dog::getPlugin();

if ($plugin->argc() === 0)
{
	$plugin->showHelp();
}
else
{
	$plugin->rply('wish');
}
?>
