<?php
chdir('../../../../');
define('GWF_PAGE_TITLE', 'Training: ASCII');
require_once('challenge/html_head.php');
require_once GWF_CORE_PATH.'module/WeChall/solutionbox.php';
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE))) {
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 1, 'challenge/training/encodings/ascii/index.php', false);
}
$chall->showHeader();

$SOLUTION = require_once 'challenge/training/encodings/ascii/secret.php';
require_once GWF_CORE_PATH.'module/WeChall/WC_CryptoChall.php';
WC_CryptoChall::checkSolution($chall, $SOLUTION, true, true);

$solution = WC_CryptoChall::generateSolution($SOLUTION, true, true);
$msg = $chall->lang('message', array($solution));

$message = '';
$len = strlen($msg);
for ($i = 0; $i < $len; $i++)
{
	$message .= ', '.ord($msg{$i});
}
$message = substr($message, 2);

echo GWF_Box::box($chall->lang('info', array($message)), $chall->lang('title'));

formSolutionbox($chall);
echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
?>
