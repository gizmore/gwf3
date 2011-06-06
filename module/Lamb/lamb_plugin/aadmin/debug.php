<?php # Usage: %CMD%. Prints some statistics to the console.
$channels = $server->getChannels();
echo PHP_EOL;
echo PHP_EOL;
echo 'Server '.$server->getHostname().PHP_EOL;
foreach ($channels as $channel)
{
	echo 'Channel '.$channel->getVar('chan_name').PHP_EOL;
	$users = $channel->getUsers();
	foreach ($users as $data)
	{
		list($user, $mode) = $data;
		echo sprintf('User %s has mode %s.', $user->getVar('lusr_name'), $mode).PHP_EOL;
	}
}
echo PHP_EOL;
echo PHP_EOL;
?>