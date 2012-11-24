<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD% <evil plan here>. Gain world domination with your evil plan. TODO: implement.',
		'm0' => 'This is not bizarroworld.',
		'm1' => 'Your evil plan failed.',
		'm2' => 'Syntax error in eval(\'$evil_plan\'); Luckily, the bot did not quit.',
		'm3' => 'Evil plan is running. You did not specify a main contact email tho.',
		'm4' => 'Evil plan is running.',
		'm5' => 'Database error. If you are %s you might have exhausted the evil plan slots.',
	),
);

$plugin = Dog::getPlugin();

if ($plugin->msg() === '')
{
	return $plugin->showHelp();
}

$n = rand(0, 5);

switch ($n)
{
	case 0: case 1:
	case 2: case 3:
	case 4:
		return $plugin->rply('m'.$n);
	case 5:
		return $plugin->rply('m5', array(Dog::getUser()->displayName()));
}
?>
