<?php # Codemonkey cool down get a beer...
$server instanceof Lamb_Server;
$user instanceof Lamb_User;
$channels = $server->getChannels();
$channel = array_shift($channels);
$channel instanceof Lamb_Channel;
$channel = $channel->getName();
if ($user->getName() === 'gizmore') {
	$steal = '.';
} else {
	$steal = ', but gizmore steals it!';
}
$server->sendAction($channel, sprintf('hands %s a cold beer%s', $user->getName(), $steal));
?>