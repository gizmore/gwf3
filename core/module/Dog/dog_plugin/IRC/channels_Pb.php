<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD% [<server>]. List the channels where %BOT% is online.',
		'none' => 'I am not connected to any channel on %s.',
		'out' => 'I am in %d channels on %s: %s.',
	),
);
$plugin = Dog::getPlugin();

$argv = $plugin->argv();
$argc = count($argv);

if ($argc === 0)
{
	$server = Dog::getServer();
}
elseif ($argc !== 1)
{
	return $plugin->showHelp();
}
else
{
	if (false === ($server = Dog::getServerByArg($argv[0])))
	{
		return Dog::rply('err_server');
	}
}

if (!$server->isConnected())
{
	return Dog::rply('err_connection');
}

$out = '';
$channels = $server->getChannels();
foreach ($channels as $channel)
{
	$channel instanceof Lamb_Channel;
	$out .= sprintf(', %s(%d)', $channel->getName(), count($channel->getUsers()));
}

if ($out === '')
{
	return $plugin->rply('none', array($server->displayName()));
}

$plugin->rply('out', array(count($channels), $server->displayName(), substr($channels, 2)));
?>
