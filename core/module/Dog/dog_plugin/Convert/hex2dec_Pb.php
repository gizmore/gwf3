<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD% <hex numbers separated by space>. Convert hex into dec. See also dec2hex.',
	),
);

$plugin = Dog::getPlugin();
if ('' === ($message = $plugin->msg()))
{
	return $plugin->showHelp();
}


$out = '';
$hex = preg_split('/ +/', strtolower($message));
foreach ($hex as $h)
{
	if (!preg_match('/^[0-9a-f]+$/', $h))
	{
		$out .= ' ??';
	}
	else
	{
		$out .= ' '.GWF_Numeric::baseConvert($h, 16, 10);
	}
}
Dog::reply(substr($out, 1));
?>
