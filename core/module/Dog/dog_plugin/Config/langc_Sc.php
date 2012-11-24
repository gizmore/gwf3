<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD [<iso>]. Show or set the language for a channel.',
		'set' => 'The language for %s on %s has been set from %s to %s.',
		'show' => 'The language for %s on %s is set to %s.',
	),
	'de' => array(
		'help' => 'Nutze: %CMD [<iso>]. Zeige oder setze die Sprache für einen Kanal.',
		'set' => 'Die Sprache für %s auf %s wurde von %s auf %s gesetzt.',
		'show' => 'Die Sprache für %s auf %s ist auf %s eingestellt.',
	),
);
if (false === ($channel = Dog::getChannel()))
{
	return Dog::rply('err_only_channel');
}
$server = $channel->getServer();
$plugin = Dog::getPlugin();
$argv = $plugin->argv();
$argc = count($argv);
if ($argc === 0)
{
	$plugin->rply('show', array($channel->displayName(), $server->displayName(), $channel->displayLang()));
}
elseif ($argc === 1)
{
	if (!Dog_Init::isValidISO($argv[0]))
	{
		return Dog::rply('err_lang_iso');
	}
	$old = $channel->displayLang();
	$channel->saveVar('chan_lang', $argv[0]);
	$plugin->rply('set', array($channel->displayName(), $server->displayName(), $old, $channel->displayLang()));
}
else
{
	$plugin->showHelp();
}
?>
