<?php # Usage: %CMD% <text>. Convert ascii text into decimal numbers. See also utf2dec.
$len = strlen($message);
if ($len === 0) {
	$bot->reply('Please append a message to this command.');
	return;
}
$out = '';
for ($i = 0; $i < $len; $i++)
{
	$out .= sprintf(' %d', ord($message[$i]));
}
$bot->reply(substr($out, 1));
?>
