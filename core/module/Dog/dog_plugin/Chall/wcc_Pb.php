<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD% [<username>]. Query wechall for progress on wechall.',
	),
);
$plugin = Dog::getPlugin();

switch ($plugin->argc())
{
	case 0:
		$username = Dog::getUser()->getName();
		break;
	case 1:
		$username = $plugin->argv(0);
		break;
	default:
		return $plugin->showHelp();
}

$url = 'http://www.wechall.net/wechallchalls.php?username='.urlencode($username);
if (false === ($result = GWF_HTTP::getFromURL($url, false)))
{
	return Dog::rply('err_response');
}
Dog::reply($result);
?>
