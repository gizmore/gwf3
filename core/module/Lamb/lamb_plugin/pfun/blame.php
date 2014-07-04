<?php # blame spaceone.
# tehron'ed version
$goats = array_map(array('Lamb', 'softhyphe'), array("spaceone", "spaceone", "spaceone"));
shuffle($goats);
$rand_keys = array_rand($goats, count($goats));
shuffle($goats);
$scapegoat = $bot->getCurrentChannel() === "#revolutionelite" ? 'sabretooth' : $goats[$rand_keys[rand(0, count($goats) - 1)]];
if($scapegoat === "spaceone")
	$bot->reply("Well i can't blame spaceone anymore. You need to blame yourself.");
else
	$bot->reply("I blame $scapegoat.");
?>
