<?php
$solution = require 'secret.php';
chdir('../../');
define('GWF_PAGE_TITLE', "No Action");

require_once('challenge/html_head.php');
require(GWF_CORE_PATH . 'module/WeChall/solutionbox.php');
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
    $chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 1, 'challenge/no_action/indice.php', $solution);
}

$chall->showHeader();

$chall->onCheckSolution();

$user = GWF_User::getStaticOrGuest();
$name = $user->isGuest() ? 'hacker' : $user->displayUsername();
$info = $chall->lang('info', array($name));
$title = $chall->lang('title');
echo GWF_Box::box($info, $title);

?>
<!-- THE FORM: <form action="?"> -->
<?php

echo formSolutionbox($chall);

echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
