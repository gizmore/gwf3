<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD%. Drink some vodka with %BOT%!',
		'young' => 'You are too young for vodka, have no age specified, or your brain would suffer too much!',
		'FreeArtMan' => 'Ah ... at least. I am not kid!',
		'paipai'     => 'Chin Chin!',
		'poulse'     => 'Cheers and congrats!',
		'Oz'         => 'Nastrovje!',
		'sabretooth' => 'One vodka, Mr. Bond. Shaken, not stirred.',
		'dalfor'     => 'vodka? what am I russian?',
		'MkZ^'       => 'You can pop more vodka than i thought!',
	),
);
$plugin = Dog::getPlugin();

$uname = Dog::getUser()->getName();

if ($plugin->hasKey($uname))
{
	$plugin->rply($uname);
}
else
{
	$plugin->rply('young');
}
?>
