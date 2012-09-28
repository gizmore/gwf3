<?php # Usage: %CMD% [type] [<text to hash>]. Use PHP hash library to hash messages.
$algos = hash_algos();
$algo = Common::substrUntil($message, ' ');
$data = Common::substrFrom($message, ' ');
if ($algo === '' || !in_array($algo, $algos))
{
	$bot->reply('Algos: '.implode(', ', $algos).'.');
}
elseif ($data !== '')
{
	$bot->reply('Result: '.hash($algo, $data, false).'.');
}
else
{
	$data = hash($algo, 'abc', false);
	$len = strlen($data)/2;
	$bot->reply(sprintf('Length: %d bit (%d bytes).', $len*8, $len));
}
?>