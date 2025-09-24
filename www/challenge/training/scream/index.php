<?php
$secret = require 'secret.php';
chdir('../../../');
define('GWF_PAGE_TITLE', "Scream!");
require_once('challenge/html_head.php');
require(GWF_CORE_PATH.'module/WeChall/solutionbox.php');
require(GWF_CORE_PATH.'module/WeChall/WC_CryptoChall.php');
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
    $chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 3, 'challenge/training/scream/index.php', false);
}

$chall->showHeader();

$user = GWF_User::getStaticOrGuest();
$name = $user->isGuest() ? 'hacker' : $user->displayUsername();
srand(crc32($name));
shuffle($secret['alphabet']);
$solution = WC_CryptoChall::generateSolution('nice', true);
$ct = sprintf($secret['en'], $name, $solution);
$ct = encrypt($ct, $secret['alphabet']);

if (isset($_POST['answer']))
{
    if (false !== ($error = $chall->isAnswerBlocked($user)))
    {
        echo $error;
    }
    else
    {
        if ( strtolower((string)$_POST['answer']) === strtolower($solution))
        {
            $chall->onChallengeSolved();
        }
        else
        {
            echo GWF_HTML::error('Scream!', $chall->lang('err_wrong'));
        }
    }
}

$info = $chall->lang('info', array($name, $ct));
$title = $chall->lang('title');
echo GWF_Box::box($info, $title);
formSolutionbox($chall);
echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
