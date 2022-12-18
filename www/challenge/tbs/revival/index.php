<?php
$coolPeople = require 'secret_carrier_message.php';
require 'lib.php';
chdir('../../../');
define('GWF_PAGE_TITLE', "Tribal Revival");
require_once('challenge/html_head.php');
require(GWF_CORE_PATH.'module/WeChall/solutionbox.php');
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 5, 'challenge/tbs/revival/index.php', false);
}

$chall->showHeader();

if (isset($_POST['answer']))
{
	if ($error = $chall->isAnswerBlocked(GWF_User::getStaticOrGuest()))
	{
		echo $error;
	}
	elseif (check_tbs_solution($_POST['answer']))
	{
		$chall->onChallengeSolved();
	}
	else
	{
		echo GWF_HTML::error($chall->getTitle(), $chall->lang('err_wrong', GWF_Random::arrayItem($coolPeople)));
	}
}
$user = GWF_User::getStaticOrGuest();
$name = $user->isGuest() ? 'hacker' : $user->displayUsername();
$message = get_tbs_message();
list($encoded, $carrier) = tbs_encode($message, $coolPeople);
$info = $chall->lang('info', array($name, $message, $carrier, $encoded));
$title = $chall->lang('title');
echo GWF_Box::box($info, $title);
formSolutionbox($chall);
echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
