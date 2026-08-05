<?php
$secret = require 'secret.php';
chdir('../../../');
define('GWF_PAGE_TITLE', "ChATTACA");
require_once('challenge/html_head.php');
require(GWF_CORE_PATH.'module/WeChall/solutionbox.php');
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
    $chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 3, 'challenge/gizmore/chattaca/index.php', $secret);
}

$chall->showHeader();

$chall->onCheckSolution();

$user = GWF_User::getStaticOrGuest();
$name = $user->isGuest() ? 'hacker' : $user->displayUsername();
$url = 'https://mira-gpt.org';
$telegramURL = 'https://t.me/+rankW0nN_ig4OGEy';
$discordURL = 'https://discord.gg/ftWTRs3QQG';
$ircURL = 'ircs://irc.wechall.net:6697/#mira';

$info = $chall->lang('info', array($name, $url, $telegramURL, $discordURL, $ircURL));
$title = $chall->lang('title');
echo GWF_Box::box($info, $title);
formSolutionbox($chall);
echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
