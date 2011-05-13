<?php
global $LAMB_CONFIG;
$LAMB_CFG = array
(
	# Version
	'version' => '3.01.2011.MAY.08(DEV) - GWF '.GWF_CORE_VERSION,

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
	'connect_timeout' => 10,
	'sleep_millis' => 50,
	'timer_interval' => 30.0,
	'send_command_issuer_nickname_on_reply' => true, # thx space

	###############
	### Servers ###
	###############
	'servers' => array
	(
		array(
			'host' => 'irc.giz.org:31346',
			'nickname' => 'Lamb3',
			'password' => 'lamblamb',
			'channels' => '#sr',
			'admins' => 'gizmore',
		),
	),
);
?>