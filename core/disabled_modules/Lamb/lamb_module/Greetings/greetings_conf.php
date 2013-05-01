<?php
$greet_mode = LambModule_Greetings::CHANNEL; # Announce the new user in the channel.
$greet_conf = array(
	'irc.giz.org' => array(
		'#sr' => 'Welcome to my localhost, hacker!',
	),
	'idlemonkeys' => array(
		'#sr' => 'Welcome to #sr, the irc mmorpg. Type #start to start your journey. Type #help get_started for your next steps. If you are here for baim send a PM or be patient!',
//		'#wechall' => 'Welcome to #wechall! Enjoy your stay :)',
	),
	'german-elite' => array(
		'#shadowlamb' => 'Welcome to #shadowlamb, the first phpircmmorpg ever. Please try #help or .help to learn how to operate the bot.',
	),
	'freenode' => array(
//		'#shadowlamb' => 'Welcome to #shadowlamb, fellow runner. Type #start to begin your journey.',
	),
);
?>