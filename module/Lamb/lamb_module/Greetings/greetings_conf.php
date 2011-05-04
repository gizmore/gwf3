<?php
$greet_mode = LambModule_Greetings::CHANNEL; # Announce the new user in the channel.
$greet_conf = array(
	'irc.giz.org' => array(
		'#sr' => 'Welcome to my localhost, hacker!',
	),
	'idlemonkeys' => array(
		'#sr' => 'Welcome to #sr (Shadowrun). The mmorpg and baim help channel. Please be patient or use baim PM for urgent help requests!',
//		'#wechall' => 'Welcome to #wechall! Enjoy your stay :)',
	),
	'german-elite' => array(
		'#shadowlamb' => 'Welcome to #shadowlamb, the first phpircmmorpg ever. Please try #help or .help to learn how to operate the bot.',
	),
//	'freenode' => array(
//		'#wechall' => 'Welcome to the freenode #wechall channel.',
//	),
);
?>