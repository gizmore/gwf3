<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD% <integer>. Usage: %CMD% <integer>. Predict the next sequential integer polled from GWF_Random::rand(). Predict 20 in a row and i send you $100.',
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
$rand = GWF_Random::rand();

if ($rand === $predicted)
{
	$plugin->rply('good');
}
else
{
	$plugin->rply('wrong', array($predicted, $rand));
}
?>
