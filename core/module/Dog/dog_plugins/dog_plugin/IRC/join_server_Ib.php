<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD% <URL|SID>. Join a server. URL format is ircs://irc.gizmore.org:6697.',
		'err_url' => 'The URL is invalid.',
		'connect' => 'Trying to connect.',
	),
);

$plugin = Dog::getPlugin();

$argv = $plugin->argv();
$argc = count($argv);
if ($argc !== 1)
{
	return $plugin->showHelp();
}

if ( (Common::isNumeric($argv[0])) && (false !== ($server = Dog::getServerByID($argv[0]))) )
{
	$prot = $server->isSSL() ? 'ircs' : 'irc';
	$port = $server->getPort();
}
else
{
	$url = Dog_Server::parseURL($argv[0]);
	if ($url === false)
	{
		return $plugin->rply('err_url');
	}
	$host = $url['host'];
	$prot = $url['prot'];
	$port = $url['port'];
	$options = Dog_Server::DEFAULT_OPTIONS;
	$options |= $url['ssl'] ? Dog_Server::SSL : 0;
}

if ( (false !== ($server = Dog::getServerByArg($argv[0]))) || ((false !== ($server = Dog::getServerByArg($host)))) )
{
	$plugin->reply('reconnecting');
	$server->saveOption(Dog_Server::ACTIVE, true);
	$server->saveOption(Dog_Server::SSL, $prot === 'ircs');
	$server->saveVar('serv_port', $port);
}
else
{
	$plugin->reply('adding_server');
	$server = Dog_Server::getOrCreate($host, $port, $options);
	$server->setVar('dog_connector', Dog::getUser());
	$server->setConf('ircoppass', GWF_Random::randomKey(8));
	Dog::addServer($server);
}

$server->setConnectIn(0.5);

$plugin->rply('connect');
?>
