<?php
define('LAMB_DEV', false);

global $LAMB_CONFIG;
$LAMB_CFG = array
(
	# Version
	'version' => '3.01.2011.JUN.06(trunk) - GWF '.GWF_CORE_VERSION,

	# IRC
	'username' => 'Lamb',
	'realname' => 'Lamb: IRC Botten',
	'hostname' => 'lamb.gizmore.org',

	# Modules
	'modules' => 'Shadowlamb;Link;News;Quote;Scum;Slapwarz;Notes;IRCLink;Warfare2',

	# Various
	'owner' => 'gizmore',
	'trigger' => '.',
	'logging' => true, # Default flag for logging.
	'sleep_millis' => 50,
	'event_plugins' => true,
	'ping_timeout' => 360,
	'connect_timeout' => 3,
	'send_command_issuer_nickname_on_reply' => true, # Thx space

	###############
	### Servers ###
	###############
	'servers' => array
	(
		array(
			'host' => 'localhost:6667',
			'nickname' => 'Lamb3',
			'password' => '',
			'channels' => '#lamb',
			'admins' => 'root',
		),
	),
);
?>