<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD% <decimal numbers separated by space>. Convert decimal numbers to utf8 text.',
	),
);

$plugin = Dog::getPlugin();
if ('' === ($message = $plugin->msg()))
{
	return $plugin->showHelp();
}

$out = '';
$hex = preg_split('/ +/', strtolower($message));
foreach ($hex as $n)
{
	if (!preg_match('/^[0-9a-f]+$/', $n))
	{
		$out .= '?';
		continue;
	}
	
	$c = '';
	$n = GWF_Numeric::baseConvert($n, 16, 10);
	while ($n != 0)
	{
		$mod = bcmod($n, '256');
		printf('%02X'.PHP_EOL, $mod);
		$c = chr($mod).$c;
		$n = bcdiv($n, '256');
	}
	$out .= $c;
}
Dog::reply($out);
?>
