<?php
chdir("../../../");
define('GWF_PAGE_TITLE', 'QR Codes');
require_once ("challenge/html_head.php");
require_once GWF_CORE_PATH . 'module/WeChall/solutionbox.php';
require_once GWF_CORE_PATH . 'module/WeChall/WC_CryptoChall.php';
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE))) {
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 1, 'challenge/magicchallenge/qr_codes/index.php');
}
$chall->showHeader();


$SOLUTION = require_once 'challenge/magicchallenge/qr_codes/secret.php';

$do_highlight = Common::getGetString('highlight') === 'christmas';

$code = '';

if ($do_highlight) {
	$code = GWF_Message::display(' [PHP title=collectedSamples.json]' . file_get_contents('challenge/magicchallenge/qr_codes/qr_codes.include') . '[/code]', true, false, false, array());
	$toggleButtonText = $chall->lang('collapseButton');
	$toggleButtonLink = '?';
} else {
	$toggleButtonText = $chall->lang('expandButton');
	$toggleButtonLink = '?highlight=christmas';
}

WC_CryptoChall::checkSolution($chall, $SOLUTION, true, true);


$qr_details = get_qr_details($chall);

$dateTimeString = GWF_Time::displayTimestamp($qr_details[2], false, false);

echo GWF_Box::box($chall->lang('info', array($code, $toggleButtonText, $toggleButtonLink, $dateTimeString, $qr_details[0], $qr_details[1])), $chall->lang('title'));


formSolutionbox($chall);

echo $chall->copyrightFooter();
require_once ("challenge/html_foot.php");
?>





<?php

function get_qr_details(WC_Challenge $chall)
{
	global $SOLUTION;
	$qr_seed = WC_CryptoChall::generateSolution($SOLUTION, true, true, 4);

	$locker = (ord($qr_seed[0]) % 30) + 1;
	$row = (ord($qr_seed[1]) % 20) + 1;
	$raw_time = GWF_Time::getTimestamp($chall->getDate()) - 3600 * 24 * 30 * (ord($qr_seed[2]) % 12) - ord($qr_seed[0]) * 60 + ord($qr_seed[1]);
	return [$locker, $row, $raw_time];
}
function crypto_caesar_1_ciphertext(WC_Challenge $chall)
{
	global $SOLUTION;
	WC_CryptoChall::checkPlaintext(strtoupper($chall->lang('plaintext')));

	$solution = WC_CryptoChall::generateSolution($SOLUTION, true, true);
	$pt = $chall->lang('plaintext', array($solution));
	$pt = strtoupper($pt);
	$pt = preg_replace('/[^A-Z ]/', '', $pt);
	$ct = crypto_caesar_1_encrypt($pt);
	return $ct;
}

function crypto_caesar_1_encrypt($pt)
{
	$a = ord('A');
	$ct = '';
	$key = rand(1, 25);
	$len = strlen($pt);
	for ($i = 0; $i < $len; $i++) {
		$c = $pt[$i];
		if ($c === ' ') {
			$ct .= ' ';
		} else {
			$ord = ord($c) - $a;
			$ct .= chr((($ord + $key) % 26) + $a);
		}
	}
	return $ct;
}
?>