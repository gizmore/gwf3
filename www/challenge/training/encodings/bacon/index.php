<?php
chdir('../../../../');
define('GWF_PAGE_TITLE', 'Training: Baconian');
require_once('challenge/html_head.php');
require_once GWF_CORE_PATH.'module/WeChall/WC_CryptoChall.php';
require_once GWF_CORE_PATH.'module/WeChall/solutionbox.php';
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE))) {
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 2, 'challenge/training/encodings/bacon/index.php', false);
}
$chall->showHeader();

if (isset($_POST['answer']) && is_string($_POST['answer'])) {
	$_POST['answer'] = strtoupper($_POST['answer']);
}
$SOLUTION = require_once 'challenge/training/encodings/bacon/secret.php';
WC_CryptoChall::checkSolution($chall, $SOLUTION, true, false);

echo GWF_Box::box($chall->lang('info'), $chall->lang('title'));

$hidden = bacon_prepare_hidden($chall);

if (true === bacon_check_messages($chall, $hidden))
{
	echo GWF_Box::box(bacon_encode($chall, $hidden), $chall->lang('msg_title'));
}

formSolutionbox($chall);

echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');

function bacon_prepare_hidden(WC_Challenge $chall)
{
	global $SOLUTION;
	
	$solution = WC_CryptoChall::generateSolution($SOLUTION, true, false);
	$hidden = $chall->lang('hidden', array($solution));
	$hidden = str_replace(' ', 'X', $hidden);
	$hidden = strtoupper($hidden).'XX';
	
	return $hidden;
}

function bacon_count_chars($s)
{
	$count = 0;
	$len = strlen($s);
	for ($i = 0; $i < $len; $i++)
	{
		$c = $s{$i};
		if ( ($c >= 'A' && $c <= 'Z') || ($c >= 'a' && $c <= 'z') )
		{
			$count++;
		}
	}
	return $count;
}

function bacon_check_messages(WC_Challenge $chall, $hidden)
{
	$chars = bacon_count_chars($hidden);
	$bits = $chars * 5;
	$avail = bacon_count_chars($chall->lang('message'));
	
	if ($bits > $avail) {
		echo GWF_HTML::error('Bacon', "The carrier message is too short: Need $bits bits and have only $avail available.", false);
		return false;
	}
	return true;
}

function bacon_encode(WC_Challenge $chall, $hidden)
{
	$message = strtolower($chall->lang('message'));
	$len = strlen($hidden);
	$pos = -1;
	$a = ord('A');
	for ($i = 0; $i < $len; $i++)
	{
		$c = ord($hidden{$i});
		$bin = decbin($c-$a);
		$bin = sprintf('%05d', $bin);
		
		for ($j = 0; $j < 5; $j++)
		{
			$pos = bacon_next_pos($message, $pos);
			if ($bin{$j} === '1') {
				$message{$pos} = strtoupper($message{$pos});
			}
		}
	}
	
	$pos++;
	
	$len = strlen($message);
	while ($pos < $len)
	{
		$message{$pos} = strtoupper($message{$pos});
		$pos += 2;
	}
	
	return $message;
}

function bacon_next_pos($s, $pos)
{
	do {
		$pos++;		
	} while (!bacon_is_letter($s{$pos}));
	return $pos;
}

function bacon_is_letter($c)
{
	return $c >= 'a' && $c <= 'z';
}
?>
