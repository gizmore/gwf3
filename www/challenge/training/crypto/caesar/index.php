<?php
chdir("../../../../");
define('GWF_PAGE_TITLE', 'Training: Crypto - Caesar I');
require_once("challenge/html_head.php");
require_once GWF_CORE_PATH.'module/WeChall/solutionbox.php';
require_once GWF_CORE_PATH.'module/WeChall/WC_CryptoChall.php';
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE))) {
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 1, 'challenge/training/crypto/caesar/index.php');
}
$chall->showHeader();

$SOLUTION = require_once 'challenge/training/crypto/caesar/secret.php';

WC_CryptoChall::checkSolution($chall, $SOLUTION, true, true);

echo GWF_Box::box($chall->lang('info'), $chall->lang('title'));

echo GWF_Box::box(crypto_caesar_1_ciphertext($chall));

formSolutionbox($chall);

echo $chall->copyrightFooter();
require_once("challenge/html_foot.php");
?>
<?php 
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
	for ($i = 0; $i < $len; $i++)
	{
		$c = $pt[$i];
		if ($c === ' ') {
			$ct .= ' ';
		} else {
			$ord = ord($c) - $a;
			$ct .= chr((($ord+$key)%26)+$a);
		}
	}
	return $ct;
}
?>
