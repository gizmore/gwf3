<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD% [<server>]. Command %BOT% to quit a server.',
		'ok' => 'Disconnecting from %s...',
		'msg' => '%s executed %CMD%!',
	),
);
$plugin = Dog::getPlugin();
$user = Dog::getUser();
$argv = $plugin->argv();
$argc = count($argv);

if ($argc === 0)
{
	$server = Dog::getServer();
}

elseif ($argc === 1)
{
	if (false === ($server = Dog::getServerByArg($argv[0])))
	{
		return Dog::rply('err_server');
	}
}

else
{
	return $plugin->showHelp();
}

$server->saveOption(Dog_Server::ACTIVE, false);
$plugin->rply('ok', array($server->displayLongName()));
$server->disconnect($plugin->lang('msg', array($user->displayName())));

if (!$server->hasConnectedOnce())
{
	Dog::removeServer($server);
	$server->delete();
}
?>
