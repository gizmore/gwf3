<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD%. Show a hint how to register on hackquest.',
		'info' => 'The question is not "what is the name of this site". The question is "etis siht fo eman eht si tahw". If you need more help ask in the channel.',
	),
);
$plugin = Dog::getPlugin();

if ($plugin->argc() !== 0)
{
	$plugin->showHelp();
}

else
{
	$plugin->rply('info');
}
?>
