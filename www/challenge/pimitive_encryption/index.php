<?php
chdir('../../');
define('GWF_PAGE_TITLE', 'Pimitive Encryption');
require_once('challenge/html_head.php');
require_once GWF_CORE_PATH.'module/WeChall/solutionbox.php';
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE))) {
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 4, 'challenge/pimitive_encryption/index.php');
}
$chall->showHeader();

$href_zip = 'pimitive.zip';

if (false === ($jander = GWF_User::getByName('Jander'))) {
	$jander = '<b>Jander</b>';
} else {
	$jander = $jander->displayProfileLink();
}

$chall->onCheckSolution();

echo GWF_Box::box($chall->lang('info', array($jander, $href_zip)), $chall->lang('title'));

echo formSolutionbox($chall);

# Your footer
echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
?>
