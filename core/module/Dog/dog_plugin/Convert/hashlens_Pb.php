<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD% <hash|len>. Show all known hash types to the PHP hash library that have the same length as the input hash. Example: %CMD% abcdefabcdef123123123.',
		'none' => 'There is no hashing algorithm that matches your input length.',
		'result' => '%d matches for length %d: %s.',
	),
);

$plugin = Dog::getPlugin();
if ( ('' === ($message = $plugin->msg())) || ($plugin->argc() !== 1) )
{
	return $plugin->showHelp();
}

$wlen = is_numeric($message) ? (int)$message : strlen(trim($message));
$algos = hash_algos();
$matches = 0;
foreach ($algos as $algo)
{
	$data = hash($algo, 'abc', false);
	$len = strlen($data);
	if ($len === $wlen)
	{
		$matches++;
		$out .= ', '.$algo;
	}
}

if ($matches === 0)
{
	$plugin->rply('none');
}
else
{
	$plugin->rply('result', array($matches, $wlen, substr($out, 2)));
}
?>
