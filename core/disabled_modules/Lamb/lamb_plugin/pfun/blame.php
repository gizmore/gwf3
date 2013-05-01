<?php # blame spaceone.
# tehron'ed version
$goats = array_map(array('Lamb', 'softhyphe'), array("spaceone", "spaceone", "spaceone"));
shuffle($goats);
$rand_keys = array_rand($goats, count($goats));
shuffle($goats);
$scapegoat = $bot->getCurrentChannel() === "#revolutionelite" ? 'sabretooth' : $goats[$rand_keys[rand(0, count($goats) - 1)]];
$bot->reply("I blame $scapegoat.");
?>
