<?php
chdir('../../../../');
require_once GWF_CORE_PATH.'module/WeChall/WC_CryptoChall.php';
define('GWF_PAGE_TITLE', 'WhitespaceTraining: LSB');
require_once('challenge/html_head.php');
require_once GWF_CORE_PATH.'module/WeChall/solutionbox.php';
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE))) {
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 2, '/challenge/training/stegano/LSB/index.php', false);
}
$chall->showHeader();

if (isset($_POST['answer']) && is_string($_POST['answer'])) {
	$_POST['answer'] = strtoupper($_POST['answer']);
}
WC_CryptoChall::checkSolution($chall, 'YouAreNotLeanorado!', true, false);

$solution = WC_CryptoChall::generateSolution('YouAreNotLeanorado!', true, false);

$path = lsb_gen_image($solution);

$href = 'http://wechall.blogspot.com/2007/11/steganabara-explained.html';
$hidden_hint = sprintf('<p style="color: #eee;">Hidden Hint: %s</p>', $href);

$thx = 'buttmonkey';
if (false !== ($user = GWF_User::getByName($thx))) {
	$thx = $user->displayProfileLink();
}
echo GWF_Box::box($chall->lang('info', array($hidden_hint, $thx)), $chall->lang('title'));

$title = $chall->lang('img_title');
$htmlimg = sprintf('<img src="%s%s" alt="%s" title="%s" width="480" height="212" />', GWF_WEB_ROOT, $path, $title, $title);
echo GWF_Box::box($htmlimg, $title);


formSolutionbox($chall);
echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
