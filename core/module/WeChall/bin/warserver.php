<?php
chdir(dirname(__FILE__));
chdir('../../../../www');

# Load config
require_once 'protected/config.php';

# Init GDO and GWF core
require_once '../gwf3.class.php';

if (false === ($socket = @socket_create(AF_INET, SOCK_STREAM, SOL_TCP)))
{
	die(1);
}

if (!@socket_bind($socket, '0.0.0.0', 4141))
{
	die(2);
}

if (!socket_listen($socket))
{
	die(3);
}

function warscore_debug($message)
{
#	echo $message.PHP_EOL;
}

function warscore_error($socket, $message)
{
	socket_write($socket, $message);
	socket_close($socket);
	if (function_exists('gc_collect_cycles'))
	{
		gc_collect_cycles();
	}
	die(0);
}

function warscore_function($socket, $pid)
{
	# Init GWF
	$gwf = new GWF3(getcwd(), array(
	//	'init' => true,
	// 	'bootstrap' => false,
		'website_init' => false,
		'autoload_modules' => false,
		'load_module' => false,
	// 	'load_config' => false,
		'start_debug' => true,
		'get_user' => false,
	// 	'do_logging' => true,
		'log_request' => false,
	// 	'blocking' => true,
		'no_session' => true,
		'store_last_url' => false,
		'ignore_user_abort' => false,
	));
	GWF_Debug::setDieOnError(false);
	GWF_HTML::init();
	
	if (false === ($wechall = GWF_Module::loadModuleDB('WeChall', true, true, true)))
	{
		warscore_error($socket, 'Cannot load WeChall!');
	}
	$wechall->includeClass('WC_Warbox');
	$wechall->includeClass('WC_WarToken');
	$wechall->includeClass('WC_Warflag');
	$wechall->includeClass('WC_Warflags');
	$wechall->includeClass('sites/warbox/WCSite_WARBOX');
	
	
	if (false === ($input = socket_read($socket, 2048)))
	{
		warscore_error($socket, 'Read Error 1!');
	}
	
	warscore_debug("GOT INPUT: $input");
	
	if (false === ($username = Common::substrUntil($input, "\n", false)))
	{
		warscore_error($socket, 'No username sent!');
	}
	if (false === ($user = GWF_User::getByName($username)))
	{
		warscore_error($socket, 'Unknown user!');
	}
	
	warscore_debug("GOT USER: $username");
	
	if ('' === ($token = Common::substrFrom($input, "\n", '')))
	{
		warscore_error($socket, 'No token sent!');
	}
	$token = trim(Common::substrUntil($token, "\n", $token));
	
	if (!WC_WarToken::isValidWarToken($user, $token))
	{
		warscore_error($socket, 'Invalid Token!');
	}
	
	if (!socket_getpeername($socket, $client_ip, $client_port))
	{
		warscore_error($socket, 'Socket Error 2!');
	}
	
	echo "$client_ip\n";
	
	$boxes = WC_Warbox::getByIP($client_ip);
	if (count($boxes) === 0)
	{
		warscore_error($socket, 'Unknown Warbox!');
	}

	warscore_debug("GOT N BOXES: ".count($boxes));
	
	$curr_port = 0;
	foreach ($boxes as $box)
	{
		$box instanceof WC_Warbox;
		if ($curr_port !== $box->getVar('wb_port'))
		{
			$curr_port = $box->getVar('wb_port');
			warscore_identd($socket, $box, $user, $client_ip, $client_port);
		}
	}

	socket_write($socket, 'Bailing out! You should not see me.');
	socket_close($socket);
	die(0);
}

function warscore_identd($socket, WC_Warbox $box, GWF_User $user, $identd_ip, $identd_port)
{
	warscore_debug("warscore_identd()");

	if (false === ($socket2 = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)))
	{
		warscore_error($socket, 'Could not create socket to your identd.');
		return;
	}
	warscore_debug("socket created");

	warscore_debug("connecting to $identd_ip : {$box->getVar('wb_port')}");
	if (!socket_connect($socket2, $identd_ip, $box->getVar('wb_port')))
	{
		socket_close($socket2);
		warscore_error($socket, 'Could not connect to your identd.');
		return;
	}
	warscore_debug("socket connected");

	warscore_debug("Writing to socket: $identd_port, 4141\\r\\n");
	if (false !== socket_write($socket2, "$identd_port, 4141\r\n"))
	{
		warscore_debug("Wrote to socket. reading now...");
		if (false !== ($in = socket_read($socket2, 2048)))
		{
			warscore_debug("GOT IDENTD RESPONSE: $in");
			if (preg_match("/^ *$identd_port *, *4141 *: *USERID *: *UNIX *:(.*)$/", $in, $matches))
			{
				warscore_success($socket, $box, $user, trim($matches[1]));
			}
			else
			{
				socket_close($socket2);
				warscore_error($socket, 'Invalid response from identd: '.$in);
			}
		}
	}
	
	socket_close($socket2);
}

function warscore_success($socket, WC_Warbox $box, GWF_User $user, $level)
{
	$boxes = WC_Warbox::getByIPAndPort($box->getVar('wb_ip'), $box->getVar('wb_port'));
	
	foreach ($boxes as $box)
	{
		$box instanceof WC_Warbox;
		if (warscore_has_level($box, $level))
		{
			warscore_levelup($socket, $box, $user, $level);
			return;
		}
	}
	
	warscore_error($socket, 'This login is not part of the wargame!');
}

function warscore_levelup($socket, WC_Warbox $box, GWF_User $user, $level)
{
	if ($box->isMultisolve())
	{
		$changed = warscore_levelup_multi($socket, $box, $user, $level);
	}
	else
	{
		$changed = warscore_levelup_single($socket, $box, $user, $level);
	}

	if ($changed)
	{
		$box->recalcPlayersAndScore();
		WC_WarToken::deleteWarToken($user);
		warscore_update($socket, $box, $user, $level);
	}
	else
	{
		warscore_nochange($socket, $box, $user, $level);
	}
}

function warscore_update($socket, WC_Warbox $box, GWF_User $user, $level)
{
	$site = $box->getSite();
	$result = $site->onUpdateUser($user);
	warscore_error($socket, $result->getMessage());
}

function warscore_nochange($socket, WC_Warbox $box, GWF_User $user, $level)
{
	warscore_error($socket, 'You already have solved this challenge. Nothing has changed!');
}

function warscore_levelup_single($socket, WC_Warbox $box, GWF_User $user, $level)
{
	if (false === ($warchall = WC_Warflag::getWarchall($box, $level)))
	{
		return false;
	}
	
	if (WC_Warflags::hasSolved($warchall, $user))
	{
		return false;
	}
	
	if (!WC_Warflags::insertSuccess($warchall, $user))
	{
		return false;
	}
	
	$warchall->setLastSolver($user);
	
	return true;
}

function warscore_levelup_multi($socket, WC_Warbox $box, GWF_User $user, $level)
{
	if (false === ($warchall = WC_Warflag::getWarchall($box, $level)))
	{
		return false;
	}

	if (false === ($warchalls = WC_Warflag::getWarchalls($box)))
	{
		return false;
	}
	
	if (0 >= ($levelnum = warscore_get_level_num($level)))
	{
		return warscore_levelup_single($socket, $box, $user, $level);
	}
	
	$changed = false;
	foreach ($warchalls as $warchall)
	{
		$warchall instanceof WC_Warflag;
		$other_level = $warchall->getVar('wf_title');
		if (0 >= ($olevelnum = warscore_get_level_num($other_level)))
		{
			continue;
		}
		if ($olevelnum > $levelnum)
		{
			continue;
		}
		if (warscore_levelup_single($socket, $box, $user, $other_level))
		{
			$changed = true;
		}
	}
	return $changed;
}

function warscore_get_level_num($level)
{
	return Common::regex('/(\d+)/', $level);
}

function warscore_has_level(WC_Warbox $box, $level)
{
	if ($box->isBlacklisted($level))
	{
		return false;
	}
	return $box->isWhitelisted($level);
}

while(true)
{
	$client_socket = socket_accept($socket);
	
	$pid = pcntl_fork();
	
	if ($pid == -1)
	{
		die('4');
	}
	elseif ($pid) # Parent
	{
		if (function_exists('gc_collect_cycles'))
		{
			gc_collect_cycles();
		}
// 		pcntl_wait($status);
	}
	else # Child
	{
		warscore_function($client_socket, $pid);
	}
}
