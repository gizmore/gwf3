<?php
$secret = require 'secret.php';
chdir('../../../');
define('GWF_PAGE_TITLE', "PyHash");
require_once('challenge/html_head.php');
require(GWF_CORE_PATH.'module/WeChall/solutionbox.php');
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
    $chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 1, 'challenge/python/pyhash/index.php', $secret[1]);
}

$chall->showHeader();

if (isset($_POST['answer']))
{
    if ($_POST['answer'] == $secret[0])
    {
        echo GWF_HTML::error($chall->getTitle(), $chall->lang('err_too_easy'));
    }
    else
    {
        $chall->onCheckSolution();
    }
}

$user = GWF_User::getStaticOrGuest();
$name = $user->isGuest() ? 'hacker' : $user->displayUsername();
$info = $chall->lang('info', array($name));
$title = $chall->lang('title');
echo GWF_Box::box($info, $title);
formSolutionbox($chall);
echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
