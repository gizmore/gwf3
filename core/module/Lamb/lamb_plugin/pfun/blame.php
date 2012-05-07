<?php # blame spaceone.

# Show who is to blame for the last mistake or flaw.
#$blamed = array(
#	'spaceone',
#	'gizmore',
#);
#$blame = $blamed[array_rand($blamed)];
#$bot = Lamb::instance();
#$bot->reply("I blame {$blame}.");

# tehron'ed version
$goats = array_map(array('Lamb', 'softhyphe'), array("spaceone", "spaceone", "spaceone"));
shuffle($goats);
$rand_keys = array_rand($goats, count($goats));
shuffle($goats);
$scapegoat = $goats[$rand_keys[rand(0, count($goats) - 1)]];
$bot->reply("I blame $scapegoat.");
?>
