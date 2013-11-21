<?php
$lang = array(
	'en' => array(
		'help' => 'Query wechall for user or site info. Usage: %CMD% [<username|rank>] || %CMD% !site <sitename> || %CMD% !sites [<username>] || %CMD% !<sitename> [<username|rank>].',
	),
);
$plugin = Dog::getPlugin();
$argv = $plugin->argv();
$argc = count($argv);

switch ($argc)
{
	case 0:
		$argv[0] = Dog::getUser()->getName();
		break;
	case 1:
		if ($argv[0][0] === '!')
		{
			$argv[1] = Dog::getUser()->getName();
		}
		break;
	case 2:
		break;
	default:
		return $plugin->showHelp();
}

$url = 'http://www.wechall.net/wechall.php?username='.urlencode(implode(' ', $argv));

if (false === ($result = GWF_HTTP::getFromURL($url, false)))
{
	return Dog::rply('err_repsonse');
}

Dog::reply($result);
?>
