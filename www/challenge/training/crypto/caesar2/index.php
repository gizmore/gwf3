<?php
chdir("../../../../");
define('GWF_PAGE_TITLE', 'Training: Crypto - Caesar II');
require_once("challenge/html_head.php");
require_once GWF_CORE_PATH.'module/WeChall/solutionbox.php';
require_once GWF_CORE_PATH.'module/WeChall/WC_CryptoChall.php';
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE))) {
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 1, 'challenge/training/crypto/caesar2/index.php');
}
$chall->showHeader();

$SOLUTION = require_once 'challenge/training/crypto/caesar2/secret.php';
WC_CryptoChall::checkSolution($chall, $SOLUTION, true, true);

echo GWF_Box::box($chall->lang('info'), $chall->lang('title'));

echo GWF_Box::box(crypto_caesar_2_ciphertext($chall));

formSolutionbox($chall);

$chall->copyrightFooter();
require_once("challenge/html_foot.php");
?>
<?php 
function crypto_caesar_2_ciphertext(WC_Challenge $chall)
{
	global $SOLUTION;
	
	WC_CryptoChall::checkPlaintext($chall->lang('plaintext'), true);
	
	$solution = WC_CryptoChall::generateSolution($SOLUTION, true, true);
	$pt = $chall->lang('plaintext', array($solution));
//	$pt = strtoupper($pt);
//	$pt = preg_replace('/[^A-Z]/', '', $pt);
	$ct = crypto_caesar_2_encrypt($pt);
	return WC_CryptoChall::hexdump($ct);
}

function crypto_caesar_2_encrypt($pt)
{
	$a = 0;
	$ct = '';
	$key = rand(1, 127);
	$len = strlen($pt);
	for ($i = 0; $i < $len; $i++)
	{
		$c = $pt{$i};
		if ($c === ' ') {
			$ct .= $c;
		} else {
			$ord = ord($c) - $a;
			$ct .= chr((($ord+$key)%128)+$a);
		}
	}
	return $ct;
}
?>
