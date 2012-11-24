<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD% <decimal numbers separated by space>. Convert dec into hex. See also hex2dec.',
	),
);

$plugin = Dog::getPlugin();
if ('' === ($message = $plugin->msg()))
{
	return $plugin->showHelp();
}

$out = '';
$dec = preg_split('/ +/', $message);
foreach ($dec as $n)
{
	if (!preg_match('/^[0-9]+$/', $n))
	{
		$out .= ' ??';
	}
	else
	{
		$out .= ' '.GWF_Numeric::baseConvert($n, 10, 16);
	}
}

Dog::reply(substr($out, 1));
?>
