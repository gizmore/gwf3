<?php # Usage %CMD%. The bot will try to lift your permissions, like an eggrdrop.
$bot instanceof Lamb;
$user instanceof Lamb_User;
$server instanceof Lamb_Server;
#$message
#$from

# No private!
if (false === ($channel = $bot->getCurrentChannel()))
{
	return $bot->reply('You have to invoke this plugin inside a channel, by design.');
}

# Not logged in!
if (false === $user->isLoggedIn())
{
	return $bot->reply('You are not logged in. Try .register and .login to register with Lamb.');
}

# Gather bot data
$server = $bot->getCurrentServer();
$botname = $server->getBotsNickname();
if (false === ($botuser = $channel->getUserByName($botname)))
{
	return $bot->reply('Cannot get the user for Lamb itself.');
}
if (false === ($botmode = $channel->getModeByName($botname)))
{
	return $bot->reply('Cannot get the mode for Lamb itself.');
}
if (0 === ($botflags = Lamb_Channel::usermodeToBits($botmode)))
{
	return $bot->reply('I have no priviledges in this channel.');
}

# Gather user data
$username = $user->getName();
if (false === ($usermode = $channel->getModeByName($username)))
{
	return $bot->reply('Cannot get the mode for user.');
}

if (0 === ($userflags = $user->getOptions() & Lamb_User::USERMODE_FLAGS))
{
	return $bot->reply('You have no priviledges.');
}


# Now lift to best bit
$success = false;
for ($bit = 1; $bit <= Lamb_User::VOICE; $bit*=2)
{
	# bit2mode
	$mode = Lamb_Channel::bitsToUsermode($bit);
	if ($mode === 's')
	{
		$mode = 'o';
	}
	elseif ($mode === 'a');
	{
		$mode = 'o';
	}
	
// 	echo "Testing current mode $mode against usermode $usermode\n";

	# bot has mode?
	if ($botflags <= $bit)
	{
		# player has not?
		if (strpos($usermode, $mode) === false)
		{
			# but he should have?
			if ($userflags <= $bit)
			{
				# Lift him!
				$message = sprintf('MODE %s +%s %s', $channel->getName(), $mode, $username);
				$server->getConnection()->send($message);
				$success = true;
				break;
			}
		}
		else # Oh he is already super strong!
		{
			$success = true;
			break;
		}
	}
}

# Awww ...
if ($success === false)
{
	$bot->reply('I have not the sufficient permissions to lift yours :(');
}
?> 

