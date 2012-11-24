<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD% <integer>. Predict the next sequential integer polled from rand(). $100 won by noother!',
		'good' => 'Well done!',
		'wrong' => 'You predicted %s but the outcome was %s.',
	),
);
$plugin = Dog::getPlugin();
$argv = $plugin->argv();
if ( (count($argv) !== 1) || (!Common::isNumeric($argv[0])) )
{
	return $plugin->showHelp();
}

$predicted = (int)$argv[0];
$rand = rand(0, getrandmax());

if ($rand === $predicted)
{
	$plugin->rply('good');
}
else
{
	$plugin->rply('wrong', array($predicted, $rand));
}
?>
