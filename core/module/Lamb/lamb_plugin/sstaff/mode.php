<?php # Usage: %CMD% <username> <modebit>. Set the server-global mode for a username. bits: asohvpb (admin staff op halfop voice public bot). A user can have only one bit set.
$bot instanceof Lamb;
$user instanceof Lamb_User;
$server instanceof Lamb_Server;
#$message
#$from



#################
### Functions ###
#################
if (!function_exists('lambUserMode200')) { function lambUserMode200(Lamb_User $user, $bool, $char)
{
	static $map = array(
		'a' => Lamb_User::ADMIN,
		's' => Lamb_User::STAFF,
		'o' => Lamb_User::OPERATOR,
		'h' => Lamb_User::HALFOP,
		'v' => Lamb_User::VOICE,
	
	);
	
	$flags = $user->getOptions() & Lamb_User::USERMODE_FLAGS;
	
	$flag = $map[$char];
	
	$username = $user->getName();
	
	if ($bool)
	{
		if ($flags === 0)
		{
			$user->saveOption(Lamb_User::USERMODE_FLAGS, false);
			$user->saveOption($flag, true);
			return sprintf('%s got assigned +%s', $username, $char);
		}
		elseif ($flags === $flag)
		{
			return sprintf('Nothing changed for %s.', $username);
		}
		else
		{
			$user->saveOption(Lamb_User::USERMODE_FLAGS, false);
			$user->saveOption($flag, true);
			return sprintf('%s got changed from +%s to +%s.', $username, lambUserModeToChar($flags), $char);
		}
	}
	else
	{
		if ($flags === $flag)
		{
			$user->saveOption($flag, false);
			return sprintf('%s lost his/her priviledges: -%s', $username, $char);
		}
		else
		{
			return sprintf('Nothing changed for %s.', $username);
		}
	}
	
	
}}


if (!function_exists('lambUserModeToChar')) { function lambUserModeToChar($bit)
{
	switch ($bit)
	{
		case Lamb_User::ADMIN: return 'a';
		case Lamb_User::STAFF: return 's';
		case Lamb_User::OPERATOR: return 'o';
		case Lamb_User::HALFOP: return 'h';
		case Lamb_User::VOICE: return 'v';
		default: return 'p';
	}	
}}


if (!function_exists('lambUserMode200Bot')) { function lambUserMode200Bot(Lamb_User $user, $new)
{
	$username = $user->getName();
	$old = $user->isOptionEnabled(Lamb_User::BOT);
	$nothing_changed = $new === $old ? ' Nothing has changed. ' : ' ';
	$user->saveOption(Lamb_User::BOT, $new);
	if ($new === true)
	{
		return sprintf('The user %s is now flagged as bot.%s', $username, $nothing_changed);
	}
	else
	{
		return sprintf('The user %s is not flagged as bot anymore.%s', $username, $nothing_changed);
	}
}}
########################
### End Of Functions ###
########################

###############
### TRIGGER ###
###############
if ($message === '') {
	return $bot->processMessageA($server, LAMB_TRIGGER.'help mode', $from);
}

$username = Common::substrUntil($message, ' ', $message);
$modebit = Common::substrFrom($message, ' ', false);

if (false === ($user_to_edit = $server->getUser($username))) {
	return $bot->reply(sprintf('The user %s is unknown on this server.', $username));
}

if ( ($modebit !== '+b') && ($modebit !== '-b') && ($modebit !== 'b') )
{
	if (!$user_to_edit->isRegistered()) {
		return $bot->reply(sprintf('%s is not registered with Lamb!', $username));
	}
}

if ($modebit === false)
{
	$opts = $user_to_edit->getOptions();
	$optstr = $opts === 0 ? '0' : '';
//	var_dump($opts);
	for ($i = 1; $i <= 32; $i++)
	{
		$ii = (1<<($i-1));
		if ($ii & Lamb_User::USERMODE_FLAGS)
		{
			if ($opts & $ii) {
				$optstr .= Lamb_User::optionToPriv($i); 
			}
		}
		
		if ($ii === Lamb_User::BOT) {
			if ($opts & $ii) {
				$optstr .= 'b';
			}
		}
	}
	
	return $bot->reply(sprintf('Mode for %s on %s: %s', $username, $server->getHostname(), $optstr));
}
else
{
	$grant = true;
	
	for ($i = 0; $i < strlen($modebit);)
	{
		$msg = '';
		$char = strtolower($modebit{$i++});
		switch ($char)
		{
			case '+': $grant = true; break;
			case '-': $grant = false; break;
			case 'b': $msg .= lambUserMode200Bot($user_to_edit, $grant); break;
			case 'a':
				if ($grant === true)
				{
					if ($server->isAdminUsername($username)) {
						
					}
					elseif ($server->isAdminUsername($user->getName())) {
						$msg .= 'You granted all the admin power to '.$username.'. Very well exploited! ';
					}
					else {
						$bot->reply('You granted all the admin power to '.$username.'. Very well exploited! (probably not)');
						return;
					}
				}
			case 's':
			case 'o':
			case 'h':
			case 'v': $msg .= lambUserMode200($user_to_edit, $grant, $char); break;
			case 'p': break;
			default: $msg .= 'Unknown modebit: '.$char.'. '; break;
		}
	}
	
	if ($msg === '') {
		$msg = 'The [p]ublic bit is useless :]';
	}
	else {
		$server->reloadUser($user_to_edit);
	}
	
	return $bot->reply($msg);
}

?>