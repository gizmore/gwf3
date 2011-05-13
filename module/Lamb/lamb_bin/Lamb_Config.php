<?php
global $LAMB_CONFIG;
$LAMB_CFG = array
(
	# Version
	'version' => '3.01.2011.MAY.11(Trunk) - GWF '.GWF_CORE_VERSION,

	# IRC
	'hostname' => 'lamb3.gizmore.org',
	'realname' => 'Lamb: IRC-Botten',
	'username' => 'Lamb3',

	# Modules
	'modules' => 'Shadowlamb;Link;News;Quote;Scum;Slapwarz;Notes;IRCLink;Warfare2;Greetings;PG',

	# Various
	'trigger' => '.',
	'owner' => 'gizmore',
	'blocking_io' => false,
	'ping_timeout' => 420,
	'connect_timeout' => 12,
	'sleep_millis' => 40,
	'timer_interval' => 40.0,
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
			'password' => 'lamblamb',
			'channels' => '#wechall,#shadowlamb,#hacker.org,#happy-security',
			'admins' => 'gizmore',
		),
		
		array(
			'host' => 'ircs://irc.2600.net:6697',
			'nickname' => 'Lamb3',
			'password' => 'lamblamb',
//			'channels' => '#shadowlamb,#hackbbs',
			'channels' => '#shadowlamb',
			'admins' => 'gizmore',
		),
		
		array(
			'host' => 'ircs://irc.idlemonkeys.net:7000',
			'nickname' => 'Lamb3',
			'password' => 'lamblamb',
			'channels' => '#wechall,#net-force,#sr,#securitytraps,#idlemonkeys,#3564020356',
			'admins' => 'gizmore',
		),
		
		array(
			'host' => 'ircs://DOminiOn.german-elite.net:6670',
			'nickname' => 'Lamb3',
			'password' => 'lamblamb',
			'channels' => '#shadowlamb,#coding,#127.0.0.1,#linux,#radio-tekula',
			'admins' => 'gizmore',
		),
		
		array(
			'host' => 'ircs://natalya.psych0tik.net:6697',
			'nickname' => 'Richard',
			'password' => 'lamblamb',
			'channels' => '#shadowlamb,#hbh',
			'admins' => 'gizmore',
		),
		
		array(
			'host' => 'ircs://epic.irc.hackthissite.org:7000',
			'nickname' => 'Lamb3',
			'password' => 'lamblamb',
			'channels' => '#shadowlamb,#hackthissite',
			'admins' => 'gizmore',
		),
		
		array(
			'host' => 'ircs://irc.hackerzvoice.net:6697',
			'nickname' => 'Lamb3',
			'password' => 'lamblamb',
			'channels' => '#shadowlamb',
			'admins' => 'gizmore',
		),
		array(
		
			'host' => 'ircs://irc.big-daddy.fr:6697',
			'nickname' => 'Lamb3',
			'password' => 'lamblamb',
			'channels' => '#shadowlamb,#Big-Daddy',
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