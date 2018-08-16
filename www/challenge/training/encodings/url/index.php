<?php
chdir('../../../../');
define('GWF_PAGE_TITLE', 'Encodings: URL');
require_once('challenge/html_head.php');
require_once GWF_CORE_PATH.'module/WeChall/solutionbox.php';
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE))) {
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 1, 'challenge/training/encodings/url/index.php', false);
}
$chall->showHeader();
require_once GWF_CORE_PATH.'module/WeChall/WC_CryptoChall.php';
$solution = WC_CryptoChall::generateSolution(require_once 'challenge/training/encodings/url/secret.php', true, true);
$url = "challenge/training/encodings/url/saw_lotion.php?p=$solution&cid=52#password=fibre_optics";
$msg = $chall->lang('message', array($url));
$message = '';
$len = strlen($msg);
for ($i = 0; $i < $len; $i++)
{
	$message .= sprintf('%%%02X', ord($msg{$i}));
}
echo GWF_Box::box($chall->lang('info', array($message)), $chall->lang('title'));
formSolutionbox($chall);
echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
?>
