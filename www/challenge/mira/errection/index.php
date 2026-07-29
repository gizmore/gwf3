<?php
$sol = require 'secred.php';
$text = require 'secret.php';
chdir('../../../');
define('GWF_PAGE_TITLE', "Errection");
require_once('challenge/html_head.php');
require(GWF_CORE_PATH.'module/WeChall/solutionbox.php');
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
    $chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 2, 'challenge/mira/errection/index.php', calculator($sol));
}

$chall->showHeader();

$chall->onCheckSolution();

$user = GWF_User::getStaticOrGuest();
$text = sprintf('<code style="width: 23.42%%">%s</code>', $text);
$info = $chall->lang('info', array($text));
$title = $chall->lang('title');

echo GWF_Box::box($info, $title);

echo "<!-- DEDICATED TO https://www.you"."tube.com/watch?v=yYMQpDCVYBo -->\n";

formSolutionbox($chall);

echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
