<?php # 
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD% <decimal numbers separated by space>. Convert decimal numbers to utf8 text. See also hex2utf.',
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
		$out .= '?';
		continue;
	}
	
	$c = '';
	while ($n > 0)
	{
		$mod = bcmod($n, '256');
		$c = chr($mod).$c;
		$n = bcdiv($n, '256');
	}
	$out .= ($c);
}

$plugin->reply($out);
?>
