<?php
$secret = require 'secret.php';
chdir('../../');
define('GWF_PAGE_TITLE', "Gid Gud");
require_once('challenge/html_head.php');
require(GWF_CORE_PATH.'module/WeChall/solutionbox.php');
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
    $chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 4, 'challenge/gidgud/index.php', false);
}

$chall->showHeader();

$sid = GWF_Session::getSessSID();
$hash = md5($sid.$secret.$secret.$sid);
$url = 'https://gidgud.wechall.net?sessid=' . $sid . '&sessh=' . $hash;

if (isset($_POST['answer']))
{
    if (false !== ($error = $chall->isAnswerBlocked(GWF_User::getStaticOrGuest())))
    {
        echo $error;
    }
    else
    {
        $solution = md5($sid.$secret.$sid.$secret.$sid);
        if ( strtolower((string)$_POST['answer']) === strtolower($solution))
        {
            $chall->onChallengeSolved();
        }
        else
        {
            echo GWF_HTML::error('Gid Gud', $chall->lang('err_wrong'));
        }
    }
}


$user = GWF_User::getStaticOrGuest();
$name = $user->isGuest() ? 'hacker' : $user->displayUsername();
$info = $chall->lang('info', array($name, $url));
$title = $chall->lang('title');
echo GWF_Box::box($info, $title);
formSolutionbox($chall);
echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
