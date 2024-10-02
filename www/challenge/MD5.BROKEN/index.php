<?php
$scrambler = require 'secret.php';
chdir('../../');
define('GWF_PAGE_TITLE', "MD5 Broken");
require_once('challenge/html_head.php');
require(GWF_CORE_PATH.'module/WeChall/solutionbox.php');
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
    $chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 4, 'challenge/MD5.BROKEN/index.php', false);
}
$chall->showHeader();
$user = GWF_User::getStaticOrGuest();
require '../core/module/WeChall/WC_CryptoChall.php';
$solution = WC_CryptoChall::generateSolution('MD5.BROKE', true, true, 7);
$hash = $scrambler($solution);

if (isset($_POST['answer'])) {
    if (false !== ($error = $chall->isAnswerBlocked($user))) {
        echo $error;
    } else {
        if (strtolower((string) $_POST['answer']) === strtolower($solution)) {
            echo GWF_HTML::message($chall->lang('title'), $chall->lang('sucess_msg'));
            $chall->onChallengeSolved();
        } else {
            echo GWF_HTML::error($chall->lang('title'), $chall->lang('err_wrong'));
        }
    }
}

$name = $user->isGuest() ? 'hacker' : $user->displayUsername();
$info = $chall->lang('info', array($name, $hash));
$title = $chall->lang('title');
echo GWF_Box::box($info, $title);
formSolutionbox($chall);
echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
