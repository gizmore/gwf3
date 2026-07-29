<?php
$plaintext = require 'secred.php';
$solution = get_rect_or_die_trying($plaintext);
chdir('../../../');
define('GWF_PAGE_TITLE', "NotAgain");
require_once('challenge/html_head.php');
require(GWF_CORE_PATH.'module/WeChall/solutionbox.php');
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
    $chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 2, 'challenge/mira/errection/index.php', $solution);
}

$chall->showHeader();

$chall->onCheckSolution();

echo "<!-- Shouts go out to all veterans -->";
$compatible = compatible($plaintext);
$encoded = morse_encode($compatible);
$evil = make_it_pure_evil($encoded);
$compatible = emulator($plaintext);
$encoded = morse_encode($compatible);
$evil = make_it_pure_evil($encoded);
echo "<!-- If your Agent solved this... wow! -->";

$user = GWF_User::getStaticOrGuest();
$info = $chall->lang('info', array($user->displayUsername(), $evil));
$title = $chall->lang('title');
echo GWF_Box::box($info, $title);
formSolutionbox($chall);
echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
