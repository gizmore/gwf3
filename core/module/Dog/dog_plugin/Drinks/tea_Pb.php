<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD% [<nickname>]. Virtually get some tea or give it to others. If the issuer is gizmore it means he wants to drink beer instead.',
		'tea' => 'hands %s a cup of hot tea.',
	),
);
$plugin = Dog::getPlugin();
$argv = $plugin->argv();
$argc = count($argv);
if ($argc === 0)
{
	$argv[0] = Dog::getUser()->getName();
}
elseif ($argc > 1)
{
	$plugin->showHelp();
}
else
{
	$plugin->rplyAction('tea', array($argv[0]));
}
?>
