<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD% [<cocktail>] [<nickname>]. Virtually get someone a cock or list them.',
		'cock' => 'hands %s a nice %s.',
		'list' => 'Available cocktails: %s.',
	),
);
$cocktails = array(
	'Woo Woo',
	'Piña Colada',
	'Blue Lagoon',
	'Sex on the Beach',
	'Caipirinha',
);
$plugin = Dog::getPlugin();
$argv = $plugin->argv();
$argc = count($argv);
$showlist = false;
if ($argc === 0)
{
	$showlist = true;
}
elseif ($argc <= 2)
{
	if (Common::isNumeric($argv[0]))
	{
		$target = isset($argv[1]) ? $argv[1] : Dog::getUser()->getName();
		$coknum = ((int)$argv[0] - 1);
		if (isset($cocktails[$coknum]))
		{
			$plugin->rplyAction('cock', array($target, $cocktails[$coknum]));
		}
		else
		{
			$showlist = true;
		}
	}
	else
	{
		$plugin->showHelp();
	}
}
else
{
	$plugin->showHelp();
}

if ($showlist)
{
	$i = 1;
	$out = '';
	foreach ($cocktails as $cock)
	{
		$out .= ', ' . ($i++) . '-' . $cock;
	}
	$plugin->rply('list', array(substr($out, 2)));
}
