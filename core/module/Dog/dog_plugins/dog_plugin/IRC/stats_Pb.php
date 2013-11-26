<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD%. Prints bot statistics.',
		'stats' => 'Currently I am online on %d servers and %d channels, seeing %d users.',
	),
	'de' => array(
		'help' => 'Nutze: %CMD%. Gibt Verbindungsstatistiken aus.',
		'stats' => 'Zur Zeit bin ich Online in %d Netzwerken und %d Kanälen. Im Speicher befinden sich %d Benutzer.',
	),
		
);
$plugin = Dog::getPlugin();
$servcount = 0;
$chancount = 0;
$usercount = 0;
foreach (Dog::getServers() as $server)
{
	$server instanceof Dog_Server;
	if ($server->getConnection()->isConnected() && $server->getConnection()->alive())
	{
		$servcount++;
		$chancount += count($server->getChannels());
		$usercount += count($server->getUsers());
	}
}
$plugin->rply('stats', array($servcount, $chancount, $usercount));
?>
