<?php # Usage: %TRIGGER%dec2hex <decimal numbers separated by space>. Convert dec into hex. See also hex2dec.

if ($message === '') {
	$bot->reply('You have to append hexadecimal numbers to this command.');
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
	$out .= ' '.GWF_Numeric::baseConvert($n, 10, 16);
}
$bot->reply(substr($out, 1));

?>