<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD% [<username>]. Display the global unique userid for a user.',
		'out' => '%s got UID %s and is located on server %s .',
	),
);

$plugin = Dog::getPlugin();

$argv = $plugin->argv();
$argc = count($argv);

switch ($argc)
{
	case 0: $user = Dog::getUser(); break;
	case 1:
		if (false === ($user = Dog::getOrLoadUserByArg($argv[0])))
		{
			return Dog::rply('err_user');
		}
		break;
	default: return $plugin->showHelp();
}
$plugin->rply('out', array($user->displayName(), $user->getID(), $user->getServer()->displayLongName()));
?>
