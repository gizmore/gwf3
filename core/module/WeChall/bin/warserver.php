<?php

# Protocol v1
#
# CLIENT -> SERVER: <wechall user name> LF
# CLIENT -> SERVER: <wechall user token> LF
# SERVER -> IDENTD: <ident request for client connection>
# IDENTD -> SERVER: <ident response>
# SERVER -> CLIENT: <result message>
#
#
# Protocol v2
#
# CLIENT -> SERVER: LF 'WARSOLVEv2' LF
# CLIENT -> SERVER: <JSON data> LF
# (optional IDENT interaction)
# SERVER -> CLIENT: ('ERROR' | 'SUCCESS') <result message> LF
#
# JSON data: object with the following fields.
#   wechall_username: <wechall user name>               (required)
#   wechall_token: <wechall user name>                  (required)
#   warbox_level: <warbox level name>                   (optional)
#   warbox_password: <warbox level password>            (optional)
#   warbox_password_hash: <warbox level password hash>  (optional)
#
# If warbox_level is present, so should (exactly) one of warbox_password
# and warbox_password_hash. Password (hash) will be checked against WeChall
# database.
# If warbox_level is not present, ident is used (as with protocol v1).
#


chdir(dirname(__FILE__));
chdir('../../../../www');

# Load config
require_once 'protected/config.php';

# Init GDO and GWF core
require_once '../gwf3.class.php';

# Default configurition is for old (v1) behaviour
$protocol_version = 1;
$use_ssl = false;
$bind_addr = '0.0.0.0';
$bind_port = 4141;
$server_certificate = null;
$server_certificate_key = null;
$server_certificate_passphrase = null;

# Parse arguments
$options = getopt('2c:dh:k:l:p:s');
if (isset($options['2'])) // use protocol version 2
{
	$protocol_version = 2;
}
if (isset($options['c'])) // server certificate path
{
	$server_certificate = $options['c'];
}
if (isset($options['d'])) // detect protocol version
{
	$protocol_version = false;
}
if (isset($options['h'])) // host / bind address
{
	$bind_addr = $options['h'];
}
if (isset($options['k'])) // server private key path
{
	$server_certificate_key = $options['k'];
}
if (isset($options['l'])) // server cert passphrase
{
	$server_certificate_passphrase = $options['l'];
}
if (isset($options['p'])) // bind port
{
	$bind_port = (int)$options['p'];
}
if (isset($options['s']))
{
	$use_ssl = true;
}


@pcntl_signal(SIGCHLD,SIG_IGN); # No zombies, please!


warscore_debug('CREATING STREAM CONTEXT');
$stream_context = stream_context_create();
if ( $use_ssl )
{

	$stream_url = 'ssl://' . $bind_addr . ':' . $bind_port;

	if ( !stream_context_set_option($stream_context, 'ssl', 'local_cert', $server_certificate) )
	{
		warscore_die('cannot set local_cert');
	}
	if ( $server_certificate_key !== null && !stream_context_set_option($stream_context, 'ssl', 'local_pk', $server_certificate_key) )
	{
		warscore_die('cannot set passphrase');
	}
	if ( $server_certificate_passphrase !== null && !stream_context_set_option($stream_context, 'ssl', 'passphrase', $server_certificate_passphrase) )
	{
		warscore_die('cannot set passphrase');
	}
	if ( !stream_context_set_option($stream_context, 'ssl', 'allow_self_signed', true) )
	{
		warscore_die('cannot set allow_self_signed');
	}
	if ( !stream_context_set_option($stream_context, 'ssl', 'verify_peer', false) )
	{
		warscore_die('cannot set verify_peer');
	}

} else { # no ssl

	$stream_url = 'tcp://' . $bind_addr . ':' . $bind_port;

}


warscore_debug("CREATING SOCKET FOR $stream_url");
if (false === ($server_socket = @stream_socket_server($stream_url, $errno, $errstr, STREAM_SERVER_BIND|STREAM_SERVER_LISTEN, $stream_context)))
{
	warscore_die('cannot create socket: '.$errstr);
}



function warscore_debug($message)
{
	#echo '['.date('c').'] ('.getmypid().') '.$message.PHP_EOL;
}

function warscore_die($message)
{
	warscore_debug('DIE: ' . $message);
	die($message . PHP_EOL);
}

function warscore_send($socket, $message)
{
	warscore_debug('SENDING: '.$message);
	@fwrite($socket, $message);
	fclose($socket);
	die(0);
}

function warscore_error($socket, $message)
{
	warscore_send($socket, "ERROR $message\n");
}

function warscore_success($socket, $message)
{
	warscore_send($socket, "SUCCESS $message\n");
}

function warscore_function($socket, $pid)
{
	global $protocol_version;

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
		'security_init' => false,
	));
	gdo_db();
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

	$client_addr = stream_socket_get_name($socket, true);
	warscore_debug("client_addr: $client_addr");
	if ($client_addr === false)
	{
		warscore_error($socket, 'Cannot determine remote address!');
	}
	$client_addr = explode(':', $client_addr);
	$client_ip = $client_addr[0];
	$client_port = $client_addr[1];
	
	warscore_find_warboxes($socket, $client_ip, $boxes);
	
	if (false === ($first_line = fgets($socket)))
	{
		warscore_error($socket, 'No data received!');
	}
	warscore_debug('GOT FIRST LINE: '.trim($first_line));

	if ($first_line === "\n")
	{
		if ($protocol_version === 1)
		{
			warscore_error($socket, 'Empty WeChall username.');
		}
		warscore_v2($socket, $boxes, $client_port);
	} else if ($protocol_version !== false && $protocol_version !== 1)
	{
		warscore_error($socket, 'Protocol error; missing first LF.');
	}

	warscore_debug('PROTOCOL VERSION 1');

	if (false === ($username = Common::substrUntil($first_line, "\n", false)))
	{
		warscore_error($socket, 'No username sent!');
	}
	warscore_debug('GOT USERNAME: '.$username);
	
	if (false === ($token = Common::substrUntil(fgets($socket), "\n", false)))
	{
		warscore_error($socket, 'No token sent!');
	}
	warscore_debug('GOT TOKEN: '.$token);

	warscore_verify_user_and_token($socket, $username, $token, $user);

	warscore_ident_required($socket, $user, $boxes, $client_port);
}

function warscore_v2($socket, $boxes, $client_port)
{
	if (false === ($version = fgets($socket)))
	{
		warscore_error($socket, 'No version received!');
	}

	warscore_debug('GOT VERSION: '.trim($version));
	
	if ($version !== "WARSOLVEv2\n")
	{
		warscore_error($socket, 'Unsupported version received!');
	}
	
	warscore_debug('PROTOCOL VERSION 2');
	
	if (false === ($json = fgets($socket)))
	{
		warscore_error($socket, 'No JSON data received!');
	}
	
	warscore_debug('GOT JSON: '.trim($json));

	if (null === ($data = json_decode($json, true, 2)))
	{
		warscore_error($socket, 'Could not decode JSON data!');
	}

	if (!isset($data['wechall_username']) || !isset($data['wechall_token']))
	{
		warscore_error($socket, 'Required data missing from input!');
	}

	$username = $data['wechall_username'];
	$token = $data['wechall_token'];
	warscore_verify_user_and_token($socket, $username, $token, $user);

	if (!isset($data['warbox_level']))
	{
		warscore_ident_required($socket, $user, $boxes, $client_port);
	}
	# no ident -> check password for level

	if (!isset($data['warbox_password']) && !isset($data['warbox_password_hash']))
	{
		warscore_error($socket, 'Level password (hash) is missing from input!');
	}

	$level = $data['warbox_level'];
	if (isset($data['warbox_password_hash']))
	{
		$password_hash = $data['warbox_password_hash'];
	} else {
		$password_hash = WC_Warflag::hashPassword($data['warbox_password']);
	}

	foreach ($boxes as $box)
	{
		warscore_check_level_password($socket, $box, $user, $level, $password_hash);
	}
	
	warscore_error($socket, 'Unknown level for this Warbox!');
}

function warscore_find_warboxes($socket, $box_ip, &$boxes)
{
	$boxes = WC_Warbox::getByIP($box_ip);
	if (count($boxes) === 0)
	{
		warscore_error($socket, 'Connected from unknown Warbox!');
	}

	warscore_debug("GOT N BOXES: ".count($boxes));
} 
	
function warscore_verify_user_and_token($socket, $username, $token, &$gwf_user)
{
	if (false === ($gwf_user = GWF_User::getByName($username)))
	{
		warscore_error($socket, 'Unknown user!');
	}

	warscore_debug("GOT GWF_USER");
	
	if (!WC_WarToken::isValidWarToken($gwf_user, $token))
	{
		warscore_error($socket, 'Invalid Token!');
	}
	
	warscore_debug("TOKEN IS VALID");

	return true;
}

function warscore_ident_required($socket, $user, $boxes, $client_port)
{
	$seen = array();
	foreach ($boxes as $box)
	{
		$ident_ip = $box->getVar('wb_ip');
		$ident_port = $box->getVar('wb_port');
		$seen_key = $ident_ip.':'.$ident_port;
		if (!isset($seen[$seen_key]))
		{
			$seen[$seen_key] = true;
			warscore_identd($socket, $box, $user, $ident_ip, $ident_port, $client_port);
		}
	}

	warscore_error($socket, 'Bailing out! You should not see me.');
}

function warscore_identd($socket, WC_Warbox $box, GWF_User $user, $identd_ip, $identd_port, $client_port)
{
	warscore_debug("warscore_identd()");

	if (false === ($socket2 = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)))
	{
		warscore_error($socket, 'Could not create socket to your identd.');
		return;
	}
	warscore_debug("socket created");

	warscore_debug("connecting to $identd_ip : $identd_port");
	if (!socket_connect($socket2, $identd_ip, $identd_port))
	{
		socket_close($socket2);
		warscore_error($socket, 'Could not connect to your identd.');
		return;
	}
	warscore_debug("socket connected");

	warscore_debug("Writing to socket: $client_port, 4141\\r\\n");
	if (false !== socket_write($socket2, "$client_port, 4141\r\n"))
	{
		warscore_debug("Wrote to socket. reading now...");
		if (false !== ($in = socket_read($socket2, 2048)))
		{
			warscore_debug("GOT IDENTD RESPONSE: $in");
			if (preg_match("/^ *$client_port *, *4141 *: *USERID *: *UNIX *:(.*)$/", $in, $matches))
			{
				warscore_ident_success($socket, $box, $user, trim($matches[1]));
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

function warscore_ident_success($socket, WC_Warbox $box, GWF_User $user, $level)
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
		if ($box->doesRecycleTokens())
		{
			WC_WarToken::deleteWarToken($user);
		}
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
	if ($result->isError())
	{
		warscore_error($socket, $result->getMessage());
	} else {
		warscore_success($socket, $result->getMessage());
	}
}

function warscore_nochange($socket, WC_Warbox $box, GWF_User $user, $level)
{
	warscore_success($socket, 'You already have solved this challenge. Nothing has changed!');
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
	
	$warchall->recalcSolvers();
	
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

function warscore_check_level_password($socket, $box, $user, $level, $password_hash)
{
	if (!warscore_has_level($box, $level))
	{
		return;
	}

	warscore_debug("FOUND LEVEL $level ON BOX ID ".$box->getID());

	if (false === ($flag = WC_Warflag::getByWarboxAndLevel($box,$level)))
	{
		warscore_error($socket, 'Error while getting flag from database!');
	}

	if ($password_hash !== $flag->getVar('wf_flag_enc'))
	{
		warscore_error($socket, 'Wrong password!');
	}

	warscore_levelup($socket, $box, $user, $level);
	warscore_error($socket, 'Error while setting level as solved!');
}


warscore_debug('ENTERING MAIN LOOP');
while(true)
{
	$client_socket = @stream_socket_accept($server_socket, -1);

	if ($client_socket === false)
	{
		sleep(0.1); # avoid continuous looping
		continue;
	}

	$pid = pcntl_fork();
	
	if ($pid == -1)
	{
		warscore_die('fork failed');
	}
	elseif ($pid) # Parent
	{
		# noop
	}
	else # Child
	{
		warscore_function($client_socket, $pid);
		warscore_die('bad child'); # bad child; shouldn't get here
	}

	if (!$use_ssl) # seems to close ssl stream in child!
	{
		fclose($client_socket);
	}
}
