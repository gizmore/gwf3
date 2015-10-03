<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD% <server> <URL>. Change the URL for the given server.',
		'err_url' => 'The URL is invalid.',
		'ok' => 'Done.',
	),
);
$plugin = Dog::getPlugin();
$user = Dog::getUser();
$argv = $plugin->argv();
$argc = count($argv);

if ($argc !== 2)
{
	return $plugin->showHelp();
}

if (false === ($server = Dog::getServerByArg($argv[0])))
{
	return Dog::rply('err_server');
}

if (false === ($url = Dog_Server::parseURL($argv[1])))
{
	return $plugin->rply('err_url');
}

$server->saveOption(Dog_Server::SSL, $url['ssl']);
$server->saveVar('serv_host', $url['host']);
$server->saveVar('serv_port', $url['port']);

$plugin->rply('ok');

?>
