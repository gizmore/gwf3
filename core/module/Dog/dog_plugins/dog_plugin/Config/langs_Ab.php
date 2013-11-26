<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD [<iso>]. Show or set the language for a server.',
		'set' => 'The default language for %s has been set from %s to %s.',
		'show' => 'The default language for %s is currently set to %s.',
	),
	'de' => array(
		'help' => 'Nutze: %CMD [<iso>]. Zeige oder setze die Sprache für einen Server.',
		'set' => 'Die voreingestellte Sprache für %s wurde von %s auf %s gesetzt.',
		'show' => 'Die voreingestellte Sprache für %s ist %s.',
	),
);
$server = Dog::getServer();
$plugin = Dog::getPlugin();
$argv = $plugin->argv();
$argc = count($argv);
if ($argc === 0)
{
	$plugin->rply('show', array($server->displayName(), $server->displayLang()));
}
elseif ($argc === 1)
{
	if (!Dog_Init::isValidISO($argv[0]))
	{
		return Dog::rply('err_lang_iso');
	}
	$old = $server->displayLang();
	$server->saveVar('serv_lang', $argv[0]);
	$plugin->rply('set', array($server->displayName(), $old, $server->displayLang()));
}
else
{
	$plugin->showHelp();
}
?>
