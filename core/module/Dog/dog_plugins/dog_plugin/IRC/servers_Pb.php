<?php
####conf retries,s,i,i,20,,,timeout,s,i,i,5,,,throttle,s,i,i,3,,,ircoppass,s,i,s,""
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD% [<server>]. Show the available servers and their throttle, connected servers have a bold ID, or show connection details for a specified server.',
		'conf_retries' => 'Number of reconnect attempts.',
		'conf_timeout' => 'Timeout of a single connection attempt.',
		'conf_throttle' => 'Messages per .33 seconds. 3 equals 1 msg/s.',
		'server' => '%s has set the throttle to %s and a connect timeout of %s seconds with %s retries. URI: %s',
		'servers' => '%d/%d servers: %s.',
	),
);

$plugin = Dog::getPlugin();
$argv = $plugin->argv();
$argc = count($argv);

if ($argc === 0)
{
	$out = '';
	$active = 0;
	$total = 0;
	foreach (Dog::getServers() as $server)
	{
		$server instanceof Dog_Server;
		$t = $server->getThrottle();
		$bt = $t == 0 ? chr(2) : '';
		$out .= sprintf(', %s%s(T%s)%s', $server->displayLongName(), $bt, $t, $bt);
		$active += $server->isConnected() ? 1 : 0;
		$total++;
	}
	
	$plugin->rply('servers', array($active, $total, substr($out, 2)));
	
}
elseif ($argc === 1)
{
	if (false === ($server = Dog::getServerByArg($argv[0])))
	{
		Dog::rply('err_server');
	}
	else
	{
		$url = $server->isSSL() ? 'ircs://' : 'irc://';
		$url .= $server->getURL();
		$plugin->rply('server', array($server->displayLongName(), $server->getThrottle(), $server->getTimeout(), $server->getRetries(), $url));
	}
}
else
{
	$plugin->showHelp();
}
?>
