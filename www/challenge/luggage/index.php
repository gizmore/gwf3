<?php
$SOLUTION = require 'secret.php';
chdir("../../");
define('GWF_PAGE_TITLE', 'Luggage');
require_once ("challenge/html_head.php");
require_once GWF_CORE_PATH . 'module/WeChall/solutionbox.php';
require_once GWF_CORE_PATH . 'module/WeChall/WC_CryptoChall.php';
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE))) {
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 2, 'challenge/luggage/index.php', $SOLUTION);
}

$chall->showHeader();
$sid = GWF_Session::getSessSID();


if ($sid == 0) {
	echo GWF_HTML::error($chall->getTitle(), $chall->lang('err_sessid'));
}

if (isset($_POST['answer'])) {
	if (false !== ($error = $chall->isAnswerBlocked(GWF_User::getStaticOrGuest()))) {
		echo $error;
	} else {
		$solution = $SOLUTION($chall);
		if (strtolower((string) $_POST['answer']) === strtolower($solution)) {
			echo GWF_HTML::message($chall->lang('title'), $chall->lang('sucess_msg'));
			$chall->onChallengeSolved();
		} else {
			echo GWF_HTML::error($chall->lang('title'), $chall->lang('err_wrong'));
		}
	}
}


$do_highlight = Common::getGetString('highlight') === 'christmas';
$qr_details = getQrDetails($chall);
$dateTimeString = GWF_Time::displayTimestamp($qr_details[2], false, false);

if ($do_highlight) {
	$code = GWF_Message::display(' [PHP title=collectedSamples.json]' . file_get_contents('challenge/luggage/qr_codes.include') . '[/code]', true, false, false, array());
	$toggleButtonText = $chall->lang('collapseButton');
	$toggleButtonLink = '?';
} else {
	$code = '';
	$toggleButtonText = $chall->lang('expandButton');
	$toggleButtonLink = '?highlight=christmas';
}

$username = 'Hacker';
$user = GWF_User::getStaticOrGuest();
if (!$user->isGuest())
{
	$username = $user->displayUsername();
}

echo GWF_Box::box($chall->lang('info', array($code, $toggleButtonText, $toggleButtonLink, $dateTimeString, $qr_details[0], $qr_details[1], $username)), $chall->lang('title'));

formSolutionbox($chall);

echo $chall->copyrightFooter();
require_once ("challenge/html_foot.php");
?>


<?php

function getQrDetails(WC_Challenge $chall)
{
	$qr_seed = WC_CryptoChall::generateSolution('FooBarley', true, true, 4);

	$locker = (ord($qr_seed[0]) % 30) + 1;
	$row = (ord($qr_seed[1]) % 20) + 1;
	// TODO: Check if this logic works when challange is installed. (I cant install the challenge)
	if (false !== (WC_Challenge::getByTitle(GWF_PAGE_TITLE))) {
		$raw_time = GWF_Time::getTimestamp($chall->getDate()) - 3600 * 24 * 30 * (ord($qr_seed[2]) % 12) - ord($qr_seed[0]) * 60 + ord($qr_seed[1]);
	} else {
		$raw_time = 1716669785 - 3600 * 24 * 30 * (ord($qr_seed[2]) % 12) - ord($qr_seed[0]) * 60 + ord($qr_seed[1]);
	}
	return [$locker, $row, $raw_time];
}


?>