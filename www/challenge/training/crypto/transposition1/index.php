<?php
chdir("../../../../");
define('GWF_PAGE_TITLE', 'Training: Crypto - Transposition I');
require_once("challenge/html_head.php");
require_once GWF_CORE_PATH.'module/WeChall/solutionbox.php';
require_once GWF_CORE_PATH.'module/WeChall/WC_CryptoChall.php';
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE))) {
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 1, 'challenge/training/crypto/transposition1/index.php');
}
$chall->showHeader();

$SOLUTION = require_once 'challenge/training/crypto/transposition1/secret.php';
WC_CryptoChall::checkSolution($chall, $SOLUTION, true, true);

echo GWF_Box::box($chall->lang('info'), $chall->lang('title'));

echo GWF_Box::box(crypto_trans1_ciphertext($chall));

formSolutionbox($chall);

$chall->copyrightFooter(); 
require_once("challenge/html_foot.php");
?>
<?php 
function crypto_trans1_ciphertext(WC_Challenge $chall)
{
	WC_CryptoChall::checkPlaintext($chall->lang('plaintext'), true, true);
	
	$solution = WC_CryptoChall::generateSolution($SOLUTION, true, true);
	$pt = $chall->lang('plaintext', array($solution));
	$ct = crypto_trans1_encrypt($pt);
	$ct = str_replace(' ', '&nbsp;', $ct);
	return $ct;
}

function crypto_trans1_encrypt($pt)
{
	$len = strlen($pt);
	if (($len%2)==1) {
		$pt .= 'X';
		$len++;
	}
	$i = 0;
	$ct = '';
	while ($i < $len)
	{
		$ct .= $pt{$i+1};
		$ct .= $pt{$i};
		$i += 2;
	}
	return $ct;
}
?>
