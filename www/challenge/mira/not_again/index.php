<?php
$plaintext = require 'secred.php';
$solution = get_rect_or_die_trying($plaintext);
chdir('../../../');
define('GWF_PAGE_TITLE', "NotAgain");
require_once('challenge/html_head.php');
require(GWF_CORE_PATH.'module/WeChall/solutionbox.php');
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
    $chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 8, 'challenge/mira/not_again/index.php', $solution);
}

$chall->showHeader();

$chall->onCheckSolution();

echo "<!-- Shouts go out to all veterans -->";
$compatible = compatible($plaintext);
$encoded = morse_encode($compatible);
$evil = make_it_pure_evil($encoded);
echo "<!-- If your Agent solved this... wow! -->";

$at_least_i_got_these_code_tags = sprintf('<code style="word-wrap: break-word!important; white-space: break-spaces!important; width: 42%%!important; display: block!important; margin: 37px!important;">%s</code>', $evil);
$css_master = false;

$user = GWF_User::getStaticOrGuest();
$info = $chall->lang('info', array($user->displayUsername(), $at_least_i_got_these_code_tags));
$title = $chall->lang('title');
echo GWF_Box::box($info, $title);
formSolutionbox($chall);
echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
