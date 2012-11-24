<?php
####conf ircoppass,g,x,ircop
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD% <superpassword> [<username>]. Will grant a user all privileges.',
		'wrong' => 'Wrong password!',
		'super' => 'The user %s got granted all privileges on server %s.',
		'ircop' => 'The user %s got granted irc operator privileges in all channels on server %s.',
		'user' => 'This user is unknown',
		'not_regged' => '%s has not registered on %s yet.',
	),
);

$plugin = Dog::getPlugin();
$server = Dog::getServer();
$argc = $plugin->argc();
$argv = $plugin->argv();

unset($user);
if ($argc === 2)
{
	if (false === ($user = Dog_User::getByLongName($argv[1])))
	{
		return $plugin->rply('user');
	}
	$server = $user->getServer();
	$argc = 1;
}

if ($argc === 1)
{
	if (!isset($user))
	{
		$user = Dog::getUser();
	}
	
	if (!$user->isRegistered())
	{
		return $plugin->rply('not_regged', array($user->displayName(), $server->displayName()));
	}
	
	if ($argv[0] === Dog_Conf_Bot::getConf('superword', 'gizmore'))
	{
		Dog_PrivServer::grantAll($server, $user);
		Dog_PrivChannel::grantAllToAll($server, $user);
		$plugin->rply('super', array($user->displayName(), $server->displayName()));
	}
	elseif ($argv[0] === $server->getConf('ircoppass'))
	{
		Dog_PrivServer::grantIrcop($server, $user);
		Dog_PrivChannel::grantAllToAll($server, $user, Dog_IRCPriv::allBitsButOwner());
		$plugin->rply('super', array($user->displayName(), $server->displayName()));
	}
	else
	{
		$plugin->rply('wrong');
	}
}
else
{
	$plugin->showHelp();
}
?>
