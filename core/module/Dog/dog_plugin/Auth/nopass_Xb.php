<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD% <user[!SID]>. Remove the password for a user.',
		'removed' => 'The password for %s has been removed.',
	),
);

$plugin = Dog::getPlugin();
$argv = $plugin->argv();
$argc = count($argv);

if ($argc !== 1)
{
	$plugin->showHelp();
}

elseif (false === ($user = Dog::getOrLoadUserByArg($argv[0])))
{
	Dog::rply('err_user');
}

else
{
	$user->saveVar('user_pass', NULL);
	$plugin->rply('removed', array($user->displayName()));
}
?>
