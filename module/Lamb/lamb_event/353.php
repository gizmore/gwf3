<?php
#RPL_NAMREPLY
#:irc.giz.org 353 Lamb = #sr :Lamb @gizmore
# Args
$channel_name = trim($args[2]);
$nicknames = trim($args[3]);
# Get Channel
$channel = $server->getOrCreateChannel($channel_name);
# Add users to channel
foreach (explode(' ', $nicknames) as $nickname)
{
	$usermode = Lamb_User::getUsermode($nickname);
	$nickname = trim($nickname, Lamb_User::USERMODES);
	if (false === ($user = $server->getUserByNickname($nickname))) {
		continue;
	}
	
	if ($usermode !== '')
	{
		echo 'Auto login'.PHP_EOL;
		$user->setLoggedIn(true);
	}
	
	$channel->addUser($user, $usermode);
	$server->addUser($nickname);
}
?>
