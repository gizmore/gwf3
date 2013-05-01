<?php # Usage: %CMD% <hex numbers separated by space>. Convert hex into dec. See also dec2hex.

if ($message === '')
{
	$bot->reply('You have to append hexadecimal numbers to this command.');
	return;
}
$hex = preg_split('/ +/', strtolower($message));

$out = '';
foreach ($hex as $h)
{
	if (!preg_match('/^[0-9a-f]+$/', $h))
	{
		$bot->reply("$h is an invalid hex number!");
		return;
	}
	$out .= ' '.GWF_Numeric::baseConvert($h, 16, 10);
}
$bot->reply(substr($out, 1));
?>
