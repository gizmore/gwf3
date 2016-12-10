<?php
require 'generator/zen.php';
chdir('../../../');
define('GWF_PAGE_TITLE', 'Zen');
require_once('challenge/html_head.php');
require_once GWF_CORE_PATH.'module/WeChall/solutionbox.php';
require_once GWF_CORE_PATH.'module/WeChall/WC_CryptoChall.php';
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 5, 'challenge/Z/EN/index.php', '');
}
$chall->showHeader();

WC_CryptoChall::checkSolution($chall, 'TheBookCipherIsLikeNothing', true, true);

$chall->onCheckSolution();
$numbers = generate_zen_numbers();
echo GWF_Box::box($chall->lang('info', array($numbers)), $chall->lang('title').' – '.$chall->lang('subtitle'));

echo '<!-- youtube.com/watch?v=gjUYE21-uI0 -->';

formSolutionbox($chall);
echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
