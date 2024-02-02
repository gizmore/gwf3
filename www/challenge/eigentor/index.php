<?php
chdir('../../');
define('GWF_PAGE_TITLE', "Eigentor");
require_once('challenge/html_head.php');
require(GWF_CORE_PATH.'module/WeChall/solutionbox.php');
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
    $chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 1, 'challenge/eigentor/index.php', false);
}

$chall->showHeader();

if (isset($_POST['answer']))
{
    $answer = (string) $_POST['answer'];
    $url = "https://es-land.net/torchallenge;trytoken.json?token=".$answer;
    $result = GWF_HTTP::getFromURL($url);
    $response = json_decode($result, true);
    if (!isset($response['status']))
    {
        echo GWF_HTML::error('Eigentor', $response[0]);
    }
    else
    {
        switch ($response['status'])
        {
            case 0:
                echo GWF_HTML::error('Eigentor', $chall->lang('err_wrong'));
                break;
            case 1:
                $chall->onChallengeSolved();
                break;
            case 2:
                echo GWF_HTML::error('Eigentor', $chall->lang('err_used'));
                break;
        }
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
