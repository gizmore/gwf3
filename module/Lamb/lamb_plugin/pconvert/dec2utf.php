<?php # Usage: %CMD% <decimal numbers separated by space>. Convert decimal numbers to utf8 text. See also hex2utf.
if ($message === '') {
	$bot->reply('You have to append decimal numbers to this command.');
	return;
}
$dec = preg_split('/ +/', $message);

$out = '';
foreach ($dec as $n)
{
	if (!preg_match('/^[0-9]+$/', $n)) {
		$bot->reply("$n is an invalid decimal number!");
		return;
	}
	
	$c = '';
	while (1)
	{
		$mod = bcmod($n, '256');
		$c = chr($mod).$c;
		$n = bcdiv($n, '256');
		if ($n == 0) {
			break;
		}
	}
	$out .= ($c);
}
$bot->reply($out, 1);

?>
