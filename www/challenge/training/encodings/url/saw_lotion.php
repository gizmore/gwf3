<?php
chdir('../../../../');
define('GWF_PAGE_TITLE', 'Encodings: URL');
require_once('challenge/html_head.php');
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE))) {
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 1, 'challenge/training/encodings/url/index.php', false);
}
$chall->showHeader();
require_once GWF_CORE_PATH.'module/WeChall/WC_CryptoChall.php';
$solution = WC_CryptoChall::generateSolution('OHNOU_R_Ls', true, true);
if (Common::getGetString('p', '') === $solution) {
	$chall->onChallengeSolved(GWF_Session::getUserID());
}
echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
?>
