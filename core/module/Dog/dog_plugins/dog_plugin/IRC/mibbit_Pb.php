<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD% [[<server>:]<channel>] [<nickname>]',
	),
);
return;
$plug = Dog::getPlugin();
$user = Dog::getUser();
$serv = Dog::getServer();
$chan = Dog::getChannel();
$argv = $plug->argv();
$argc = count($argv);
$showhelp = false;

if ($argc === 2)
{
	$nickname = array_pop($argv);
	if (!Dog_IRCRFC::isValidNickname($nickname))
	{
		return Dog::rply('err_nickname');
	}
	$argc--;
}

if ($argc === 1)
{
	
	$servchan = $argv[0];
	
}
else
{
	$showhelp = true;
}

if ($showhelp)
{
	return $plug->showHelp();
}

$url = "https://widget00.mibbit.com/?server={$server}%3A%2B6666&channel={$channel}&noServerNotices=true&noServerMotd=true&nick={$nickname}&forcePrompt=true";
