<?php
chdir("../../../../");
define('GWF_PAGE_TITLE', 'Training: Crypto - Digraphs');
require_once("challenge/html_head.php");
require_once GWF_CORE_PATH.'module/WeChall/solutionbox.php';
require_once GWF_CORE_PATH.'module/WeChall/WC_CryptoChall.php';
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE))) {
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 1, 'challenge/training/crypto/digraph/index.php');
}
$chall->showHeader();

$SOLUTION = require_once 'training/crypto/digraph/secret.php';
WC_CryptoChall::checkSolution($chall, $SOLUTION, true, true);

echo GWF_Box::box($chall->lang('info'), $chall->lang('title'));

echo GWF_Box::box(crypto_dig1_ciphertext($chall));

formSolutionbox($chall);

echo $chall->copyrightFooter();
require_once("challenge/html_foot.php");
?>
<?php 
function crypto_dig1_ciphertext(WC_Challenge $chall)
{
	WC_CryptoChall::checkPlaintext($chall->lang('plaintext'), true);
	
	$solution = WC_CryptoChall::generateSolution($SOLUTION, true,  true);
	$pt = $chall->lang('plaintext', array($solution));
	$ct = crypto_dig1_encrypt($pt);
	return $ct;
}

function crypto_dig1_encrypt($pt)
{
	$map = array();
	$ct = '';
	$len = strlen($pt);
	for ($i = 0; $i < $len; $i++)
	{
		$c = $pt{$i};
		if ($c === ' ') {
			$ct .= ' ';
		} else {
			if (!isset($map[$c])) {
				$map = crypto_dig1_map($map, $c);
			}
			$ct .= $map[$c];
		}
	}
	return $ct;
}

function crypto_dig1_map(array &$map, $c)
{
	while (true)
	{
		$m = GWF_Random::randomKey(2, 'abcdefghijklmnopqrstuvwxyz');
		if (!in_array($m, $map))
		{
			$map[$c] = $m;
			break;
		}
	}
	return $map;
}
?>
