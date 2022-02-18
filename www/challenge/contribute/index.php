<?php
chdir('../../');
define('GWF_PAGE_TITLE', 'Contribute');
require_once('challenge/html_head.php');
require(GWF_CORE_PATH.'module/WeChall/solutionbox.php');
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 3, 'challenge/contribute/index.php', false);
}
$chall->showHeader();

$user = GWF_User::getStaticOrGuest();
$username = $user->displayUsername();
$args = [$username,
	'https://github.com/gizmore/gdo6',
	'https://github.com/gizmore/gdo6/blob/master/DOCS/GDO_MODULES.md',
	'https://github.com/gizmore/gdo6/tree/master/GDO/Core/GDT.php',
	'https://github.com/gizmore/gdo6/tree/master/GDO/Core/GDO.php',
	'https://github.com/gizmore/gdo6/blob/master/GDO/Core/lang/core_en.php',
	'https://github.com/gizmore/gdo6-bootstrap5-theme/blob/main/css/gdo6-bootstrap5.css',
	'https://tbs.wechall.net',
	'https://github.com/gizmore/gdo6/blob/master/DOCS/GDO_TODO.md',
	'https://github.com/gizmore/gdo6/blob/master/DOCS/GDO_INSTALL_CLI.md',
	'http://localhost:80',
];
echo GWF_Box::box($chall->lang('info', $args), $chall->lang('title'));

$url = 'https://github.com/gizmore/gdo6/blob/master/DOCS/GDO_CONTRIBUTORS.md#list-of-contributors';
echo GWF_Box::box($chall->lang('halloffame', [$url]));

$url = 'https://github.com/gizmore/gdo6/blob/master/DOCS/GDO_MODULES.md#list-of-modules';
echo GWF_Box::box($chall->lang('modules', [$url]));

$url1 = 'https://github.com/gizmore/gwf3';
$url2 = 'https://github.com/gizmore/gwf3/tree/master/core/module/WeChall';
echo GWF_Box::box($chall->lang('alternate', [$url1, $url2]));

echo "\n<!-- https://www.youtube.com/watch?v=DfN_ZMmiLQw -->\n";

echo $chall->copyrightFooter();

require_once('challenge/html_foot.php');
