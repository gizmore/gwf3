<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD%. Read: Wine, not whine!',
		'wine' => 'A glas of wine, like a sire!',
	),
);
$plugin = Dog::getPlugin();

if ($plugin->argc() > 0)
{
	$plugin->showHelp();
}
else
{
	$plugin->rply('wine');
}
?>
