<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD%. Get %BOT%´s IP.',
		'out' => 'My IP address is %s.',
		'down' => '%s seems down!',
		'err' => 'Cannot parse 3rd party response for my own IP.',
	),
);

$plugin = Dog::getPlugin();
$url = 'http://www.wechall.net/myip.php';

if (false === ($ip = GWF_HTTP::getFromURL($url)))
{
	$plugin->rply('down', array($url));
}

elseif (!preg_match('/REMOTE_ADDR: ([0-9\\.]+)/', $ip, $matches))
{
	$plugin->rply('err');
}

else
{
	$plugin->rply('out', array($matches[1]));
}
?>
