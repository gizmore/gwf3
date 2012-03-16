<?php
define('LAMB_DEV', true);
require_once 'lamb_pass.php';

global $LAMB_CONFIG;
$LAMB_CFG = array
(
	# Version
	'version' => '3.01.2011.MAY.08(DEV) - GWF '.GWF_CORE_VERSION,

	# IRC
	'hostname' => 'lamb3.gizmore.org',
	'realname' => 'Lamb: IRC-Botten',
	'username' => 'Lambee',

	# Modules
	'modules' => 'Shadowlamb;Link;News;Quote;Scum;Slapwarz;Notes;IRCLink;Warfare;Greetings;PG',

	# Various
	'owner' => 'gizmore',
	'logging' => true, # Default flag for logging.
	'trigger' => '.',
	'sleep_millis' => 50,
	'event_plugins' => true,
	'ping_timeout' => 600,
	'connect_timeout' => 1,
	'send_command_issuer_nickname_on_reply' => true, # thx space

	###############
	### Servers ###
	###############
	'servers' => array
	(
		array(
			'host' => 'irc.giz.org:6668',
			'nickname' => 'Lamb3',
			'password' => 'lamblamb',
			'channels' => '#sr,#wechall',
			'admins' => 'gizmore',
		),
// 		array(
// 			'host' => 'bouncing.efnet.org:4096',
// 			'nickname' => 'Lambee',
// 			'password' => LAMB_PASSWORD3,
// 			'channels' => '#shadowlamb',
// 			'admins' => 'gizmore',
// 			'options' => Lamb_Server::BNC_MODE,
// 		),
//		array(
//			'host' => 'irc.gizmore.org:6668',
//			'nickname' => 'Lamb3',
//			'password' => 'lamblamb',
//			'channels' => '#shadowlamb',
//			'admins' => 'gizmore',
//		),
	),
);
?>