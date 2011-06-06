<?php # Usage: %CMD% <hex numbers separated by space>. Convert hex into dec. See also dec2hex.

if ($message === '') {
	$bot->reply('You have to append hexadecimal numbers to this command.');
	return;
}
$hex = preg_split('/ +/', $message);

$out = '';
foreach ($hex as $h)
{
	if (!preg_match('/^[0-9A-F]+$/i', $h)) {
		$bot->reply("$h is an invalid hex number!");
		return;
	}
	$h = strtolower($h);
	$out .= ' '.GWF_Numeric::baseConvert($h, 16, 10);
}
$bot->reply(substr($out, 1));

?>