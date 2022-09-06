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
	'https://github.com/gizmore/phpgdo',
	'https://github.com/gizmore/phpgdo/blob/main/DOCS/GDO7_MODULES.md',
	'https://github.com/gizmore/phpgdo/tree/main/GDO',
	'https://github.com/gizmore/phpgdo/blob/main/DOCS/GDO7_INSTALLATION.md',
	'http://localhost:80',
];
echo GWF_Box::box($chall->lang('info', $args), $chall->lang('title'));

$url = 'https://github.com/gizmore/phpgdo/blob/main/DOCS/GDO7_THX.md';
echo GWF_Box::box($chall->lang('halloffame', [$url]));

$url = 'https://github.com/gizmore/phpgdo/blob/main/DOCS/GDO7_MODULES.md';
echo GWF_Box::box($chall->lang('modules', [$url]));

$url1 = 'https://github.com/gizmore/gwf3';
$url2 = 'https://github.com/gizmore/gwf3/tree/master/core/module/WeChall';
echo GWF_Box::box($chall->lang('alternate', [$url1, $url2]));

echo "\n<!-- https://www.youtube.com/watch?v=DfN_ZMmiLQw -->\n";

echo $chall->copyrightFooter();

require_once('challenge/html_foot.php');
