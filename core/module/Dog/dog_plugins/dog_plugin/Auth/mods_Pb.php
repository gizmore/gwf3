<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD% [<user>] [<+|-><flags>]. Set or show the serverwide mode for a user.',
		'show' => '%s has +%s on %s.',
		'set' => '%s´s mode on %s has been set to %s.',
// 		'egg' => 'Very well exploited, You granted all the admin power to %s. Well Done! (probably not)',
		'no' => 'Your permissions are not high enough to grant %s to %s.',
		'no2' => 'Your permissions are not high enough to remove %s from %s.',
		'not_regged' => '%s is not registered with %BOT%.',
	),
);

$plugin = Dog::getPlugin();
$serv = Dog::getServer();
$argv = $plugin->argv();
$argc = count($argv);

if ($argc === 0)
{
	# Show for yourself
	$argv[] = Dog::getUser()->getName();
	$argc = 1;
}

if ($argc === 1)
{
	# Show for a user
	if (false === ($user = Dog::getOrLoadUserByArg($argv[0])))
	{
		Dog::rply('err_user');
	}
	else
	{
		Dog_PrivServer::flushPermcache($serv, $user);
		$privstr = Dog_PrivServer::displayPrivs($serv, $user);
		$plugin->rply('show', array($user->displayName(), $privstr, $serv->displayName()));
	}
}
elseif ($argc === 2)
{
	$sign = $argv[1][0];
	$privs = Dog_IRCPriv::filterPrivsToEdit($argv[1]);
	
	# Alter Privs
	if (false === ($user = Dog::getOrLoadUserByArg($argv[0])))
	{
		Dog::rply('err_user');
	}
	elseif (!$user->isRegistered())
	{
		$plugin->rply('not_regged', array($user->displayName()));
	}
	elseif ( ($sign === '+') && (strlen($privs) >= 1) )
	{
		$u = Dog::getUser();
		$have = Dog_PrivServer::getPermbits($serv, $u);
		$want = Dog_IRCPriv::charsToBits($privs);
		$high = Dog_IRCPriv::getHighestBit($have);
		$wigh = Dog_IRCPriv::getHighestBit($want);
		if ($wigh > $high)
		{
			$plugin->rply('no', array(Dog_IRCPriv::displayBits($wigh, ''), $user->displayName()));
		}
		else
		{
			$now = Dog_PrivServer::getPermbits($serv, $user) | $want;
			Dog_PrivServer::setPermbits($serv, $user, $now);
			$plugin->rply('set', array($user->displayName(), $serv->displayName(), Dog_IRCPriv::displayBits($now)));
		}
	}
	elseif ( ($sign === '-') && (strlen($privs) >= 1) )
	{
		$u = Dog::getUser();
		$have = Dog_PrivServer::getPermbits($serv, $u);
		$want = Dog_IRCPriv::charsToBits($privs);
		$high = Dog_IRCPriv::getHighestBit($have);
		$wigh = Dog_IRCPriv::getHighestBit($want);
		if ($wigh > $high)
		{
			$plugin->rply('no2', array(Dog_IRCPriv::displayBits($wigh, ''), $user->displayName()));
		}
		else
		{
			$now = Dog_PrivServer::getPermbits($serv, $user) & (~$want);
			Dog_PrivServer::setPermbits($serv, $user, $now);
			$plugin->rply('set', array($user->displayName(), $serv->displayName(), Dog_IRCPriv::displayBits($now)));
		}
	}
	else
	{
		$plugin->showHelp();
	}
}
else
{
	$plugin->showHelp();
}
?>
