<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD%. Codemonkey gets up gets coffee.',
		'coff' => 'hands %s a cup of hot coffee.',
	),
);

$plugin = Dog::getPlugin();

if ($plugin->argc() !== 0)
{
	$plugin->showHelp();
}

else
{
	$plugin->rplyAction('coff', array(Dog::getUser()->getName()));
}
?>
