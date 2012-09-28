<?php # Usage: %CMD% <hash|len>. Show all known hash types to the PHP hash library that have the same length as the input hash. Example: %CMD% abcdefabcdef123123123.
if ($message === '')
{
	return $bot->getHelp('hashlens');
}
if (is_numeric($message))
{
	$wlen = (int) $message;
}
else
{
	$wlen = strlen(trim($message));
}

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
	return $bot->reply('There is no algo that matches.');
}

$bot->reply(sprintf('%d matches for length %d: %s.', $matches, $wlen, substr($out, 2)));
?>