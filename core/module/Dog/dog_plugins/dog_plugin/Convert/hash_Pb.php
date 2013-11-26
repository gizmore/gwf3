<?php
$lang = array(
	'en' => array(
		'help' => '# Usage: %CMD% [type] [<text to hash>]. Use PHP hash library to hash messages.',
		'algos' => 'Algorithms: %s.',
		'result' => 'Result: %s',
		'info' => 'Length: %d bit (%d bytes).',
	),
);

$plugin = Dog::getPlugin();
if ('' === ($message = $plugin->msg()))
{
	return $plugin->showHelp();
}

$algos = hash_algos();
$algo = Common::substrUntil($message, ' ');
$data = Common::substrFrom($message, ' ');
if ($algo === '' || !in_array($algo, $algos))
{
	$plugin->rply('algos', array(implode(', ', $algos).'.'));
}
elseif ($data !== '')
{
	$plugin->rply('result', array(hash($algo, $data, false)));
}
else
{
	$data = hash($algo, 'abc', false);
	$len = strlen($data)/2;
	$plugin->rply('info', array($len*8, $len));
}
?>
