<?php
chdir("../../../../");
define('GWF_PAGE_TITLE', 'Training: Crypto - Substitution II');
require_once("challenge/html_head.php");
require_once GWF_CORE_PATH.'module/WeChall/solutionbox.php';
require_once GWF_CORE_PATH.'module/WeChall/WC_CryptoChall.php';
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE))) {
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 2, 'challenge/training/crypto/simplesub2/index.php');
}
$chall->showHeader();

WC_CryptoChall::checkSolution($chall, 'The_GHttttttEEEEZZ', true, true);

echo GWF_Box::box($chall->lang('info'), $chall->lang('title'));

echo GWF_Box::box(crypto_sub2_ciphertext($chall));

formSolutionbox($chall);

$chall->copyrightFooter();
require_once("challenge/html_foot.php");
?>
<?php 
function crypto_sub2_ciphertext(WC_Challenge $chall)
{
	WC_CryptoChall::checkPlaintext($chall->lang('plaintext'), true);
	
	$solution = WC_CryptoChall::generateSolution('The_GHttttttEEEEZZ', true, true);
	$chars1 = array();
	for ($i = 0; $i < 256; $i++) { $chars1[] = chr($i); }
	$chars2 = array();
	for ($i = 0; $i < 256; $i++) { $chars2[] = chr($i); }
	shuffle($chars1);
	shuffle($chars2);

	$map = array();
	for ($i = 0; $i < 256; $i++)
	{
		$map[$chars1[$i]] = $chars2[$i];
	}
	
	$pt = $chall->lang('plaintext', array($solution));
	$ct = crypto_sub2_encrypt($pt, $map);
	return WC_CryptoChall::hexdump($ct);
}

function crypto_sub2_encrypt($pt, array $map)
{
	$ct = '';
	$len = strlen($pt);
	for ($i = 0; $i < $len; $i++)
	{
		$c = $pt{$i};
		if ($c === ' ') {
			$ct .= ' ';
		} else {
			$ct .= $map[$c];
		}
	}
	return $ct;
}
?>