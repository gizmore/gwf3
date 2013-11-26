<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD% [<iso>]. Set or show your language.',
		'set' => 'Your language on %s has been set from %s to %s.',
		'show' => 'Your language on %s is set to %s.',
	),
);
# Special language codes
$special = array('bot' => 'Bot', 'ibd' => 'IBDES');

$user = Dog::getUser();
$server = Dog::getServer();
$plugin = Dog::getPlugin();
$argv = $plugin->argv();
$argc = count($argv);

if ($argc === 0)
{
	$plugin->rply('show', array($server->displayName(), $user->displayLang()));
}

elseif ($argc === 1)
{
	if (!Dog_Init::isValidISO($argv[0]))
	{
		return Dog::rply('err_lang_iso');
	}
	else
	{
		$old = isset($special[$user->getLangISO()]) ? $special[$user->getLangISO()] : $user->displayLang();
		Dog::getUser()->saveVar('user_lang', $argv[0]);
		$dlang = isset($special[$argv[0]]) ? $special[$argv[0]] : $user->displayLang();
		$plugin->rply('set', array($server->displayName(), $old, $dlang));
	}
}

else
{
	$plugin->showHelp();
}
?>
