<?php
chdir("../../../../");
define('GWF_PAGE_TITLE', 'Training: Crypto - Substitution I');
require_once("challenge/html_head.php");
require_once GWF_CORE_PATH.'module/WeChall/solutionbox.php';
require_once GWF_CORE_PATH.'module/WeChall/WC_CryptoChall.php';
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE))) {
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 1, 'challenge/training/crypto/simplesub1/index.php');
}
$chall->showHeader();

$SOLUTION = require_once 'challenge/training/crypto/simplesub1/secret.php';
WC_CryptoChall::checkSolution($chall, $SOLUTION, true, true);

echo GWF_Box::box($chall->lang('info'), $chall->lang('title'));

echo GWF_Box::box(crypto_sub1_ciphertext($chall));

formSolutionbox($chall);

$chall->copyrightFooter();
require_once("challenge/html_foot.php");
?>
<?php 
function crypto_sub1_ciphertext(WC_Challenge $chall)
{
	global $SOLUTION;
	
	WC_CryptoChall::checkPlaintext(strtolower($chall->lang('plaintext')), true, true);
	
	$solution = WC_CryptoChall::generateSolution($SOLUTION, true);
//	var_dump($solution);
	$chars1 = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
	$chars2 = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
	shuffle($chars1);
	shuffle($chars2);

	$map = array();
	for ($i = 0; $i < 26; $i++)
	{
		$map[$chars1[$i]] = $chars2[$i];
	}
	
	$pt = $chall->lang('plaintext', array($solution));
	$pt = strtoupper($pt);
	$pt = preg_replace('/[^A-Z ]/', '', $pt);
	
	$ct = crypto_sub1_encrypt($pt, $map);
	
	return $ct;
}

function crypto_sub1_encrypt($pt, array $map)
{
	$ct = '';
	$len = strlen($pt);
	for ($i = 0; $i < $len; $i++)
	{
		$c = $pt[$i];
		if ($c === ' ') {
			$ct .= ' ';
		} else {
			$ct .= $map[$c];
		}
	}
	return $ct;
}
?>
