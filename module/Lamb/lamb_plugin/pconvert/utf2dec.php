<?php # Usage: %TRIGGER%utf2dec <text>. Convert utf8 text into decimal numbers.
if (!function_exists('mb_strlen')) {
	$bot->reply('Missing function: mb_strlen!');
	return;
}
$len = mb_strlen($message, 'UTF8');
if ($len === 0) {
	$bot->reply('Please append a message to this command.');
	return;
}
$out = '';
for ($i = 0; $i < $len; $i++)
{
	$utf = mb_substr($message, $i, 1, 'UTF8');
	$len2 = strlen($utf);
	$dec = '0';
	for ($j = 0; $j < $len2; $j++)
	{
		$dec = bcmul($dec, '256');
		$dec = bcadd($dec, ord($utf[$j]));
	}
	$out .= ' '.$dec;
}
$bot->reply(substr($out, 1));

?>
