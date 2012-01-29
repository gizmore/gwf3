<?php
require_once 'lamb_pass.php';

define('LAMB_DEV', false);

global $LAMB_CONFIG;
$LAMB_CFG = array
(
	# Version
	'version' => '3.01.2011.JUN.06(trunk) - GWF '.GWF_CORE_VERSION,

	# IRC
	'username' => 'Lamb3',
	'realname' => 'Lamb: IRC Botten',
	'hostname' => 'lamb3.gizmore.org',

	# Modules
	'modules' => 'Shadowlamb;Link;Quote;Scum;Slapwarz;Notes;Greetings',#;News;IRCLink;Warfare;PG',

	# Various
	'owner' => 'gizmore',
	'logging' => true, # Default flag for logging.
	'trigger' => '.',
	'event_plugins' => false,
	'sleep_millis' => 50,
	'ping_timeout' => 600,
	'connect_timeout' => 5,
	'send_command_issuer_nickname_on_reply' => true, # thx space

	###############
	### Servers ###
	###############
	'servers' => array
	(
	/*
		array(
			'host' => 'irc.giz.org:31346',
			'nickname' => 'Lamb3',
			'password' => 'lamblamb',
			'channels' => '#sr',
			'admins' => 'gizmore',
		),
	*/
		array(
			'host' => 'ircs://irc.freenode.net:7000',
			'nickname' => 'Lamb3',
			'password' => LAMB_PASSWORD,
			'channels' => '#wechall,#shadowlamb,#hacker.org,#happy-security',
			'admins' => 'gizmore',
		),
		
//		array(
//			'host' => 'ircs://irc.2600.net:6697',
//			'nickname' => 'Lamb3',
//			'password' => 'lamblamb',
////			'channels' => '#shadowlamb,#hackbbs',
//			'channels' => '#shadowlamb,#hackbbs,#hackbbs-en',
//			'admins' => 'gizmore',
//		),
		
		array(
			'host' => 'ircs://irc.idlemonkeys.net:7000',
			'nickname' => 'Lamb3',
			'password' => LAMB_PASSWORD,
			'channels' => '#wechall,#net-force,#sr,#securitytraps,#3564020356,#revolutionelite,#pyramid,#tbs,#lost-chall',
			'admins' => 'gizmore',
		),
		
		array(
			'host' => 'ircs://DOminiOn.german-elite.net:6670',
			'nickname' => 'Lamb3',
			'password' => 'lamblamb',
			'channels' => '#shadowlamb,#127.0.0.1,#linux,#mo,#Mathematik,#ru',
			'admins' => 'gizmore',
		),
		
		array(
			'host' => 'ircs://natalya.psych0tik.net:6697',
			'nickname' => 'Lamb',
			'password' => LAMB_PASSWORD2,
			'channels' => '#shadowlamb,#hbh,#shadowlamb_bots,#valhalla',
			'admins' => 'gizmore',
		),
		
		array(
			'host' => 'ircs://epic.irc.hackthissite.org:7000',
			'nickname' => 'Lamb3',
			'password' => 'lamblamb',
			'channels' => '#shadowlamb,#hackthissite',
			'admins' => 'gizmore',
		),
		
//		array(
//			'host' => 'ircs://irc.hackerzvoice.net:6697',
//			'nickname' => 'Lamb3',
//			'password' => 'lamblamb',
//			'channels' => '#shadowlamb',
//			'admins' => 'gizmore',
//		),

//		array(
//			'host' => 'ircs://irc.big-daddy.fr:6697',
//			'nickname' => 'Lamb3',
//			'password' => 'lamblamb',
//			'channels' => '#shadowlamb,#Big-Daddy',
//			'admins' => 'gizmore',
//		),
		
		array(
			'host' => 'ircs://irc.gizmore.org:6666',
			'nickname' => 'Lamb3',
			'password' => 'lamblamb',
			'channels' => '#wechall,#shadowlamb,#sr,#revolutionelite',
			'admins' => 'gizmore',
		),
		
//		array(
//			'host' => 'ircs://irc2.hackbbs.org:9999',
//			'nickname' => 'Lamb3',
//			'password' => 'lamblamb',
//			'channels' => '#shadowlamb,#hackbbs,#hackbbs-en',
//			'admins' => 'gizmore',
//		),
		
		array(
			'host' => 'ircs://irc.hackint.eu:9999',
			'nickname' => 'Lamb3',
			'password' => 'lamblamb',
			'channels' => '#shadowlamb,#hackbbs,#hackbbs-en',
			'admins' => 'gizmore',
		),
		
//		array(
//			'host' => 'ircs://irc3.srn.ano:6697',
//			'nickname' => 'Lamb3',
//			'password' => 'lamblamb',
//			'channels' => '#shadowlamb',
//			'admins' => '/NNN/gizmore',
//		),
		
//		array(
//			'host' => 'irc://irc2.sevilnatas.ano:6667',
//			'nickname' => 'Lamb3',
//			'password' => 'lamblamb',
//			'channels' => '#shadowlamb',
//			'admins' => '/sI2/gizmore',
//		),
		
		array(
			'host' => 'irc://irc.a2.ano:6667',
			'nickname' => 'Lamb3',
			'password' => 'lamblamb',
			'channels' => '#shadowlamb',
//			'admins' => '/NNN/gizmore',
			'admins' => '/A2/gizmore',
		),
		
//		array(
//			'host' => 'irc://irc.muffinnet.ano:6667',
//			'nickname' => 'Lamb3',
//			'password' => 'lamblamb',
//			'channels' => '#shadowlamb',
//			'admins' => '!!',
//		),
		
		array(
			'host' => 'irc://xs4all.nl.quakenet.org:6667',
			'nickname' => 'Lamb3',
			'password' => 'lamblamb',
			'channels' => '#shadowlamb',
			'admins' => 'gizmore',
		),
		
		array(
			'host' => 'ircs://irc.enigmagroup.org:6697',
			'nickname' => 'Lamb3',
			'password' => 'lamblamb',
			'channels' => '#wechall,#shadowlamb',
			'admins' => 'gizmore',
		),
		
		array(
			'host' => 'ircs://lanthanum.vutral.net:6667',
			'nickname' => 'Lamb3',
			'password' => 'lamblamb',
			'channels' => '#shadowlamb',
			'admins' => 'gizmore',
		),
		
		array(
			'host' => 'ircs://irc.w3challs.com:6697',
			'nickname' => 'Lamb3',
			'password' => 'lamblamb',
			'channels' => '#wechall,#shadowlamb,#w3challs',
			'admins' => 'gizmore',
		),

		array(
			'host' => 'ircs://shell.tor.hu:7000',
			'nickname' => 'Lamb3',
			'password' => 'lamblamb',
			'channels' => '#shadowlamb,#haxtor',
			'admins' => 'gizmore',
		),
		
//		array(
//			'host' => '',
//			'nickname' => 'Lamb3',
//			'password' => 'lamblamb',
//			'channels' => '',
//			'admins' => 'gizmore',
//		),
		
	),
);
?>