<?php # Usage: %CMD% <decimal numbers separated by space>. Convert decimal numbers to utf8 text. See also hex2utf.
if ($message === '') {
	$bot->reply('You have to append hexadecimal numbers to this command.');
	return;
}
$dec = preg_split('/ +/', $message);

$out = '';
foreach ($dec as $n)
{
	if (!preg_match('/^[0-9A-F]+$/i', $n)) {
		$bot->reply("$n is an invalid hexadecimal number!");
		return;
	}
	$c = '';
	$n = GWF_Numeric::baseConvert($n, 16, 10);
	while (1)
	{
		$mod = bcmod($n, '256');
		printf('%02X'.PHP_EOL, $mod);
		$c = chr($mod).$c;
		
		$n = bcdiv($n, '256');
		if ($n == 0) {
			break;
		}
	}
	$out .= $c;
}
$bot->reply($out);
//$server->sendPrivmsg($user->getName(), $out);
?>
