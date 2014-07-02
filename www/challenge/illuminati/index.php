<?php
chdir('../../');
define('GWF_PAGE_TITLE', 'Illuminati');
define('NO_HEADER_PLEASE', true);
require_once('challenge/html_head.php');
GWF_Website::addCSS('some.css');
echo $gwf->onDisplayHead();
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 3, 'challenge/illuminati/index.php');
}
$chall->showHeader();

$chall->onCheckSolution();

echo GWF_Box::box($chall->lang('info'), $chall->lang('title'));

echo '<div class="chall">';
echo GWF_Box::box($chall->lang('challenge'), $chall->lang('ct'));
echo '</div>';

require(GWF_CORE_PATH.'module/WeChall/solutionbox.php');
formSolutionbox($chall);

echo $chall->copyrightFooter();

require_once('challenge/html_foot.php');
