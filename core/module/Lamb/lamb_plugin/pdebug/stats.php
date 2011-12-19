<?php # Usage: %CMD%. Prints bot statistics.
$servers = $bot->getServers();
$chancount = 0;
$usercount = 0;
$servercount = 0;
foreach ($servers as $s)
{
	$s instanceof Lamb_Server;
	if ($s->getConnection()->isConnected())
	{
		$servercount++;
		$chancount += count($s->getChannels());
		$usercount += count($s->getUsers());
	}
}
$bot->reply(sprintf('Currently I am online on %d servers and %d channels, seeing %d users.', $servercount, $chancount, $usercount));
?>
