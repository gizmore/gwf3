<?php
chdir('../../../../');
define('GWF_PAGE_TITLE', 'Stegano Attachment');
require_once('challenge/html_head.php');
require_once GWF_CORE_PATH.'module/WeChall/WC_CryptoChall.php';
require_once GWF_CORE_PATH.'module/WeChall/solutionbox.php';
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE))) {
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 2, '/challenge/training/stegano/attachment/index.php', false);
}
$chall->showHeader();
WC_CryptoChall::checkSolution($chall, 'YouLikeAttachmentEh', true, false);
echo GWF_Box::box($chall->lang('info', array('attachment.php')), $chall->lang('title'));
formSolutionbox($chall);
echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
?>