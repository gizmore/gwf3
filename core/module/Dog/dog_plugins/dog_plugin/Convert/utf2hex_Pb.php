<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD% <text>. Convert utf8 text into hexadecimal numbers.',
		'err_mbl' => 'Missing function: mb_strlen!',
	),
);

$plugin = Dog::getPlugin();
if ('' === ($message = $plugin->msg()))
{
	return $plugin->showHelp();
}
if (!function_exists('mb_strlen'))
{
	return $plugin->rply('err_mbl');
}

$out = '';
$len = mb_strlen($message, 'UTF8');
for ($i = 0; $i < $len; $i++)
{
	$utf = mb_substr($message, $i, 1, 'UTF8');
	$len2 = strlen($utf);
	$dec = '0';
	for ($j = 0; $j < $len2; $j++)
	{
		$dec = bcmul($dec, '256');
		$dec = bcadd($dec, ord($utf[$j]));
	}
	
	$out .= ' '.GWF_Numeric::baseConvert($dec, 10, 16);
}

Dog::reply(substr($out, 1));
?>
